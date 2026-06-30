<?php

namespace App\Http\Controllers;

use App\Mail\PurchaseConfirmation;
use App\Models\Package;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the package selector / cashier page.
     */
    public function index(Request $request)
    {
        $packages = Package::active()->where('price', '>', 0)->reorder()->orderBy('price')->get();
        $selected = Package::where('slug', $request->query('package'))->first();

        $currentSub  = $request->user()->activeSubscription()?->load('package');
        $currentStars = $currentSub?->max_stars ?? 0;

        return view('subscriber.cashier', [
            'packages'          => $packages,
            'selectedPackageId' => $selected?->id,
            'stripeConfigured'  => (bool) config('services.stripe.secret'),
            'currentSub'        => $currentSub,
            'currentStars'      => $currentStars,
        ]);
    }

    /**
     * Create a Stripe Checkout Session for the selected package and redirect there.
     */
    public function createSession(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $package = Package::active()->where('price', '>', 0)->findOrFail($request->package_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'customer_email' => $request->user()->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => (int) round($package->price * 100),
                    'product_data' => [
                        'name' => 'INSPIN — ' . $package->name . ' Package',
                        'description' => $package->duration . ' access to INSPIN picks and content. One-time charge, no auto-renewal.',
                    ],
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('cashier.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cashier.cancel'),
            'metadata' => [
                'user_id' => $request->user()->id,
                'package_id' => $package->id,
            ],
        ]);

        return redirect($session->url);
    }

    /**
     * Stripe redirects here after a successful Checkout Session.
     */
    public function success(Request $request)
    {
        $request->validate(['session_id' => 'required|string']);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::retrieve($request->session_id);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('cashier')->with('error', 'Payment was not completed.');
        }

        $package = Package::findOrFail($session->metadata->package_id);

        // Map package slug → max_stars so pick access is correct after purchase
        $starsMap = [
            'free-trial'  => 1,
            '1-week'      => 2,
            '2-weeks'     => 3,
            '2-months'    => 4,
            'monthly'     => 4,
            'quarterly'   => 5,
            'semi-annual' => 5,
            '9-months'    => 7,
            '12-months'   => 10,
            'whale-package' => 10,
        ];
        $maxStars = $starsMap[$package->slug] ?? 4;

        $userPackage = UserPackage::firstOrCreate(
            ['stripe_checkout_session_id' => $session->id],
            [
                'user_id' => $session->metadata->user_id,
                'package_id' => $package->id,
                'starts_at' => now(),
                'expires_at' => now()->addDays($package->duration_days),
                'is_active' => true,
                'max_stars' => $maxStars,
                'stripe_customer_id' => $session->customer,
                'stripe_payment_intent_id' => $session->payment_intent,
                'amount_paid' => $session->amount_total / 100,
            ]
        );

        $userPackage->loadMissing('package', 'user');

        try {
            Mail::to($userPackage->user->email)->send(new PurchaseConfirmation($userPackage));
        } catch (\Throwable $e) {
            Log::warning('Purchase confirmation email failed: ' . $e->getMessage());
        }

        return view('subscriber.cashier-success', ['userPackage' => $userPackage]);
    }

    public function cancel()
    {
        return redirect()->route('cashier')->with('error', 'Checkout was cancelled — no charge was made.');
    }
}

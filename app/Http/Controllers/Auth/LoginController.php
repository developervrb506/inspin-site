<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if ($request->has('redirect')) {
            session()->put('url.intended', $request->query('redirect'));
        }
        return redirect('/');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Rate limit: max 5 attempts per minute per email+IP combination
        $throttleKey = Str::lower($request->input('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            if ($request->wantsJson() || $request->acceptsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Too many login attempts. Please try again in {$seconds} seconds.",
                ], 429);
            }

            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($throttleKey); // Reset counter on success

            $user = Auth::user();
            $redirectTo = $user->role === 'admin' ? route('dashboard') : route('subscriber.dashboard');

            if ($request->wantsJson() || $request->acceptsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Login successful.',
                    'redirect' => $redirectTo,
                ]);
            }

            return redirect()->intended($redirectTo);
        }

        // Increment failed attempt counter
        RateLimiter::hit($throttleKey, 60); // decay 60 seconds

        if ($request->wantsJson() || $request->acceptsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong email or password. Please try again.',
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Wrong email or password. Please try again.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

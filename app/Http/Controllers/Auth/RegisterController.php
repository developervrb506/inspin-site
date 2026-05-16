<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return redirect('/');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
        ]);

        // Send verification email — do NOT log in yet
        $user->sendEmailVerificationNotification();

        if ($request->wantsJson() || $request->acceptsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Account created! Please check your email and click the verification link before logging in.',
                'redirect' => '/?registered=1',
            ]);
        }

        return redirect('/')->with('success', 'Account created! Please check your email to verify your account.');
    }
}

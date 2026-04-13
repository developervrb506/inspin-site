@extends('layouts.auth')

@section('title', 'Reset Password - INSPIN')

@section('content')
<div class="auth-form-header">
    <div class="auth-icon">
        <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
        </svg>
    </div>
    <h1>Set New Password</h1>
    <p>Choose a strong password you haven't used before.</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <svg style="flex-shrink:0;width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        {{ $errors->first() }}
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success">
        <svg style="flex-shrink:0;width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" placeholder="you@example.com" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your new password" required>
    </div>

    <button type="submit" class="btn-submit">Reset Password</button>
</form>

<div class="auth-footer">
    Remember your password? <a href="{{ route('login') }}">Back to sign in</a>
</div>
@endsection

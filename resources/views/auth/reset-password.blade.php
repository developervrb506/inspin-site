@extends('layouts.auth')

@section('title', 'Reset Password - INSPIN')

@section('content')
<div class="auth-form-header">
    <h1>Set New Password</h1>
    <p>Enter your new password below.</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" placeholder="you@example.com" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" placeholder="Enter new password" required>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
    </div>

    <button type="submit" class="btn-submit">Reset Password</button>
</form>

<div class="auth-footer">
    Remember your password? <a href="{{ route('login') }}">Back to sign in</a>
</div>
@endsection
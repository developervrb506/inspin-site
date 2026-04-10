@extends('layouts.auth')

@section('title', 'Sign In - INSPIN')

@section('content')
<div class="auth-form-header">
    <h1>Sign In</h1>
    <p>Welcome back! Enter your credentials to access your account.</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <div class="form-options">
        <label>
            <input type="checkbox" id="remember" name="remember">
            Remember me
        </label>
        <a href="{{ route('password.request') }}">Forgot password?</a>
    </div>
    <button type="submit" class="btn-submit">Sign In</button>
</form>

<div class="auth-footer">
    Don't have an account? <a href="{{ route('register') }}">Create one now</a>
</div>
@endsection

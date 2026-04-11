@extends('layouts.auth')

@section('title', 'Forgot Password - INSPIN')

@section('content')
<div class="auth-form-header">
    <h1>Forgot Password</h1>
    <p>Enter your email and we'll send you a password reset link.</p>
</div>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
    </div>
    <button type="submit" class="btn-submit">Send Reset Link</button>
</form>

<div class="auth-footer">
    Remember your password? <a href="{{ route('home') }}">Back to sign in</a>
</div>
@endsection

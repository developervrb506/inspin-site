@extends('layouts.auth')

@section('title', 'Create Account - INSPIN')

@section('content')
<div class="auth-form-header">
    <h1>Create Account</h1>
    <p>Join the Winner's Club and get access to expert sports picks.</p>
</div>

@if ($errors->any())
    <ul class="error-list">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-row">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Optional">
        </div>
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required minlength="8">
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" required minlength="8">
    </div>
    <button type="submit" class="btn-submit">Create Account</button>
</form>

<div class="auth-footer">
    Already have an account? <a href="{{ route('login') }}">Sign in here</a>
</div>
@endsection

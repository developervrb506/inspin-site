@extends('layouts.auth')

@section('title', 'Forgot Password - INSPIN')

@section('content')
<div class="auth-form-header">
    <div class="auth-icon">
        <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
        </svg>
    </div>
    <h1>Forgot Password?</h1>
    <p>No worries. Enter your email and we'll send you a reset link right away.</p>
</div>

@if (session('status'))
    <div class="alert alert-success">
        <svg style="flex-shrink:0;width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <svg style="flex-shrink:0;width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        {{ $errors->first() }}
    </div>
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

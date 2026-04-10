@extends('layouts.public')
@section('title', 'Join INSPIN - Membership Packages')

@section('content')
<div class="section">
    <div class="container" style="text-align:center;">
        <h1 class="section-title">Membership Packages</h1>
        <p class="section-sub">Get access to INSPIN simulation picks for all sports or exclusive whale packages</p>
        <p style="color:#64748b;max-width:600px;margin:0 auto 32px;">Our simulation model simulates every NFL, NBA, MLB, and NHL game thousands of times. Up over 150 units in the last 3 years. A $100 bettor would have netted $15,000+ profit.</p>

        <div class="grid grid-3">
            @foreach($packages as $pkg)
            <div class="pkg-card {{ $pkg->slug === 'quarterly' ? 'featured' : '' }}">
                <div class="pkg-badge" style="background:#3b82f6;color:white;padding:4px 12px;border-radius:4px;font-size:12px;font-weight:600;display:inline-block;margin-bottom:12px;">All Sports</div>
                <h3>{{ $pkg->name }}</h3>
                <div class="pkg-price"><sup>$</sup>{{ number_format($pkg->price, 0) }}</div>
                <div class="pkg-duration">{{ $pkg->duration }} Access</div>
                <ul class="pkg-features">
                    @foreach(($pkg->features ?? []) as $feature)
                    <li>{{ $feature }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="btn {{ $pkg->slug === 'quarterly' ? 'btn-red' : 'btn-blue' }}" style="width:100%;">Get Started</a>
            </div>
            @endforeach
            
            @foreach($whalePackages as $whale)
            <div class="pkg-card" style="border:2px solid #f59e0b;">
                <div class="pkg-badge" style="background:#f59e0b;color:white;padding:4px 12px;border-radius:4px;font-size:12px;font-weight:600;display:inline-block;margin-bottom:12px;">🐋 Whale Package</div>
                <h3>{{ $whale->title }}</h3>
                <div class="pkg-price"><sup>$</sup>{{ number_format($whale->price, 0) }}</div>
                <div class="pkg-duration">{{ $whale->duration }}</div>
                <ul class="pkg-features">
                    @foreach(($whale->features ?? []) as $feature)
                    <li>{{ $feature }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="btn btn-red" style="width:100%;">Get Started</a>
            </div>
            @endforeach
        </div>

        <p style="color:#64748b;margin-top:24px;font-size:13px;">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</div>
@endsection

@extends('layouts.public')
@section('title', 'Delivery Policy - INSPIN')

@section('content')
<div style="background:#171818;min-height:60vh;padding:60px 0;">
<div style="max-width:860px;margin:0 auto;padding:0 24px;">

    <h1 style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:500;color:#FFFCEE;margin-bottom:8px;">Delivery Policy</h1>
    <p style="color:#6e6e6e;font-size:13px;margin-bottom:40px;border-bottom:1px solid rgba(255,252,238,.08);padding-bottom:20px;">Last updated: {{ now()->format('F Y') }}</p>

    @php
    $sections = [
        ['Digital Delivery Only', 'Inspin.com provides digital Content and Services only. We do not ship any physical products. There is no shipping cost, and no delivery address is required.'],
        ['How Access Is Delivered', 'Access to purchased packages and Free Trial features is granted immediately and automatically through your Inspin.com account upon successful registration or purchase. You can access your picks, articles, and other Content by logging in at inspin.com from any device with an internet connection.'],
        ['Access Confirmation', 'Once your account is activated, your current package and its expiration date are visible in your account dashboard. If you do not see expected access after purchasing, please contact us right away so we can resolve it quickly.'],
        ['Delivery Issues', 'If you experience any trouble accessing Content or Services you\'ve purchased, contact Customer Service through our Communications Center at inspin.com/contact, email help@inspin.com, or call 610-870-4799. We respond to all support requests within 24 hours.'],
    ];
    @endphp

    @foreach($sections as $s)
    <div style="margin-bottom:28px;">
        <h2 style="font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:500;color:#FDB515;margin-bottom:10px;">{{ $s[0] }}</h2>
        <p style="color:#c0c0c0;font-size:14.5px;line-height:1.8;">{{ $s[1] }}</p>
    </div>
    @endforeach

    <div style="margin-top:48px;padding-top:24px;border-top:1px solid rgba(255,252,238,.08);color:#6e6e6e;font-size:13px;">
        Questions? Contact us at <a href="mailto:help@inspin.com" style="color:#FDB515;">help@inspin.com</a> or call <a href="tel:+16108704799" style="color:#FDB515;">610-870-4799</a>.
    </div>

</div>
</div>
@endsection

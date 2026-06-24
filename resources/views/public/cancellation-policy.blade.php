@extends('layouts.public')
@section('title', 'Cancellation Policy - INSPIN')

@section('content')
<div style="background:#171818;min-height:60vh;padding:60px 0;">
<div style="max-width:860px;margin:0 auto;padding:0 24px;">

    <h1 style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:500;color:#FFFCEE;margin-bottom:8px;">Cancellation Policy</h1>
    <p style="color:#6e6e6e;font-size:13px;margin-bottom:40px;border-bottom:1px solid rgba(255,252,238,.08);padding-bottom:20px;">Last updated: {{ now()->format('F Y') }}</p>

    @php
    $sections = [
        ['No Auto-Renewing Subscriptions', 'Packages purchased on Inspin.com are one-time charges for a fixed period of access (for example, 1 week, 1 month, or 1 year), as shown on the purchase page at the time of purchase. We do not store your payment method for future charges, and no package automatically renews or rebills at the end of its access period.'],
        ['Nothing to Cancel', 'Because there is no recurring subscription, there is no recurring charge to cancel. When your package\'s access period ends, it simply expires — you will not be charged again unless you choose to purchase a new package.'],
        ['Free Trial', 'Our 7-day Free Trial requires no credit card. It does not convert into a paid package automatically and will never result in a charge. When the trial period ends, access to 1-star picks under the trial simply ends — no action is required on your part.'],
        ['Closing Your Account', 'If you would like to stop using Inspin.com entirely and close your account, you can do so at any time by contacting Customer Service through our Communications Center at inspin.com/contact, emailing help@inspin.com, or calling 610-870-4799. We will confirm your account closure within 2 business days.'],
        ['Questions', 'If you have any questions about an existing purchase or your account status, our support team is available daily from 8:00 AM to 10:00 PM Eastern.'],
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

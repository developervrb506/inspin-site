@extends('layouts.public')
@section('title', 'Refund Policy - INSPIN')

@section('content')
<div style="background:#171818;min-height:60vh;padding:60px 0;">
<div style="max-width:860px;margin:0 auto;padding:0 24px;">

    <h1 style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:500;color:#FFFCEE;margin-bottom:8px;">Refund Policy</h1>
    <p style="color:#6e6e6e;font-size:13px;margin-bottom:40px;border-bottom:1px solid rgba(255,252,238,.08);padding-bottom:20px;">Last updated: {{ now()->format('F Y') }}</p>

    @php
    $sections = [
        ['Overview', 'All purchases made on Inspin.com are for digital access to Content and Services, delivered electronically and immediately upon purchase or account activation. No physical goods are shipped.'],
        ['Satisfaction Guarantee', 'Inspin.com stands behind the quality of our picks. If you do not show a net profit during your paid subscription period, your package will renew free of charge until you become a winning player. This guarantee is our primary commitment to member satisfaction and is applied automatically — contact Customer Service to confirm eligibility for your account.'],
        ['General Refund Eligibility', 'Because Content and Services are delivered digitally and immediately, purchases are generally final and non-refundable once access has been granted. Refunds may be issued at our discretion in cases of: a duplicate or erroneous charge, a verified technical failure that prevented you from accessing the Service you purchased, or as otherwise required by applicable law or your card issuer\'s dispute process. Refunds are issued in full; we do not offer partial refunds.'],
        ['Refund Request Window', 'Refund requests must be submitted within 7 days of the original purchase date. Requests submitted after this window will not be eligible for a refund, except where required by applicable law.'],
        ['How to Request a Refund', 'To request a refund, contact us through our Communications Center at inspin.com/contact, by emailing help@inspin.com, or by calling 610-870-4799. Please include your account email and order details. We will review each request individually and respond within 2 business days.'],
        ['Refund Processing Timeframe', 'If a refund is approved, it will be issued to your original payment method. Please allow 5 to 10 business days for the refund to appear on your statement, depending on your card issuer or bank.'],
        ['Free Trial', 'Our 7-day Free Trial requires no credit card and results in no charge of any kind, so no refund is applicable to the trial period.'],
        ['Questions', 'If you believe you were charged in error or have any billing question, please reach out before disputing the charge with your card issuer — we\'re happy to help resolve it directly and quickly.'],
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

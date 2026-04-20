@extends('layouts.public')
@section('title', 'About - INSPIN')

@section('content')
<div class="page">
    {{-- Editable About Content --}}
    @if($aboutContent)
        <div class="content">
            {!! $aboutContent !!}
        </div>
    @else
        <h1>About INSPIN</h1>
        <p>INSPIN.com is the premier sports betting analysis platform. Our team of expert handicappers and data scientists have years of experience and unmatched passion for United States' sports.</p>
        <h2>Our Simulation Model</h2>
        <p>The INSPIN simulation model simulates every NFL, NBA, MLB, and NHL game thousands of times. Over the last three years, our model has been up over 150 units. A $100 bettor would have netted a profit of $15,000+ and a $1,000 bettor would have won $150,000+.</p>
        <h2>What We Offer</h2>
        <p>We offer picks on NFL, NBA, MLB, NHL, XFL, PGA Golf, and NCAA Basketball and Football. Our packages start at just $99.99 per month and give you access to all of our simulations, consensus data, betting trends, and expert analysis.</p>
        <h2>Our Commitment</h2>
        <p>Our team is committed to providing you with the highest level of customer service and support. From our user-friendly website to our 24/7 customer service, we are here to help you succeed.</p>
    @endif

    {{-- Expert Bios --}}
    @if($experts->count() > 0)
    <div style="margin-top:48px;padding-top:36px;border-top:2px solid #f1f5f9;">
        <h2 style="color:#0f172a;margin-bottom:8px;font-size:1.5rem;">Meet Our Experts</h2>
        <p style="color:#64748b;margin-bottom:32px;">Our team of professional handicappers brings decades of combined experience to every pick.</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;">
            @foreach($experts as $expert)
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:24px;display:flex;flex-direction:column;align-items:center;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                @if($expert->avatar)
                    <img src="{{ asset('storage/uploads/experts/'.$expert->avatar) }}" alt="{{ $expert->name }}" style="width:88px;height:88px;border-radius:50%;object-fit:cover;border:3px solid #f1f5f9;margin-bottom:14px;">
                @else
                    <div style="width:88px;height:88px;border-radius:50%;background:linear-gradient(135deg,#dc2626,#9b1c1c);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:28px;margin-bottom:14px;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
                @endif
                <div style="font-size:1.1rem;font-weight:800;color:#0f172a;margin-bottom:4px;">{{ $expert->name }}</div>
                @if($expert->specialty)
                    <div style="font-size:12px;color:#dc2626;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">{{ $expert->specialty }}</div>
                @endif
                @if($expert->bio)
                    <p style="color:#64748b;font-size:14px;line-height:1.6;margin:0;">{{ $expert->bio }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div style="text-align:center;margin-top:40px;">
        <a href="{{ route('join') }}" class="btn btn-red">Open a Package</a>
    </div>
</div>
@endsection

@extends('layouts.public')
@section('title', 'About - INSPIN')

@section('content')
<div class="page">
    <h1>About INSPIN</h1>
    <p>INSPIN.com is the premier sports betting analysis platform. Our team of expert handicappers and data scientists have years of experience and unmatched passion for United States' sports.</p>
    <h2>Our Simulation Model</h2>
    <p>The INSPIN simulation model simulates every NFL, NBA, MLB, and NHL game thousands of times. Over the last three years, our model has been up over 150 units. A $100 bettor would have netted a profit of $15,000+ and a $1,000 bettor would have won $150,000+.</p>
    <h2>What We Offer</h2>
    <p>We offer picks on NFL, NBA, MLB, NHL, XFL, PGA Golf, and NCAA Basketball and Football. Our packages start at just $99.99 per month and give you access to all of our simulations, consensus data, betting trends, and expert analysis.</p>
    <h2>Our Commitment</h2>
    <p>Our team is committed to providing you with the highest level of customer service and support. From our user-friendly website to our 24/7 customer service, we are here to help you succeed.</p>
    <div style="text-align:center;margin-top:32px;">
        <a href="{{ route('join') }}" class="btn btn-red">Open a Package</a>
    </div>
</div>
@endsection

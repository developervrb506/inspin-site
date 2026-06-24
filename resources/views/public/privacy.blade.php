@extends('layouts.public')
@section('title', 'Privacy Policy - INSPIN')

@section('content')
<div style="background:#171818;min-height:60vh;padding:60px 0;">
<div style="max-width:860px;margin:0 auto;padding:0 24px;">

    <h1 style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:500;color:#FFFCEE;margin-bottom:8px;">Privacy Policy</h1>
    <p style="color:#6e6e6e;font-size:13px;margin-bottom:40px;border-bottom:1px solid rgba(255,252,238,.08);padding-bottom:20px;">Last updated: March 2025</p>

    @php
    $sections = [
        ['We Respect the Importance of Your Privacy', 'The Inspin.com Privacy Policy applies to Personal Information of non-employee persons who interact with Inspin.com — including viewers, readers, subscribers, advertisers, contest participants, customers, and Internet users. This Privacy Policy applies to the management of Personal Information in any form whether oral, electronic or written. Inspin.com reserves the right to amend this Privacy Policy from time to time.'],
        ['Purposes for Collection of Personal Information', 'Inspin.com collects Personal Information to: establish and maintain responsible commercial relations with individuals and provide ongoing service; understand individual needs; enhance, develop, market or provide products and services; and meet legal or regulatory requirements.'],
        ['Obtaining Consent', 'Inspin.com will make a reasonable effort to ensure persons understand how their Personal Information will be used. Inspin.com will obtain consent from persons before or when it collects or uses the Personal Information and will not attempt to deceive persons into giving consent.'],
        ['Internet Protocol Address (IP Address)', 'When your web browser requests a web page, it automatically provides that computer with your IP address. Inspin.com may use your IP Address to diagnose technical problems, display more appropriate content and advertising, and estimate user traffic from specific countries or organizations.'],
        ['Cookies', 'A cookie is a small text file sent to your browser from a web site\'s computers and stored on your hard drive. Inspin.com may use cookies to improve the operation and performance of our services, measure aggregate user traffic and demographic statistics, and display advertisements. Most browsers are set to accept cookies by default — you can adjust your browser settings to refuse cookies.'],
        ['Security Safeguards', 'Inspin.com shall protect Personal Information by security safeguards appropriate to the sensitivity of the information — including protection against loss or theft, unauthorized access, disclosure, copying, use, modification or destruction, through appropriate security measures.'],
        ['Access to Personal Information', 'Upon request, Inspin.com shall afford a person a reasonable opportunity to review the Personal Information in the person\'s file. Personal Information shall be provided in understandable form within a reasonable time and at minimal or no cost to the person.'],
        ['Links to Other Sites', 'An Inspin.com website may contain links to other websites and services. Inspin.com is not responsible for the content of, or the privacy practices employed by, other companies or websites. This Privacy Policy applies only to Inspin.com services.'],
        ['Refusing or Withdrawing Consent', 'Subject to legal and contractual requirements, a person can refuse to consent to Inspin.com\'s collection, use or disclosure of Personal Information, or may withdraw consent at any time in the future by giving Inspin.com reasonable notice. If a person refuses or withdraws consent, Inspin.com may not be able to provide certain products, services or information.'],
        ['Challenging Compliance', 'A person shall be able to address a challenge concerning compliance with the above principles to the designated person accountable for compliance. Inspin.com shall maintain procedures for addressing and responding to all inquiries or complaints.'],
        ['California Privacy Rights (CCPA)', 'If you are a California resident, you have the right to request disclosure of the categories and specific pieces of Personal Information we have collected about you, request deletion of your Personal Information, and opt out of the sale or sharing of your Personal Information (Inspin.com does not sell Personal Information to third parties). You will not be discriminated against for exercising any of these rights. To submit a request, contact us at help@inspin.com or through our Communications Center at inspin.com/contact.'],
        ['Financial Privacy (Gramm-Leach-Bliley Act)', 'When you make a purchase, we collect limited nonpublic financial information (such as payment confirmation details) solely to process your transaction through our payment processor. We do not share your nonpublic financial information with non-affiliated third parties for marketing purposes. We maintain physical, electronic, and procedural safeguards to protect this information in accordance with applicable law.'],
        ['Refund, Cancellation & Delivery', 'For details on how purchases are delivered, our cancellation policy, and refund eligibility, please see our Refund Policy (inspin.com/refund-policy), Cancellation Policy (inspin.com/cancellation-policy), and Delivery Policy (inspin.com/delivery-policy).'],
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
        <br>You can also write to: Inspin.com, Bryn Mawr, PA.
    </div>

</div>
</div>
@endsection

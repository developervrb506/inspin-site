@extends('layouts.public')
@section('title', 'Contact Us — INSPIN')

@section('content')

<style>
    .comm-hero {
        background: linear-gradient(135deg, rgba(253,181,21,.06) 0%, transparent 60%);
        border-bottom: 1px solid rgba(255,252,238,.06);
        padding: 60px 0 48px;
        text-align: center;
        margin-bottom: 0;
    }
    .comm-eyebrow {
        display: inline-block;
        font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: #FDB515;
        background: rgba(253,181,21,.08); border: 1px solid rgba(253,181,21,.2);
        border-radius: 50px; padding: 5px 16px; margin-bottom: 18px;
    }
    .comm-title {
        font-family: 'Clash Display', sans-serif;
        font-size: clamp(2rem, 5vw, 3rem); font-weight: 600;
        color: #FFFCEE; margin: 0 0 14px;
    }
    .comm-sub {
        font-size: 16px; color: #6e6e6e; margin: 0 auto;
        max-width: 480px; line-height: 1.65;
    }

    .comm-wrap {
        max-width: 1100px; margin: 0 auto; padding: 60px 24px 80px;
    }

    .comm-section-label {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 1.2px; color: #FDB515; margin-bottom: 24px;
        display: flex; align-items: center; gap: 10px;
    }
    .comm-section-label::after {
        content: ''; flex: 1; height: 1px;
        background: linear-gradient(90deg, rgba(253,181,21,.2), transparent);
    }

    /* 2×2 grid */
    .comm-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 60px;
    }
    @media (max-width: 700px) { .comm-grid { grid-template-columns: 1fr; } }

    .comm-card {
        background: #1e1e1e;
        border: 1px solid rgba(255,252,238,.07);
        border-radius: 16px;
        padding: 28px;
        display: flex; flex-direction: column; gap: 16px;
        transition: border-color .2s, transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .comm-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, transparent, rgba(253,181,21,.15), transparent);
        opacity: 0; transition: opacity .2s;
    }
    .comm-card:hover {
        border-color: rgba(253,181,21,.25);
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0,0,0,.4);
    }
    .comm-card:hover::before { opacity: 1; }

    .comm-card-num {
        position: absolute; top: 18px; right: 20px;
        font-size: 11px; font-weight: 800; color: rgba(253,181,21,.2);
        letter-spacing: 1px;
    }
    .comm-card-icon {
        width: 52px; height: 52px; border-radius: 12px;
        background: rgba(253,181,21,.08); border: 1px solid rgba(253,181,21,.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; flex-shrink: 0;
    }
    .comm-card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 1.15rem; font-weight: 600; color: #FFFCEE; margin: 0 0 4px;
    }
    .comm-card-badge {
        display: inline-block; font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .6px;
        padding: 2px 10px; border-radius: 50px;
        background: rgba(0,209,91,.1); color: #00D15B;
        border: 1px solid rgba(0,209,91,.2);
    }
    .comm-card-desc {
        font-size: 13.5px; color: #9a9a9a; line-height: 1.7; margin: 0;
        flex: 1;
    }
    .comm-btn-gold {
        display: block; text-align: center;
        padding: 12px 20px; background: #FDB515;
        color: #171818; border: none; border-radius: 10px;
        font-weight: 700; font-size: 14px; cursor: pointer;
        text-decoration: none; transition: background .15s, transform .15s;
        font-family: 'DM Sans', sans-serif;
    }
    .comm-btn-gold:hover { background: #e09c0d; transform: scale(1.01); color: #171818; }
    .comm-btn-outline {
        display: block; text-align: center;
        padding: 12px 20px; background: transparent;
        color: #FDB515; border: 1px solid rgba(253,181,21,.35);
        border-radius: 10px; font-weight: 700; font-size: 14px;
        cursor: pointer; text-decoration: none; transition: background .15s;
        font-family: 'DM Sans', sans-serif;
    }
    .comm-btn-outline:hover { background: rgba(253,181,21,.08); color: #FDB515; }

    /* Contact method rows inside Talk card */
    .talk-row {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 14px;
        background: #171818; border: 1px solid rgba(255,252,238,.06);
        border-radius: 10px; text-decoration: none;
        transition: border-color .2s, background .2s;
    }
    .talk-row:hover { border-color: rgba(253,181,21,.3); background: rgba(253,181,21,.04); }
    .talk-row-icon {
        width: 36px; height: 36px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px; flex-shrink: 0;
    }
    .talk-row-label { font-size: 14px; font-weight: 600; color: #FFFCEE; }
    .talk-row-sub { font-size: 11px; color: #6e6e6e; margin-top: 1px; }

    /* Status badge */
    .agent-status {
        display: flex; align-items: center; gap: 8px;
        padding: 9px 14px; border-radius: 8px;
        background: rgba(239,68,68,.06); border: 1px solid rgba(239,68,68,.15);
        font-size: 12px; color: #9a9a9a;
    }
    .agent-dot { width: 7px; height: 7px; border-radius: 50%; background: #4a4a4a; flex-shrink:0; }
    .agent-dot.online { background: #00D15B; box-shadow: 0 0 6px rgba(0,209,91,.5); }

    /* Ticket form */
    .ticket-form-wrap {
        background: #171818; border: 1px solid rgba(253,181,21,.12);
        border-radius: 12px; padding: 24px; margin-top: 4px;
    }
    .ticket-input {
        width: 100%; background: #1e1e1e; border: 1px solid rgba(255,252,238,.08);
        border-radius: 8px; padding: 11px 14px; color: #FFFCEE;
        font-size: 14px; outline: none; font-family: 'DM Sans', sans-serif;
        transition: border-color .2s;
    }
    .ticket-input:focus { border-color: rgba(253,181,21,.4); }
    .ticket-label {
        display: block; font-size: 11px; color: #6e6e6e;
        text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; font-weight: 600;
    }

    /* Social connect */
    .connect-grid {
        display: flex; flex-wrap: wrap; gap: 12px;
    }
    .connect-item {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 18px; background: #1e1e1e;
        border: 1px solid rgba(255,252,238,.07); border-radius: 12px;
        text-decoration: none; transition: border-color .2s, transform .2s;
        min-width: 130px;
    }
    .connect-item:hover { border-color: rgba(253,181,21,.3); transform: translateY(-1px); }
    .connect-item span { font-size: 13px; font-weight: 600; color: #FFFCEE; }
</style>

{{-- Hero --}}
<div class="comm-hero">
    <div class="comm-eyebrow">Support</div>
    <h1 class="comm-title">Communications Center</h1>
    <p class="comm-sub">We're here to help. Choose the best way to reach us and we'll get back to you fast.</p>
</div>

<div class="comm-wrap">

    @if(session('ticket_success'))
    <div style="background:rgba(0,209,91,.08);border:1px solid rgba(0,209,91,.25);border-radius:12px;padding:16px 20px;margin-bottom:32px;display:flex;align-items:center;gap:12px;">
        <span style="font-size:20px;">✓</span>
        <div>
            <div style="font-size:14px;font-weight:700;color:#00D15B;">Ticket submitted successfully</div>
            <div style="font-size:13px;color:#6e6e6e;margin-top:2px;">We'll follow up at {{ session('ticket_email') }} within 24 hours.</div>
        </div>
    </div>
    @endif

    {{-- Section 1: Contact Us --}}
    <div class="comm-section-label">Contact Us</div>

    <div class="comm-grid">

        {{-- 1. Live Chat --}}
        <div class="comm-card">
            <span class="comm-card-num">01</span>
            <div class="comm-card-icon">💬</div>
            <div>
                <div class="comm-card-title">Chat with an Agent</div>
                <span class="comm-card-badge" style="background:rgba(239,68,68,.1);color:#ef4444;border-color:rgba(239,68,68,.2);">Offline</span>
            </div>
            <p class="comm-card-desc">Connect directly with a Customer Service representative. When our team is online you'll chat live — when offline your message goes straight to help@inspin.com.</p>
            <div class="agent-status">
                <div class="agent-dot"></div>
                <span>No agents online right now</span>
            </div>
            <a href="mailto:help@inspin.com" class="comm-btn-gold">Email Support</a>
        </div>

        {{-- 2. Chatbot --}}
        <div class="comm-card">
            <span class="comm-card-num">02</span>
            <div class="comm-card-icon">🤖</div>
            <div>
                <div class="comm-card-title">INSPIN Assistant</div>
                <span class="comm-card-badge">Available 24/7</span>
            </div>
            <p class="comm-card-desc">Get instant answers about picks, packages, how the site works, or anything INSPIN-related. Our AI assistant is available around the clock — no waiting.</p>
            <button onclick="toggleChat()" class="comm-btn-gold">Open Chatbot</button>
        </div>

        {{-- 3. Talk with Us --}}
        <div class="comm-card">
            <span class="comm-card-num">03</span>
            <div class="comm-card-icon">📞</div>
            <div>
                <div class="comm-card-title">Talk with Us</div>
                <div style="font-size:12px;color:#6e6e6e;margin-top:2px;">Call, WhatsApp, or Telegram</div>
            </div>
            <p class="comm-card-desc">Reach us directly on your preferred platform. We're available by phone and messaging apps.</p>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="tel:+16108704799" class="talk-row">
                    <div class="talk-row-icon" style="background:rgba(253,181,21,.08);">📞</div>
                    <div>
                        <div class="talk-row-label">610-870-4799</div>
                        <div class="talk-row-sub">Phone</div>
                    </div>
                </a>
                <div class="talk-row" style="opacity:.5;cursor:default;">
                    <div class="talk-row-icon" style="background:rgba(37,211,102,.08);">💬</div>
                    <div>
                        <div class="talk-row-label">WhatsApp</div>
                        <div class="talk-row-sub">Coming Soon</div>
                    </div>
                </div>
                <div class="talk-row" style="opacity:.5;cursor:default;">
                    <div class="talk-row-icon" style="background:rgba(0,136,204,.08);">✈️</div>
                    <div>
                        <div class="talk-row-label">Telegram</div>
                        <div class="talk-row-sub">Coming Soon</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. Email Us --}}
        <div class="comm-card">
            <span class="comm-card-num">05</span>
            <div class="comm-card-icon">✉️</div>
            <div>
                <div class="comm-card-title">Email Us</div>
                <div style="font-size:12px;color:#6e6e6e;margin-top:2px;">We respond within 24 hours</div>
            </div>
            <p class="comm-card-desc">Prefer email? Send us a message directly and our Customer Service team will get back to you.</p>
            <a href="mailto:help@inspin.com" class="comm-btn-gold">help@inspin.com</a>
        </div>

        {{-- 6. FAQ's --}}
        <div class="comm-card">
            <span class="comm-card-num">06</span>
            <div class="comm-card-icon">❓</div>
            <div>
                <div class="comm-card-title">FAQ's</div>
                <span class="comm-card-badge" style="background:rgba(253,181,21,.1);color:#FDB515;border-color:rgba(253,181,21,.2);">Coming Soon</span>
            </div>
            <p class="comm-card-desc">Quick answers to the most common questions about picks, packages, and how INSPIN works.</p>
            <a href="{{ route('faq') }}" class="comm-btn-outline">View FAQ's</a>
        </div>

        {{-- 4. Send a Ticket --}}
        <div class="comm-card" id="ticket">
            <span class="comm-card-num">04</span>
            <div class="comm-card-icon">🎫</div>
            <div>
                <div class="comm-card-title">Send a Ticket</div>
                <div style="font-size:12px;color:#6e6e6e;margin-top:2px;">We respond within 24 hours</div>
            </div>
            <p class="comm-card-desc">Submit a support request and our Customer Service team will follow up. All tickets are tracked and tagged by site so the right rep handles it.</p>
            <button onclick="document.getElementById('ticketFormInner').style.display=document.getElementById('ticketFormInner').style.display==='none'?'block':'none';this.textContent=document.getElementById('ticketFormInner').style.display==='block'?'Close Form':'Open Ticket Form';"
                    class="comm-btn-outline" id="ticketToggleBtn">
                Open Ticket Form
            </button>
            <div id="ticketFormInner" style="display:none;">
                <div class="ticket-form-wrap">
                    <form method="POST" action="{{ route('contact.ticket') }}">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div>
                                <label class="ticket-label">Your Name *</label>
                                <input type="text" name="customer_name" required class="ticket-input"
                                       value="{{ auth()->user()->name ?? old('customer_name') }}" placeholder="Full name">
                            </div>
                            <div>
                                <label class="ticket-label">Email *</label>
                                <input type="email" name="customer_email" required class="ticket-input"
                                       value="{{ auth()->user()->email ?? old('customer_email') }}" placeholder="your@email.com">
                            </div>
                        </div>
                        <div style="margin-bottom:12px;">
                            <label class="ticket-label">Subject *</label>
                            <input type="text" name="subject" required class="ticket-input"
                                   value="{{ old('subject') }}" placeholder="e.g. I can't access my picks">
                        </div>
                        <div style="margin-bottom:16px;">
                            <label class="ticket-label">Message *</label>
                            <textarea name="message" required rows="3" class="ticket-input"
                                      placeholder="Describe your issue in detail…" style="resize:vertical;">{{ old('message') }}</textarea>
                        </div>
                        @if($errors->any())
                        <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:8px;padding:10px 14px;margin-bottom:12px;font-size:13px;color:#ef4444;">
                            @foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach
                        </div>
                        @endif
                        <button type="submit" class="comm-btn-gold" style="display:inline-block;padding:11px 28px;width:auto;">Submit Ticket</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Section 2: Connect with Us --}}
    <div class="comm-section-label">Connect with Us</div>

    <div class="connect-grid" style="margin-bottom:60px;">
        <a href="https://www.facebook.com/Inspin.sports" target="_blank" rel="noopener" class="connect-item">
            <img src="{{ asset('images/social-facebook.png') }}" alt="Facebook" style="width:24px;height:24px;object-fit:contain;">
            <span>Facebook</span>
        </a>
        <a href="https://www.instagram.com/inspin.sports/" target="_blank" rel="noopener" class="connect-item">
            <img src="{{ asset('images/social-instagram.png') }}" alt="Instagram" style="width:24px;height:24px;object-fit:contain;">
            <span>Instagram</span>
        </a>
        <a href="https://twitter.com/inspin" target="_blank" rel="noopener" class="connect-item">
            <img src="{{ asset('images/social-twitter.png') }}" alt="X / Twitter" style="width:24px;height:24px;object-fit:contain;">
            <span>X / Twitter</span>
        </a>
        <a href="https://www.youtube.com/channel/UCxPUSU7jxt_Ix3sRafRg1WA" target="_blank" rel="noopener" class="connect-item">
            <img src="{{ asset('images/social-youtube.png') }}" alt="YouTube" style="width:24px;height:24px;object-fit:contain;">
            <span>YouTube</span>
        </a>
        <div class="connect-item" style="opacity:.45;cursor:default;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="#FFFCEE"><path d="M16.6 5.82c-.93-.93-1.45-2.18-1.45-3.5h-3.2v13.93c0 1.6-1.3 2.9-2.9 2.9a2.9 2.9 0 01-2.9-2.9 2.9 2.9 0 012.9-2.9c.32 0 .63.05.92.14V10.3a6.1 6.1 0 00-.92-.07c-3.36 0-6.08 2.72-6.08 6.08S6.6 22.4 9.96 22.4s6.08-2.72 6.08-6.08V9.1c1.3.93 2.9 1.48 4.6 1.48v-3.2c-1.5 0-2.8-.6-4.04-1.56z"/></svg>
            <span>TikTok · Soon</span>
        </div>
    </div>

    {{-- Section 3: Hours & Legal --}}
    <div class="comm-section-label">Hours &amp; Legal</div>
    <div style="display:flex;flex-wrap:wrap;gap:16px;margin-bottom:60px;">
        <div class="talk-row" style="flex:1;min-width:240px;cursor:default;">
            <div class="talk-row-icon" style="background:rgba(253,181,21,.08);">🕗</div>
            <div>
                <div class="talk-row-label">Monday – Sunday</div>
                <div class="talk-row-sub">8:00 AM – 10:00 PM Eastern</div>
            </div>
        </div>
        <a href="{{ route('terms') }}" class="talk-row" style="flex:1;min-width:240px;">
            <div class="talk-row-icon" style="background:rgba(253,181,21,.08);">📋</div>
            <div>
                <div class="talk-row-label">Terms &amp; Conditions</div>
                <div class="talk-row-sub">Read our terms of service</div>
            </div>
        </a>
        <a href="{{ route('privacy') }}" class="talk-row" style="flex:1;min-width:240px;">
            <div class="talk-row-icon" style="background:rgba(253,181,21,.08);">🔒</div>
            <div>
                <div class="talk-row-label">Privacy Policy</div>
                <div class="talk-row-sub">How we handle your data</div>
            </div>
        </a>
        <div class="talk-row" style="flex:1;min-width:240px;cursor:default;">
            <div class="talk-row-icon" style="background:rgba(253,181,21,.08);">📍</div>
            <div>
                <div class="talk-row-label">Mailing Address</div>
                <div class="talk-row-sub">Inspin.com, Bryn Mawr, PA</div>
            </div>
        </div>
        <a href="{{ route('refund-policy') }}" class="talk-row" style="flex:1;min-width:240px;">
            <div class="talk-row-icon" style="background:rgba(253,181,21,.08);">💳</div>
            <div>
                <div class="talk-row-label">Refund Policy</div>
                <div class="talk-row-sub">Eligibility & how to request</div>
            </div>
        </a>
        <a href="{{ route('cancellation-policy') }}" class="talk-row" style="flex:1;min-width:240px;">
            <div class="talk-row-icon" style="background:rgba(253,181,21,.08);">🚫</div>
            <div>
                <div class="talk-row-label">Cancellation Policy</div>
                <div class="talk-row-sub">No auto-renewal, ever</div>
            </div>
        </a>
        <a href="{{ route('delivery-policy') }}" class="talk-row" style="flex:1;min-width:240px;">
            <div class="talk-row-icon" style="background:rgba(253,181,21,.08);">📦</div>
            <div>
                <div class="talk-row-label">Delivery Policy</div>
                <div class="talk-row-sub">Instant digital access</div>
            </div>
        </a>
    </div>

    {{-- CTA --}}
    <div style="text-align:center;padding:36px;background:rgba(253,181,21,.03);border:1px solid rgba(253,181,21,.1);border-radius:16px;">
        <div style="font-family:'Clash Display',sans-serif;font-size:1.3rem;font-weight:600;color:#FFFCEE;margin-bottom:8px;">Need access to premium picks?</div>
        <div style="font-size:14px;color:#6e6e6e;margin-bottom:20px;">Join INSPIN and get expert picks, analysis, and simulation model results.</div>
        <a href="{{ route('join') }}" class="comm-btn-gold" style="display:inline-block;padding:13px 40px;width:auto;border-radius:50px;">Get Started Free</a>
    </div>

</div>

<script>
    if (window.location.hash === '#ticket') {
        document.getElementById('ticketFormInner').style.display = 'block';
        document.getElementById('ticketToggleBtn').textContent = 'Close Form';
        setTimeout(function(){ document.getElementById('ticket').scrollIntoView({behavior:'smooth', block:'start'}); }, 150);
    }
</script>

@endsection

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'INSPIN - Sports Betting Analysis & Picks')</title>
    <meta name="description" content="@yield('meta', 'INSPIN - Expert sports betting analysis, daily picks, betting consensus, live odds, and trends for NFL, NBA, MLB, NHL.')">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; color: #1e293b; line-height: 1.6; }
        a { color: #2563eb; text-decoration: none; }
        a:hover { color: #1d4ed8; }
        img { max-width: 100%; }

        /* Top bar */
        .top-bar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 8px 0; font-size: 13px; }
        .top-bar .wrap { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .top-bar .tagline { color: #64748b; }
        .top-bar .auth { display: flex; gap: 16px; align-items: center; }
        .top-bar .auth a { color: #2563eb; font-weight: 600; font-size: 13px; }
        .top-bar .auth .join-btn { background: #22c55e; color: #fff; padding: 6px 16px; border-radius: 6px; font-size: 13px; }
        .top-bar .auth .join-btn:hover { background: #16a34a; color: #fff; }

        /* Header */
        .header { background: #fff; border-bottom: 3px solid #dc2626; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .header .wrap { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { padding: 8px 0; }
        .logo img { height: 48px; width: auto; }

        /* Nav */
        .nav { display: flex; gap: 0; list-style: none; flex-wrap: wrap; }
        .nav a { display: block; padding: 16px 12px; color: #475569; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; transition: all 0.15s; border-bottom: 3px solid transparent; margin-bottom: -3px; }
        .nav a:hover, .nav a.active { color: #dc2626; border-bottom-color: #dc2626; }

        /* Container */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 20px; }

        /* Hero */
        .hero { background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%); padding: 64px 0; text-align: center; }
        .hero h1 { font-size: 2.5rem; color: #fff; margin-bottom: 16px; font-weight: 800; }
        .hero h1 span { color: #fbbf24; }
        .hero p { color: #cbd5e1; max-width: 650px; margin: 0 auto 28px; font-size: 16px; }
        .btn { display: inline-block; padding: 12px 28px; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; border: none; transition: all 0.2s; text-align: center; }
        .btn-red { background: #dc2626; color: #fff; }
        .btn-red:hover { background: #b91c1c; color: #fff; }
        .btn-green { background: #22c55e; color: #fff; }
        .btn-green:hover { background: #16a34a; color: #fff; }
        .btn-blue { background: #2563eb; color: #fff; }
        .btn-blue:hover { background: #1d4ed8; color: #fff; }
        .btn-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.3); }
        .btn-outline:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .btn-outline-dark { background: transparent; color: #475569; border: 1px solid #cbd5e1; }
        .btn-outline-dark:hover { background: #f1f5f9; color: #1e293b; }
        .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        /* Section */
        .section { padding: 48px 0; }
        .section-alt { background: #fff; }
        .section-title { font-size: 1.75rem; color: #0f172a; margin-bottom: 8px; font-weight: 800; }
        .section-sub { color: #64748b; margin-bottom: 28px; font-size: 15px; }

        /* Grid */
        .grid { display: grid; gap: 24px; }
        .grid-2 { grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); }
        .grid-3 { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }
        .grid-4 { grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); }

        /* Card */
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; transition: box-shadow 0.2s, transform 0.15s; }
        .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); transform: translateY(-2px); }
        .card-body { padding: 24px; }
        .card h3 { color: #0f172a; margin-bottom: 8px; font-size: 1.05rem; }
        .card p { color: #64748b; font-size: 14px; }
        .card-meta { display: flex; gap: 12px; font-size: 12px; color: #94a3b8; margin-top: 12px; }
        .card-meta span { display: flex; align-items: center; gap: 4px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-nfl { background: #dbeafe; color: #1d4ed8; }
        .badge-nba { background: #fee2e2; color: #dc2626; }
        .badge-mlb { background: #dcfce7; color: #16a34a; }
        .badge-nhl { background: #f3e8ff; color: #9333ea; }
        .badge-ncaa { background: #fef3c7; color: #d97706; }
        .badge-general { background: #f1f5f9; color: #475569; }
        .badge-premium { background: #fef3c7; color: #d97706; }
        .badge-free { background: #dbeafe; color: #2563eb; }
        .badge-consensus { background: #dcfce7; color: #16a34a; }
        .badge-trends { background: #f3e8ff; color: #9333ea; }
        .badge-analysis { background: #e0e7ff; color: #4f46e5; }
        .badge-picks { background: #ccfbf1; color: #0d9488; }
        .badge-news { background: #fef3c7; color: #d97706; }

        /* Tables */
        .c-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .c-table th { background: #f8fafc; padding: 12px 16px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; font-weight: 700; }
        .c-table td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .c-table tr:hover { background: #f8fafc; }
        .pct-bar { height: 8px; border-radius: 4px; background: #e2e8f0; overflow: hidden; width: 80px; }
        .pct-fill { height: 100%; border-radius: 4px; }
        .pct-green { background: #22c55e; }
        .pct-red { background: #dc2626; }

        /* Packages */
        .pkg-card { background: #fff; border: 2px solid #e2e8f0; border-radius: 16px; padding: 32px; text-align: center; transition: border-color 0.2s, box-shadow 0.2s; }
        .pkg-card:hover { border-color: #2563eb; box-shadow: 0 4px 16px rgba(37,99,235,0.1); }
        .pkg-card.featured { border-color: #dc2626; position: relative; box-shadow: 0 4px 16px rgba(220,38,38,0.1); }
        .pkg-card.featured::before { content: 'POPULAR'; position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #dc2626; color: #fff; padding: 4px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; }
        .pkg-card h3 { color: #0f172a; font-size: 1.25rem; margin-bottom: 4px; }
        .pkg-price { font-size: 2.5rem; font-weight: 900; color: #0f172a; margin: 16px 0; }
        .pkg-price sup { font-size: 1rem; color: #64748b; }
        .pkg-duration { color: #64748b; font-size: 14px; margin-bottom: 20px; }
        .pkg-features { list-style: none; text-align: left; margin: 20px 0; }
        .pkg-features li { padding: 8px 0; font-size: 14px; color: #475569; border-bottom: 1px solid #f1f5f9; }
        .pkg-features li:last-child { border-bottom: none; }
        .pkg-features li::before { content: '✓'; color: #22c55e; margin-right: 8px; font-weight: 700; }

        /* CTA */
        .cta { background: linear-gradient(135deg, #dc2626, #991b1b); padding: 48px 0; text-align: center; border-radius: 16px; margin: 32px 0; }
        .cta h2 { color: #fff; font-size: 1.75rem; margin-bottom: 12px; }
        .cta p { color: rgba(255,255,255,0.9); margin-bottom: 20px; font-size: 16px; }
        .cta .btn { background: #fff; color: #dc2626; }
        .cta .btn:hover { background: #f8fafc; }

        /* Footer */
        .footer { background: #0f172a; padding: 32px 0; margin-top: 0; }
        .footer .wrap { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
        .footer-links { display: flex; gap: 20px; list-style: none; flex-wrap: wrap; }
        .footer-links a { color: #94a3b8; font-size: 13px; }
        .footer-links a:hover { color: #fff; }
        .footer-copy { color: #64748b; font-size: 13px; }
        .social-icons { display: flex; gap: 12px; align-items: center; }
        .social-icons a { display: block; transition: opacity 0.2s; }
        .social-icons a:hover { opacity: 0.7; }
        .social-icons img { width: 28px; height: 28px; }

        /* Page */
        .page { max-width: 900px; margin: 0 auto; padding: 48px 20px; }
        .page h1 { color: #0f172a; font-size: 2rem; margin-bottom: 24px; font-weight: 800; }
        .page h2 { color: #0f172a; font-size: 1.4rem; margin: 32px 0 12px; font-weight: 700; }
        .page p { color: #475569; margin-bottom: 16px; line-height: 1.8; }

        /* Article detail */
        .article-detail { max-width: 800px; margin: 0 auto; padding: 48px 20px; }
        .article-detail h1 { color: #0f172a; font-size: 2rem; margin-bottom: 16px; line-height: 1.3; font-weight: 800; }
        .article-detail .meta { display: flex; gap: 16px; font-size: 13px; color: #64748b; margin-bottom: 28px; }
        .article-detail .content { color: #334155; line-height: 1.8; }
        .article-detail .content p { margin-bottom: 16px; }

        /* Pagination */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 28px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 8px 14px; border-radius: 8px; font-size: 14px; }
        .pagination a { background: #fff; border: 1px solid #e2e8f0; color: #475569; }
        .pagination a:hover { background: #f1f5f9; }
        .pagination .active { background: #dc2626; color: #fff; border-color: #dc2626; }
        .pagination .disabled { opacity: 0.5; pointer-events: none; }

        /* Sport filter */
        .sport-filter { display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap; }
        .sport-filter a { padding: 8px 16px; border-radius: 24px; font-size: 13px; font-weight: 600; background: #fff; border: 1px solid #e2e8f0; color: #475569; }
        .sport-filter a:hover, .sport-filter a.active { background: #dc2626; border-color: #dc2626; color: #fff; }

        /* Admin layout */
        .admin-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .admin-card h1 { color: #0f172a; margin-bottom: 20px; font-size: 1.5rem; }
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th { background: #f8fafc; padding: 10px 14px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 700; border-bottom: 2px solid #e2e8f0; }
        .admin-table td { padding: 10px 14px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .admin-table tr:hover { background: #f8fafc; }
        .admin-btn { display: inline-block; padding: 8px 16px; background: #f1f5f9; color: #475569; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 13px; font-weight: 500; }
        .admin-btn:hover { background: #e2e8f0; }
        .admin-btn-primary { background: #2563eb; color: #fff; }
        .admin-btn-primary:hover { background: #1d4ed8; }
        .admin-btn-danger { background: #dc2626; color: #fff; }
        .admin-btn-danger:hover { background: #b91c1c; }
        .admin-form-group { margin-bottom: 16px; }
        .admin-form-group label { display: block; font-weight: 500; margin-bottom: 4px; font-size: 14px; color: #374151; }
        .admin-form-group input, .admin-form-group select, .admin-form-group textarea { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        .admin-form-group input:focus, .admin-form-group select:focus, .admin-form-group textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .admin-form-row { display: flex; gap: 16px; }
        .admin-form-row .admin-form-group { flex: 1; }
        .admin-form-actions { display: flex; gap: 8px; margin-top: 24px; }
        .admin-alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .admin-alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .admin-alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .metric { display: inline-block; background: #eff6ff; color: #1d4ed8; border-radius: 8px; padding: 8px 16px; margin-right: 8px; margin-bottom: 8px; font-weight: 700; font-size: 14px; }

        @media (max-width: 768px) {
            .hero h1 { font-size: 1.75rem; }
            .nav a { padding: 12px 10px; font-size: 11px; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .header .wrap { flex-direction: column; gap: 0; }
            .top-bar .wrap { flex-direction: column; gap: 8px; }
            .admin-form-row { flex-direction: column; }
        }
        
        /* Modal overlay */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.active { display: flex; }
        .modal-box { background: #fff; border-radius: 16px; padding: 32px; max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2); text-align: center; animation: modalIn 0.2s ease-out; position: relative; }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .modal-tabs { display: flex; margin-bottom: 24px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; }
        .modal-tab { flex: 1; padding: 12px; background: #f8fafc; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .modal-tab.active { background: #dc2626; color: #fff; }
        .modal-tab-content { display: none; text-align: left; }
        .modal-tab-content.active { display: block; }
        .modal-input { width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 14px; margin-bottom: 16px; }
        .modal-input:focus { outline: none; border-color: #dc2626; box-shadow: 0 0 0 4px rgba(220,38,38,0.1); }
        .modal-btn { width: 100%; padding: 14px; background: #dc2626; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; margin-top: 8px; }
        .modal-btn:hover { background: #b91c1c; }
        .modal-error { color: #dc2626; font-size: 13px; margin-top: 8px; display: none; }
        .modal-close { position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8; }
        .modal-close:hover { color: #475569; }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="wrap">
            <span class="tagline">INSPIN - Expert Sports Betting Analysis & Simulation Models</span>
            <div class="auth">
                @auth
                    <span style="color:#64748b;">{{ Auth::user()->name }}</span>
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('profile') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:#2563eb;cursor:pointer;font-weight:600;font-size:13px;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('join') }}" class="join-btn">Join Now</a>
                @endauth
            </div>
        </div>
    </div>

    <header class="header">
        <div class="wrap">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/inspin-logo.png') }}" alt="INSPIN - Insider Picks Sports Information">
            </a>
            <ul class="nav">
                <li><a href="{{ route('articles') }}" class="{{ request()->routeIs('article*') || request()->routeIs('articles') ? 'active' : '' }}">Exclusive Articles</a></li>
                <li><a href="{{ route('picks') }}" class="{{ request()->routeIs('picks') ? 'active' : '' }}">Picks</a></li>
                <li><a href="{{ route('join') }}" class="{{ request()->routeIs('join') ? 'active' : '' }}">Packages</a></li>
                <li><a href="{{ route('odds') }}" class="{{ request()->routeIs('odds') ? 'active' : '' }}">Live Odds</a></li>
                <li><a href="{{ route('consensus') }}" class="{{ request()->routeIs('consensus') ? 'active' : '' }}">Consensus</a></li>
                <li><a href="{{ route('trends') }}" class="{{ request()->routeIs('trends') ? 'active' : '' }}">Trends</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a></li>
            </ul>
        </div>
    </header>

    @yield('content')

    <footer class="footer">
        <div class="wrap">
            <div>
                <ul class="footer-links">
                    <li><a href="{{ route('articles') }}">Exclusive Articles</a></li>
                    <li><a href="{{ route('picks') }}">Picks</a></li>
                    <li><a href="{{ route('join') }}">Packages</a></li>
                    <li><a href="{{ route('odds') }}">Live Odds</a></li>
                    <li><a href="{{ route('consensus') }}">Consensus</a></li>
                    <li><a href="{{ route('trends') }}">Trends</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                </ul>
                <div class="social-icons" style="margin-top:16px;">
                    <a href="https://www.facebook.com/Inspin.sports" target="_blank" rel="noopener"><img src="{{ asset('images/social-facebook.png') }}" alt="Facebook"></a>
                    <a href="https://www.instagram.com/inspin.sports/" target="_blank" rel="noopener"><img src="{{ asset('images/social-instagram.png') }}" alt="Instagram"></a>
                    <a href="https://twitter.com/inspin" target="_blank" rel="noopener"><img src="{{ asset('images/social-twitter.png') }}" alt="X (Twitter)"></a>
                    <a href="https://www.youtube.com/channel/UCxPUSU7jxt_Ix3sRafRg1WA" target="_blank" rel="noopener"><img src="{{ asset('images/social-youtube.png') }}" alt="YouTube"></a>
                </div>
            </div>
            <div>
                <div class="footer-copy">&copy; {{ date('Y') }} Inspin.com - All Rights Reserved.</div>
                <div style="color:#475569;font-size:11px;margin-top:8px;max-width:400px;">
                    Information contained within this website is for news and entertainment purposes only. Past performance is not a guarantee of future results.
                </div>
            </div>
        </div>
    </footer>

    <!-- Login/Register Modal -->
    <div id="authModal" class="modal-overlay">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <h2 style="margin-bottom:20px;color:#0f172a;">Welcome to INSPIN</h2>
            
            <div class="modal-tabs">
                <button class="modal-tab active" onclick="switchTab('login')">Login</button>
                <button class="modal-tab" onclick="switchTab('register')">Register</button>
            </div>
            
            <!-- Login Form -->
            <div id="loginTab" class="modal-tab-content active">
                <form id="loginForm">
                    <input type="email" class="modal-input" placeholder="Email address" name="email" required>
                    <input type="password" class="modal-input" placeholder="Password" name="password" required>
                    <button type="submit" class="modal-btn">Login</button>
                    <div id="loginError" class="modal-error"></div>
                    <div style="text-align:center;margin-top:16px;">
                        <a href="#" style="color:#2563eb;font-size:13px;" onclick="switchTab('register')">Don't have an account? Register</a>
                    </div>
                </form>
            </div>
            
            <!-- Register Form -->
            <div id="registerTab" class="modal-tab-content">
                <form id="registerForm">
                    <input type="text" class="modal-input" placeholder="Full Name" name="name" required>
                    <input type="email" class="modal-input" placeholder="Email address" name="email" required>
                    <input type="tel" class="modal-input" placeholder="Phone (optional)" name="phone">
                    <input type="password" class="modal-input" placeholder="Password" name="password" required>
                    <input type="password" class="modal-input" placeholder="Confirm Password" name="password_confirmation" required>
                    <button type="submit" class="modal-btn">Create Account</button>
                    <div id="registerError" class="modal-error"></div>
                    <div style="text-align:center;margin-top:16px;">
                        <a href="#" style="color:#2563eb;font-size:13px;" onclick="switchTab('login')">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openModal() {
            document.getElementById('authModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            document.getElementById('authModal').classList.remove('active');
            document.body.style.overflow = '';
        }
        
        function switchTab(tab) {
            // Update tabs
            document.querySelectorAll('.modal-tab').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Update content
            document.querySelectorAll('.modal-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            if (tab === 'login') {
                document.getElementById('loginTab').classList.add('active');
            } else {
                document.getElementById('registerTab').classList.add('active');
            }
            
            // Clear errors
            document.querySelectorAll('.modal-error').forEach(error => {
                error.style.display = 'none';
            });
        }
        
        // Close modal on overlay click
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Handle login form
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const errorDiv = document.getElementById('loginError');
            
            fetch('/login', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    errorDiv.textContent = data.message || 'Login failed. Please check your credentials.';
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.style.display = 'block';
            });
        });
        
        // Handle register form
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const errorDiv = document.getElementById('registerError');
            
            fetch('/register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    errorDiv.textContent = data.message || 'Registration failed. Please try again.';
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.style.display = 'block';
            });
        });
        
        // Replace login link with modal trigger
        document.addEventListener('DOMContentLoaded', function() {
            const loginLink = document.querySelector('.top-bar .auth a[href*="login"]');
            if (loginLink) {
                loginLink.href = '#';
                loginLink.onclick = function(e) {
                    e.preventDefault();
                    openModal();
                };
            }
            
            // Also replace Join Now link (optional - could keep as separate page)
            const joinLink = document.querySelector('.top-bar .auth .join-btn');
            if (joinLink) {
                joinLink.href = '#';
                joinLink.onclick = function(e) {
                    e.preventDefault();
                    openModal();
                    switchTab('register');
                    // Make register tab active
                    document.querySelectorAll('.modal-tab').forEach((btn, index) => {
                        btn.classList.toggle('active', index === 1);
                    });
                };
            }
            
            // Replace simulate button login popup
            const simulateButtons = document.querySelectorAll('button[onclick="simulatePick"]');
            simulateButtons.forEach(btn => {
                const originalOnclick = btn.getAttribute('onclick');
                if (originalOnclick && originalOnclick.includes('showLoginPopup')) {
                    btn.onclick = function(e) {
                        e.preventDefault();
                        openModal();
                    };
                }
            });
        });
    </script>
</body>
</html>

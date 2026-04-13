<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'INSPIN')</title>
    <style>
        /* ===== TOKENS ===== */
        :root {
            --black:      #09090b;
            --black-soft: #18181b;
            --black-border:#27272a;
            --gold:       #f59e0b;
            --gold-light: #fcd34d;
            --gold-dark:  #d97706;
            --gold-glow:  rgba(245,158,11,0.22);
            --white:      #fafafa;
            --surface:    #f4f4f5;
            --surface-2:  #e4e4e7;
            --text:       #18181b;
            --text-muted: #71717a;
            --text-dim:   #a1a1aa;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--surface);
            color: var(--text);
            min-height: 100vh;
        }

        /* ===== LAYOUT ===== */
        .auth-layout { display: flex; min-height: 100vh; }

        /* ===== LEFT — brand panel ===== */
        .auth-brand {
            flex: 1;
            background: radial-gradient(ellipse at 30% 20%, #1c1917 0%, var(--black) 60%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 56px 48px;
            position: relative;
            overflow: hidden;
        }
        /* dot texture */
        .auth-brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f59e0b' fill-opacity='0.035'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        /* ambient glow circles */
        .auth-brand::after {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -60px;
            width: 340px;
            height: 340px;
            background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 65%);
            pointer-events: none;
        }
        .auth-brand-glow {
            position: absolute;
            top: -80px;
            left: -80px;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(245,158,11,0.07) 0%, transparent 70%);
            pointer-events: none;
        }
        /* gold rule at top */
        .auth-brand-top-rule {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold-dark), var(--gold), var(--gold-light), var(--gold), var(--gold-dark), transparent);
        }

        .auth-brand-content { position: relative; z-index: 1; text-align: center; max-width: 460px; }

        .auth-brand-logo { margin-bottom: 36px; }
        .auth-brand-logo img { max-width: 160px; height: auto; display: block; margin: 0 auto; filter: drop-shadow(0 4px 16px rgba(245,158,11,0.25)); }

        .auth-brand h2 {
            color: var(--white);
            font-size: 1.65rem;
            margin-bottom: 14px;
            font-weight: 900;
            letter-spacing: -0.3px;
            line-height: 1.25;
        }
        .auth-brand h2 span {
            background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--gold-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .auth-brand p { color: #71717a; font-size: 14.5px; line-height: 1.75; }

        /* divider */
        .auth-brand-divider {
            width: 48px; height: 2px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold));
            margin: 28px auto;
            border-radius: 2px;
        }

        /* stats row */
        .auth-brand-stats { display: flex; gap: 0; margin-top: 8px; justify-content: center; border: 1px solid var(--black-border); border-radius: 14px; overflow: hidden; }
        .auth-brand-stat {
            flex: 1;
            text-align: center;
            padding: 18px 12px;
            background: rgba(24,24,27,0.5);
            border-right: 1px solid var(--black-border);
            backdrop-filter: blur(4px);
        }
        .auth-brand-stat:last-child { border-right: none; }
        .auth-brand-stat .num {
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: -0.5px;
            line-height: 1;
        }
        .auth-brand-stat .lbl { color: #52525b; font-size: 11px; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }

        /* trust badge */
        .auth-trust {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 28px;
            background: rgba(245,158,11,0.06);
            border: 1px solid rgba(245,158,11,0.15);
            border-radius: 10px;
            padding: 10px 16px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
        .auth-trust-icon { font-size: 16px; }
        .auth-trust-text { color: #a1a1aa; font-size: 12.5px; }
        .auth-trust-text strong { color: var(--gold); }

        /* ===== RIGHT — form panel ===== */
        .auth-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            background: var(--surface);
            position: relative;
        }
        .auth-form-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 1px; height: 100%;
            background: linear-gradient(180deg, transparent, var(--surface-2) 30%, var(--surface-2) 70%, transparent);
        }

        .auth-form { width: 100%; max-width: 420px; }

        /* back link */
        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 32px;
            transition: color 0.15s;
        }
        .auth-back:hover { color: var(--text); }
        .auth-back svg { width: 14px; height: 14px; }

        /* card wrapper */
        .auth-card {
            background: var(--white);
            border: 1px solid var(--surface-2);
            border-radius: 20px;
            padding: 36px 32px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            position: relative;
            overflow: hidden;
        }
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold), var(--gold-light), var(--gold), var(--gold-dark));
        }

        .auth-form-header { margin-bottom: 28px; }
        .auth-form-header .auth-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--black) 0%, var(--black-soft) 100%);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }
        .auth-form-header .auth-icon svg { width: 22px; height: 22px; color: var(--gold); }
        .auth-form-header h1 { color: var(--text); font-size: 1.6rem; font-weight: 900; margin-bottom: 6px; letter-spacing: -0.3px; }
        .auth-form-header p { color: var(--text-muted); font-size: 14px; line-height: 1.6; }

        /* form fields */
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block; font-weight: 600; margin-bottom: 7px;
            font-size: 13.5px; color: var(--text);
        }
        .form-group input {
            width: 100%; padding: 12px 16px;
            background: var(--surface);
            border: 1.5px solid var(--surface-2);
            border-radius: 10px;
            color: var(--text);
            font-size: 15px;
            transition: all 0.2s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--gold);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(245,158,11,0.1);
        }
        .form-group input::placeholder { color: var(--text-dim); }

        .form-row { display: flex; gap: 12px; }
        .form-row .form-group { flex: 1; }

        .form-options {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 22px;
        }
        .form-options label {
            display: flex; align-items: center; gap: 8px;
            font-size: 13.5px; color: var(--text-muted); cursor: pointer;
        }
        .form-options label input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--gold); }
        .form-options a { color: var(--gold-dark); font-size: 13.5px; font-weight: 600; transition: color 0.15s; }
        .form-options a:hover { color: var(--gold); }

        /* submit button */
        .btn-submit {
            display: block; width: 100%; padding: 14px;
            background: linear-gradient(135deg, var(--black) 0%, var(--black-soft) 100%);
            color: var(--gold);
            border: none; border-radius: 11px; cursor: pointer;
            font-size: 15px; font-weight: 800;
            transition: all 0.2s; letter-spacing: 0.2px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, var(--black-soft) 0%, #3f3f46 100%);
            box-shadow: 0 6px 22px rgba(0,0,0,0.25);
            transform: translateY(-1px);
        }
        .btn-submit:active { transform: translateY(0); }

        /* divider */
        .auth-divider { text-align: center; margin: 22px 0; position: relative; }
        .auth-divider::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: var(--surface-2); }
        .auth-divider span { position: relative; background: var(--white); padding: 0 14px; color: var(--text-dim); font-size: 12.5px; }

        /* footer */
        .auth-footer { text-align: center; margin-top: 20px; font-size: 13.5px; color: var(--text-muted); }
        .auth-footer a { color: var(--gold-dark); font-weight: 700; text-decoration: none; transition: color 0.15s; }
        .auth-footer a:hover { color: var(--gold); }

        /* alerts */
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-danger { background: #fff1f2; color: #9f1239; border: 1px solid #fecdd3; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .error-list { list-style: none; padding: 0; margin: 0 0 16px 0; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 10px; padding: 12px 16px; }
        .error-list li { color: #9f1239; font-size: 13px; margin-bottom: 4px; padding-left: 14px; position: relative; }
        .error-list li:last-child { margin-bottom: 0; }
        .error-list li::before { content: '•'; position: absolute; left: 0; color: #f43f5e; font-weight: 700; }

        /* ===== MOBILE ===== */
        @media (max-width: 900px) {
            .auth-brand { display: none; }
            .auth-form-panel { padding: 24px 20px; background: var(--surface); }
            .auth-form-panel::before { display: none; }
            .auth-card { padding: 28px 22px; }
        }
    </style>
</head>
<body>
    <div class="auth-layout">

        {{-- ===== LEFT: Brand Panel ===== --}}
        <div class="auth-brand">
            <div class="auth-brand-top-rule"></div>
            <div class="auth-brand-glow"></div>
            <div class="auth-brand-content">
                <div class="auth-brand-logo">
                    <img src="{{ asset('images/inspin-logo.png') }}" alt="INSPIN — Insider Picks Sports Information">
                </div>

                <h2>Expert Sports Betting <span>Analysis & Picks</span></h2>
                <p>Our simulation model runs every NFL, NBA, MLB, and NHL game thousands of times so you don't have to guess. Join thousands of members already winning.</p>

                <div class="auth-brand-divider"></div>

                <div class="auth-brand-stats">
                    <div class="auth-brand-stat">
                        <div class="num">+150</div>
                        <div class="lbl">Units Won</div>
                    </div>
                    <div class="auth-brand-stat">
                        <div class="num">3 Yrs</div>
                        <div class="lbl">Track Record</div>
                    </div>
                    <div class="auth-brand-stat">
                        <div class="num">6</div>
                        <div class="lbl">Sports</div>
                    </div>
                </div>

                <div class="auth-trust">
                    <span class="auth-trust-icon">🔒</span>
                    <span class="auth-trust-text"><strong>Secure &amp; private.</strong> We never share your data.</span>
                </div>
            </div>
        </div>

        {{-- ===== RIGHT: Form Panel ===== --}}
        <div class="auth-form-panel">
            <div class="auth-form">
                <a href="{{ route('home') }}" class="auth-back">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to INSPIN
                </a>
                <div class="auth-card">
                    @yield('content')
                </div>
            </div>
        </div>

    </div>
</body>
</html>

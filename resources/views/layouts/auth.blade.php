<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'INSPIN')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; color: #0f172a; min-height: 100vh; }

        .auth-layout { display: flex; min-height: 100vh; }

        /* Left panel - branding */
        .auth-brand {
            flex: 1;
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }
        .auth-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 70%, rgba(220,38,38,0.15) 0%, transparent 50%),
                        radial-gradient(circle at 70% 30%, rgba(37,99,235,0.15) 0%, transparent 50%);
        }
        .auth-brand-content { position: relative; z-index: 1; text-align: center; max-width: 480px; }
        .auth-brand-logo { font-size: 2.5rem; font-weight: 900; color: #fff; margin-bottom: 32px; letter-spacing: -1px; }
        .auth-brand-logo span { color: #fbbf24; }
        .auth-brand h2 { color: #fff; font-size: 1.75rem; margin-bottom: 16px; font-weight: 700; }
        .auth-brand p { color: #94a3b8; font-size: 15px; line-height: 1.7; }
        .auth-brand-stats { display: flex; gap: 32px; margin-top: 40px; justify-content: center; }
        .auth-brand-stat { text-align: center; }
        .auth-brand-stat .num { color: #fbbf24; font-size: 1.75rem; font-weight: 800; }
        .auth-brand-stat .label { color: #64748b; font-size: 12px; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Right panel - form */
        .auth-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            background: #fff;
        }
        .auth-form { width: 100%; max-width: 420px; }
        .auth-form-header { margin-bottom: 32px; }
        .auth-form-header h1 { color: #0f172a; font-size: 1.75rem; font-weight: 800; margin-bottom: 8px; }
        .auth-form-header p { color: #64748b; font-size: 14px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; color: #374151; }
        .form-group input {
            width: 100%; padding: 12px 16px; background: #f8fafc; border: 1.5px solid #e2e8f0;
            border-radius: 10px; color: #0f172a; font-size: 15px; transition: all 0.2s;
        }
        .form-group input:focus { outline: none; border-color: #2563eb; background: #fff; box-shadow: 0 0 0 4px rgba(37,99,235,0.08); }
        .form-group input::placeholder { color: #94a3b8; }

        .form-row { display: flex; gap: 12px; }
        .form-row .form-group { flex: 1; }

        .form-options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .form-options label { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #475569; cursor: pointer; }
        .form-options label input[type="checkbox"] { width: 16px; height: 16px; accent-color: #2563eb; }
        .form-options a { color: #2563eb; font-size: 14px; font-weight: 500; }
        .form-options a:hover { color: #1d4ed8; }

        .btn-submit {
            display: block; width: 100%; padding: 14px; background: #dc2626; color: #fff;
            border: none; border-radius: 10px; cursor: pointer; font-size: 16px;
            font-weight: 700; transition: all 0.2s; letter-spacing: 0.3px;
        }
        .btn-submit:hover { background: #b91c1c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,38,38,0.3); }
        .btn-submit:active { transform: translateY(0); }

        .auth-divider { text-align: center; margin: 24px 0; position: relative; }
        .auth-divider::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #e2e8f0; }
        .auth-divider span { position: relative; background: #fff; padding: 0 16px; color: #94a3b8; font-size: 13px; }

        .auth-footer { text-align: center; margin-top: 24px; font-size: 14px; color: #64748b; }
        .auth-footer a { color: #2563eb; font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { color: #1d4ed8; text-decoration: underline; }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .error-list { list-style: none; padding: 0; margin: 0 0 16px 0; }
        .error-list li { color: #dc2626; font-size: 13px; margin-bottom: 4px; padding-left: 16px; position: relative; }
        .error-list li::before { content: '•'; position: absolute; left: 0; color: #dc2626; font-weight: 700; }

        /* Mobile */
        @media (max-width: 900px) {
            .auth-brand { display: none; }
            .auth-form-panel { padding: 32px 20px; }
        }
    </style>
</head>
<body>
    <div class="auth-layout">
        <div class="auth-brand">
            <div class="auth-brand-content">
                <div class="auth-brand-logo">INSPIN<span>.com</span></div>
                <h2>Expert Sports Betting Analysis</h2>
                <p>Access our simulation model that's been up over 150 units in the last 3 years. Get daily picks, betting consensus, live odds, and expert analysis for NFL, NBA, MLB, and NHL.</p>
                <div class="auth-brand-stats">
                    <div class="auth-brand-stat">
                        <div class="num">+150</div>
                        <div class="label">Units Won</div>
                    </div>
                    <div class="auth-brand-stat">
                        <div class="num">1,800+</div>
                        <div class="label">Picks Made</div>
                    </div>
                    <div class="auth-brand-stat">
                        <div class="num">4</div>
                        <div class="label">Sports</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="auth-form-panel">
            <div class="auth-form">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>

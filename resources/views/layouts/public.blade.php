<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'INSPIN - Sports Betting Analysis & Picks')</title>
    <meta name="description" content="@yield('meta', 'INSPIN - Expert sports betting analysis, daily picks, betting consensus, live odds, and trends for NFL, NBA, MLB, NHL.')">
    <style>
        /* ===== DESIGN TOKENS ===== */
        :root {
            --black:       #09090b;   /* zinc-950 — richer than pure black */
            --black-soft:  #18181b;   /* zinc-900 — surfaces in dark sections */
            --black-border:#27272a;   /* zinc-800 — subtle borders on dark bg */
            --black-hover: #3f3f46;   /* zinc-700 — hover state on dark */
            --gold:        #f59e0b;   /* amber-500 — refined gold */
            --gold-light:  #fcd34d;   /* amber-300 — highlights */
            --gold-dark:   #d97706;   /* amber-600 — gold hover */
            --gold-glow:   rgba(245,158,11,0.25);
            --white:       #fafafa;   /* warm white */
            --surface:     #f4f4f5;   /* zinc-100 — page background */
            --surface-2:   #e4e4e7;   /* zinc-200 — card borders */
            --text:        #18181b;   /* zinc-900 — primary text */
            --text-muted:  #71717a;   /* zinc-500 */
            --text-dim:    #a1a1aa;   /* zinc-400 */
        }

        /* ===== BASE ===== */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { overflow-x: hidden; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: var(--surface); color: var(--text); line-height: 1.6; overflow-x: hidden; max-width: 100vw; }
        a { color: var(--text); text-decoration: none; transition: color 0.15s; }
        a:hover { color: var(--gold); }
        img { max-width: 100%; }

        /* ===== TOP BAR ===== */
        .top-bar { background: var(--black); border-bottom: 1px solid var(--black-border); padding: 7px 0; font-size: 13px; }
        .top-bar .wrap { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .top-bar .tagline { color: var(--text-dim); font-size: 11.5px; letter-spacing: 0.2px; }
        .top-bar .auth { display: flex; gap: 16px; align-items: center; }
        .top-bar .auth a { color: #d4d4d8; font-weight: 600; font-size: 13px; transition: color 0.15s; }
        .top-bar .auth a:hover { color: var(--gold-light); }
        .top-bar .auth .join-btn { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%); color: var(--black); padding: 5px 16px; border-radius: 6px; font-size: 12.5px; font-weight: 700; letter-spacing: 0.2px; box-shadow: 0 2px 8px var(--gold-glow); transition: all 0.2s; }
        .top-bar .auth .join-btn:hover { background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%); box-shadow: 0 4px 14px var(--gold-glow); color: var(--black); transform: translateY(-1px); }

        /* ===== HEADER — sticky glass ===== */
        .header { background: rgba(9,9,11,0.97); border-bottom: 1px solid var(--black-border); position: sticky; top: 0; z-index: 100; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 1px 0 var(--black-border), 0 4px 24px rgba(0,0,0,0.4); }
        .header::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent 0%, var(--gold) 30%, var(--gold-light) 50%, var(--gold) 70%, transparent 100%); }
        .header .wrap { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { padding: 10px 0; }
        .logo img { height: 48px; width: auto; }

        /* ===== NAV ===== */
        .nav { display: flex; gap: 0; list-style: none; flex-wrap: wrap; transform: none; visibility: visible; }
        .nav a { display: block; padding: 17px 13px; color: #a1a1aa; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; transition: all 0.18s; border-bottom: 2px solid transparent; margin-bottom: -1px; position: relative; }
        .nav a:hover { color: var(--white); }
        .nav a.active { color: var(--gold); border-bottom-color: var(--gold); }
        .nav a.active::after, .nav a:hover::after { content: ''; position: absolute; bottom: -1px; left: 50%; transform: translateX(-50%); width: 60%; height: 2px; background: linear-gradient(90deg, transparent, var(--gold), transparent); border-radius: 2px; }
        .nav a.active::after { width: 80%; }

        /* ===== CONTAINER ===== */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 20px; }

        /* ===== HERO ===== */
        .hero { background: radial-gradient(ellipse at 50% -20%, #1c1917 0%, var(--black) 55%); padding: 80px 0 72px; text-align: center; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f59e0b' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); opacity: 1; }
        .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent 0%, var(--gold-dark) 20%, var(--gold) 40%, var(--gold-light) 50%, var(--gold) 60%, var(--gold-dark) 80%, transparent 100%); }
        .hero h1 { font-size: 2.75rem; color: var(--white); margin-bottom: 18px; font-weight: 900; letter-spacing: -0.75px; line-height: 1.2; position: relative; }
        .hero h1 span { background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 50%, var(--gold-dark) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero p { color: #a1a1aa; max-width: 640px; margin: 0 auto 36px; font-size: 16px; line-height: 1.75; position: relative; }
        .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; position: relative; }

        /* ===== BUTTONS ===== */
        .btn { display: inline-block; padding: 13px 30px; border-radius: 9px; font-weight: 700; font-size: 15px; cursor: pointer; border: none; transition: all 0.2s; text-align: center; letter-spacing: 0.1px; }
        .btn-red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff; box-shadow: 0 4px 14px rgba(220,38,38,0.3); }
        .btn-red:hover { background: linear-gradient(135deg, #f87171 0%, #ef4444 100%); box-shadow: 0 6px 20px rgba(220,38,38,0.4); transform: translateY(-1px); color: #fff; }
        .btn-yellow { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%); color: var(--black); box-shadow: 0 4px 14px var(--gold-glow); }
        .btn-yellow:hover { background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%); box-shadow: 0 6px 20px rgba(245,158,11,0.4); transform: translateY(-1px); color: var(--black); }
        .btn-green { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); color: #fff; }
        .btn-green:hover { background: linear-gradient(135deg, #86efac 0%, #4ade80 100%); transform: translateY(-1px); color: #fff; }
        .btn-blue { background: #2563eb; color: #fff; }
        .btn-blue:hover { background: #1d4ed8; color: #fff; }
        .btn-outline { background: transparent; color: var(--white); border: 1.5px solid rgba(255,255,255,0.2); backdrop-filter: blur(4px); }
        .btn-outline:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.4); color: var(--white); }
        .btn-outline-dark { background: transparent; color: var(--text-muted); border: 1px solid var(--surface-2); border-radius: 8px; }
        .btn-outline-dark:hover { background: var(--surface-2); color: var(--text); }

        /* ===== SECTIONS ===== */
        .section { padding: 56px 0; }
        .section-alt { background: var(--white); }
        .section-title { font-size: 1.85rem; color: var(--text); margin-bottom: 8px; font-weight: 900; padding-left: 16px; border-left: 4px solid var(--gold); letter-spacing: -0.3px; }
        .section-sub { color: var(--text-muted); margin-bottom: 36px; font-size: 15px; padding-left: 20px; }

        /* ===== GRID ===== */
        .grid { display: grid; gap: 24px; }
        .grid-2 { grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); }
        .grid-3 { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }
        .grid-4 { grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); }

        /* ===== CARDS ===== */
        .card { background: var(--white); border: 1px solid var(--surface-2); border-top: 3px solid transparent; border-radius: 14px; overflow: hidden; transition: box-shadow 0.25s, transform 0.2s, border-top-color 0.25s; }
        .card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.09), 0 0 0 1px rgba(245,158,11,0.15); transform: translateY(-3px); border-top-color: var(--gold); }
        .card-body { padding: 24px; }
        .card h3 { color: var(--text); margin-bottom: 8px; font-size: 1.05rem; font-weight: 700; }
        .card p { color: var(--text-muted); font-size: 14px; }
        .card-meta { display: flex; gap: 12px; font-size: 12px; color: var(--text-dim); margin-top: 12px; }
        .card-meta span { display: flex; align-items: center; gap: 4px; }

        /* ===== BADGES ===== */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
        .badge-nfl { background: #dbeafe; color: #1d4ed8; }
        .badge-nba { background: #fee2e2; color: #dc2626; }
        .badge-mlb { background: #dcfce7; color: #16a34a; }
        .badge-nhl { background: #f3e8ff; color: #9333ea; }
        .badge-ncaa { background: #fef3c7; color: #b45309; }
        .badge-ncaaf { background: #fef3c7; color: #b45309; }
        .badge-ncaab { background: #fef3c7; color: #b45309; }
        .badge-general { background: var(--surface); color: var(--text-muted); }
        .badge-premium { background: #fef3c7; color: #92400e; }
        .badge-free { background: #f0fdf4; color: #16a34a; }
        .badge-consensus { background: #dcfce7; color: #16a34a; }
        .badge-trends { background: #f3e8ff; color: #9333ea; }
        .badge-analysis { background: #fefce8; color: #92400e; }
        .badge-picks { background: #fefce8; color: #92400e; }
        .badge-news { background: var(--surface); color: var(--text-muted); }

        /* ===== TABLES ===== */
        .c-table { width: 100%; border-collapse: collapse; background: var(--white); border-radius: 14px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 0 0 1px var(--surface-2); }
        .c-table th { background: var(--black); color: var(--gold); padding: 13px 16px; text-align: left; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 2px solid var(--black-border); font-weight: 700; }
        .c-table td { padding: 12px 16px; border-bottom: 1px solid var(--surface); font-size: 14px; }
        .c-table tr:hover { background: #fffbeb; }
        .pct-bar { height: 6px; border-radius: 4px; background: var(--surface-2); overflow: hidden; width: 80px; }
        .pct-fill { height: 100%; border-radius: 4px; }
        .pct-green { background: linear-gradient(90deg, #4ade80, #22c55e); }
        .pct-red { background: linear-gradient(90deg, #f87171, #dc2626); }

        /* ===== PACKAGES (legacy class) ===== */
        .pkg-card { background: var(--white); border: 1.5px solid var(--surface-2); border-radius: 16px; padding: 32px; text-align: center; transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s; }
        .pkg-card:hover { border-color: var(--gold); box-shadow: 0 8px 28px var(--gold-glow); transform: translateY(-2px); }
        .pkg-card.featured { border-color: var(--black); position: relative; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .pkg-card.featured::before { content: 'POPULAR'; position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, var(--black-soft), var(--black)); color: var(--gold); padding: 4px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; }
        .pkg-card h3 { color: var(--text); font-size: 1.25rem; margin-bottom: 4px; }
        .pkg-price { font-size: 2.5rem; font-weight: 900; color: var(--text); margin: 16px 0; }
        .pkg-price sup { font-size: 1rem; color: var(--text-muted); }
        .pkg-duration { color: var(--text-muted); font-size: 14px; margin-bottom: 20px; }
        .pkg-features { list-style: none; text-align: left; margin: 20px 0; }
        .pkg-features li { padding: 8px 0; font-size: 14px; color: var(--text-muted); border-bottom: 1px solid var(--surface); }
        .pkg-features li:last-child { border-bottom: none; }
        .pkg-features li::before { content: '✓'; color: var(--gold); margin-right: 8px; font-weight: 700; }

        /* ===== CTA ===== */
        .cta { background: linear-gradient(135deg, var(--black) 0%, #1c1917 60%, var(--black) 100%); padding: 60px 40px; text-align: center; border-radius: 20px; margin: 32px 0; border: 1px solid var(--black-border); position: relative; overflow: hidden; }
        .cta::before { content: ''; position: absolute; top: -80px; left: 50%; transform: translateX(-50%); width: 400px; height: 200px; background: radial-gradient(ellipse, rgba(245,158,11,0.12) 0%, transparent 70%); pointer-events: none; }
        .cta::after { content: ''; position: absolute; bottom: 0; left: 10%; right: 10%; height: 1px; background: linear-gradient(90deg, transparent, var(--black-border), transparent); }
        .cta h2 { color: var(--white); font-size: 1.85rem; margin-bottom: 14px; font-weight: 900; letter-spacing: -0.3px; position: relative; }
        .cta p { color: #a1a1aa; margin-bottom: 28px; font-size: 16px; position: relative; }
        .cta .btn { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%); color: var(--black); font-weight: 800; box-shadow: 0 4px 18px var(--gold-glow); position: relative; }
        .cta .btn:hover { background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%); box-shadow: 0 6px 24px rgba(245,158,11,0.45); transform: translateY(-2px); }

        /* ===== FOOTER ===== */
        .footer { background: var(--black); padding: 40px 0; margin-top: 0; border-top: 1px solid var(--black-border); position: relative; }
        .footer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent 0%, var(--gold-dark) 25%, var(--gold) 50%, var(--gold-dark) 75%, transparent 100%); }
        .footer .wrap { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .footer-links { display: flex; gap: 20px; list-style: none; flex-wrap: wrap; }
        .footer-links a { color: #52525b; font-size: 13px; transition: color 0.15s; }
        .footer-links a:hover { color: var(--gold); }
        .footer-copy { color: #3f3f46; font-size: 13px; }
        .social-icons { display: flex; gap: 10px; align-items: center; }
        .social-icons a { display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: var(--black-soft); border: 1px solid var(--black-border); transition: all 0.2s; }
        .social-icons a:hover { background: var(--black-hover); border-color: var(--gold); box-shadow: 0 0 10px var(--gold-glow); }
        .social-icons img { width: 18px; height: 18px; }

        /* ===== PAGE ===== */
        .page { max-width: 900px; margin: 0 auto; padding: 52px 20px; }
        .page h1 { color: var(--text); font-size: 2rem; margin-bottom: 24px; font-weight: 800; }
        .page h2 { color: var(--text); font-size: 1.4rem; margin: 32px 0 12px; font-weight: 700; }
        .page p { color: var(--text-muted); margin-bottom: 16px; line-height: 1.8; }

        /* ===== ARTICLE DETAIL ===== */
        .article-detail { max-width: 800px; margin: 0 auto; padding: 52px 20px; }
        .article-detail h1 { color: var(--text); font-size: 2rem; margin-bottom: 16px; line-height: 1.3; font-weight: 800; }
        .article-detail .meta { display: flex; gap: 16px; font-size: 13px; color: var(--text-muted); margin-bottom: 28px; }
        .article-detail .content { color: #3f3f46; line-height: 1.85; }
        .article-detail .content p { margin-bottom: 16px; }

        /* ===== PAGINATION ===== */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 32px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 8px 14px; border-radius: 8px; font-size: 14px; }
        .pagination a { background: var(--white); border: 1px solid var(--surface-2); color: var(--text-muted); transition: all 0.15s; }
        .pagination a:hover { background: #fffbeb; border-color: var(--gold); color: var(--text); }
        .pagination .active { background: linear-gradient(135deg, var(--black) 0%, var(--black-soft) 100%); color: var(--gold); border-color: var(--black); font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .pagination .disabled { opacity: 0.4; pointer-events: none; }

        /* ===== SPORT FILTER ===== */
        .sport-filter { display: flex; gap: 8px; margin-bottom: 28px; flex-wrap: wrap; }
        .sport-filter a { padding: 8px 18px; border-radius: 24px; font-size: 13px; font-weight: 600; background: var(--white); border: 1px solid var(--surface-2); color: var(--text-muted); transition: all 0.18s; }
        .sport-filter a:hover { background: var(--surface); border-color: var(--black-border); color: var(--text); }
        .sport-filter a.active { background: var(--black); border-color: var(--black); color: var(--gold); box-shadow: 0 2px 10px rgba(0,0,0,0.2); }

        /* ===== ADMIN (unchanged — admin pages only) ===== */
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

        /* ===== HAMBURGER ===== */
        .hamburger { display: none; flex-direction: column; justify-content: center; gap: 5px; cursor: pointer; padding: 8px 6px; background: none; border: 1px solid var(--black-border); border-radius: 8px; z-index: 201; }
        .hamburger span { display: block; width: 22px; height: 2px; background: #a1a1aa; border-radius: 2px; transition: all 0.3s; }
        .hamburger:hover span { background: var(--gold); }
        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); background: var(--gold); }
        .hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); background: var(--gold); }

        /* Mobile nav overlay — must stay below header (z-index:100) so nav links are clickable */
        .nav-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 99; }
        .nav-overlay.open { display: block; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            /* Top bar */
            .top-bar .wrap { flex-direction: column; gap: 6px; text-align: center; }
            .top-bar .tagline { font-size: 11px; }

            /* Header */
            .header .wrap { padding: 0 16px; }
            .logo img { height: 40px; }

            /* Hamburger on, nav off by default */
            .hamburger { display: flex; }
            .nav {
                position: fixed;
                top: 0; right: 0;
                width: 280px; height: 100vh;
                background: var(--black);
                border-left: 1px solid var(--black-border);
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                z-index: 101;
                transform: translateX(100%);
                transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
                padding-top: 70px;
                box-shadow: -8px 0 40px rgba(0,0,0,0.5);
                overflow-y: auto;
                visibility: hidden;
            }
            .nav.open { transform: translateX(0); visibility: visible; }
            .nav a { padding: 16px 24px; font-size: 13px; border-bottom: 1px solid var(--black-border); margin-bottom: 0; }
            .nav a.active::after, .nav a:hover::after { display: none; }

            /* Hero */
            .hero { padding: 44px 0 36px; }
            .hero h1 { font-size: 1.65rem; letter-spacing: -0.3px; }
            .hero p { font-size: 14px; }
            .hero-actions { gap: 10px; }
            .btn { padding: 12px 22px; font-size: 14px; }

            /* Sections */
            .section { padding: 40px 0; }
            .section-title { font-size: 1.45rem; }
            .container { padding: 0 16px; }

            /* Grids */
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }

            /* Admin */
            .admin-form-row { flex-direction: column; }

            /* CTA */
            .cta { padding: 36px 20px; border-radius: 14px; }
            .cta h2 { font-size: 1.45rem; }

            /* Footer */
            .footer .wrap { flex-direction: column; gap: 24px; }
            .footer-links { gap: 12px; }

            /* Modal */
            .modal-box { padding: 24px 20px; width: 95%; }
        }

        @media (max-width: 480px) {
            .hero h1 { font-size: 1.4rem; }
            .hero p { font-size: 13.5px; }
            .section-title { font-size: 1.3rem; }
            .top-bar .auth { gap: 10px; }
        }
    </style>
    @stack('styles')
    <style>
        /* ===== MODAL ===== */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); }
        .modal-overlay.active { display: flex; }
        .modal-box { background: var(--white); border-radius: 18px; padding: 32px; max-width: 400px; width: 90%; box-shadow: 0 32px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05); text-align: center; animation: modalIn 0.22s cubic-bezier(0.34,1.56,0.64,1); position: relative; overflow: hidden; }
        .modal-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--gold-dark), var(--gold), var(--gold-light), var(--gold), var(--gold-dark)); }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.92) translateY(12px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .modal-tabs { display: flex; margin-bottom: 24px; border-radius: 10px; overflow: hidden; border: 1px solid var(--surface-2); gap: 2px; background: var(--surface); padding: 3px; }
        .modal-tab { flex: 1; padding: 10px; background: transparent; border: none; font-weight: 700; cursor: pointer; transition: all 0.2s; color: var(--text-muted); border-radius: 8px; font-size: 14px; }
        .modal-tab.active { background: var(--black); color: var(--gold); box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .modal-tab-content { display: none; text-align: left; }
        .modal-tab-content.active { display: block; }
        .modal-input { width: 100%; padding: 12px 16px; border: 1.5px solid var(--surface-2); border-radius: 9px; font-size: 14px; margin-bottom: 12px; transition: all 0.2s; background: var(--surface); color: var(--text); }
        .modal-input:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 0 4px rgba(245,158,11,0.12); background: var(--white); }
        .modal-btn { width: 100%; padding: 14px; background: linear-gradient(135deg, var(--black) 0%, var(--black-soft) 100%); color: var(--gold); border: none; border-radius: 9px; font-weight: 800; font-size: 15px; cursor: pointer; margin-top: 8px; transition: all 0.2s; letter-spacing: 0.2px; }
        .modal-btn:hover { background: linear-gradient(135deg, var(--black-soft) 0%, var(--black-hover) 100%); box-shadow: 0 4px 14px rgba(0,0,0,0.3); transform: translateY(-1px); }
        .modal-error { color: #ef4444; font-size: 13px; margin-top: 8px; display: none; }
        .modal-close { position: absolute; top: 16px; right: 16px; background: var(--surface); border: 1px solid var(--surface-2); border-radius: 6px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-dim); font-size: 16px; line-height: 1; transition: all 0.15s; }
        .modal-close:hover { background: var(--surface-2); color: var(--text); }
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

    <div class="nav-overlay" id="navOverlay" onclick="closeNav()"></div>
    <header class="header">
        <div class="wrap">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/inspin-logo.png') }}?v=2" alt="INSPIN - Insider Picks Sports Information">
            </a>
            <ul class="nav" id="mainNav">
                <li><a href="{{ route('articles') }}" class="{{ request()->routeIs('article*') || request()->routeIs('articles') ? 'active' : '' }}">Exclusive Articles</a></li>
                <li><a href="{{ route('picks') }}" class="{{ request()->routeIs('picks') ? 'active' : '' }}">Picks</a></li>
                <li><a href="{{ route('join') }}" class="{{ request()->routeIs('join') ? 'active' : '' }}">Packages</a></li>
                <li><a href="{{ route('odds') }}" class="{{ request()->routeIs('odds') ? 'active' : '' }}">Live Odds</a></li>
                <li><a href="{{ route('consensus') }}" class="{{ request()->routeIs('consensus') ? 'active' : '' }}">Consensus</a></li>
                <li><a href="{{ route('trends') }}" class="{{ request()->routeIs('trends') ? 'active' : '' }}">Trends</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a></li>
            </ul>
            <button class="hamburger" id="hamburger" onclick="toggleNav()" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
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
                <button class="modal-tab" onclick="switchTab('register')">Join Now</button>
            </div>
            
            <!-- Login Form -->
            <div id="loginTab" class="modal-tab-content active">
                <form id="loginForm">
                    <input type="email" class="modal-input" placeholder="Email address" name="email" required>
                    <input type="password" class="modal-input" placeholder="Password" name="password" required>
                    <button type="submit" class="modal-btn">Login</button>
                    <div id="loginError" class="modal-error"></div>
                    <div style="text-align:center;margin-top:12px;">
                        <a href="{{ route('password.request') }}" style="color:#64748b;font-size:13px;">Forgot password?</a>
                    </div>
                    <div style="text-align:center;margin-top:8px;">
                        <a href="#" style="color:#2563eb;font-size:13px;" onclick="switchTab('register')">Don't have an account? Join Now</a>
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
        // Nav toggle
        function toggleNav() {
            var nav = document.getElementById('mainNav');
            var btn = document.getElementById('hamburger');
            var overlay = document.getElementById('navOverlay');
            var isOpen = nav.classList.contains('open');
            if (isOpen) {
                nav.classList.remove('open');
                btn.classList.remove('open');
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            } else {
                nav.classList.add('open');
                btn.classList.add('open');
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
        }
        function closeNav() {
            document.getElementById('mainNav').classList.remove('open');
            document.getElementById('hamburger').classList.remove('open');
            document.getElementById('navOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        // Close nav on resize back to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) closeNav();
        });

        // Modal functions
        function openModal(tab) {
            document.getElementById('authModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            if (tab === 'join') {
                document.querySelectorAll('.modal-tab').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.modal-tab-content').forEach(c => c.classList.remove('active'));
                document.querySelectorAll('.modal-tab')[1].classList.add('active');
                document.getElementById('registerTab').classList.add('active');
                document.getElementById('loginTab').classList.remove('active');
            }
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

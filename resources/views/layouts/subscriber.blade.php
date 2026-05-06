<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Member Portal - INSPIN')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/inspin Logo3.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        html,body { height:100%; }
        body { font-family:'DM Sans',-apple-system,BlinkMacSystemFont,sans-serif; background:#0f0f0f; color:#FFFCEE; line-height:1.6; display:flex; min-height:100vh; }

        /* ── Sidebar ── */
        #sidebar {
            width:240px; flex-shrink:0; background:#141414;
            border-right:1px solid rgba(255,252,238,.07);
            display:flex; flex-direction:column;
            position:fixed; top:0; left:0; height:100vh; z-index:200;
            transition:transform .3s cubic-bezier(.4,0,.2,1);
            overflow:hidden;
        }
        .sidebar-logo {
            padding:18px 20px 16px;
            border-bottom:1px solid rgba(255,252,238,.07);
            flex-shrink:0;
        }
        .sidebar-logo img { height:36px; width:auto; }

        /* User info */
        .sidebar-user {
            padding:12px 16px;
            border-bottom:1px solid rgba(255,252,238,.07);
            display:flex; align-items:center; gap:10px; flex-shrink:0;
        }
        .sidebar-avatar {
            width:34px; height:34px; border-radius:50%;
            background:linear-gradient(135deg,#FDB515,#e09c0d);
            display:flex; align-items:center; justify-content:center;
            font-size:13px; font-weight:800; color:#171818; flex-shrink:0;
        }
        .sidebar-user-name { font-size:12px; font-weight:600; color:#FFFCEE; line-height:1.3; }
        .sidebar-user-pkg { font-size:10px; color:#FDB515; font-weight:600; letter-spacing:.3px; }

        /* Package badge - compact */
        .sidebar-pkg-badge {
            margin:10px 14px 0;
            background:rgba(253,181,21,.06);
            border:1px solid rgba(253,181,21,.15);
            border-radius:8px; padding:10px 12px; flex-shrink:0;
        }
        .sidebar-pkg-badge .pkg-label { font-size:8px; color:#6e6e6e; text-transform:uppercase; letter-spacing:.6px; margin-bottom:3px; }
        .sidebar-pkg-badge .pkg-name { font-size:12px; font-weight:700; color:#FFFCEE; margin-bottom:2px; }
        .sidebar-pkg-badge .pkg-stars { font-size:12px; color:#FDB515; letter-spacing:1px; }
        .sidebar-pkg-badge .pkg-exp { font-size:10px; color:#6e6e6e; margin-top:3px; }

        /* Nav - scrollable */
        .sidebar-nav { flex:1; padding:10px 10px; overflow-y:auto; overflow-x:hidden; min-height:0; }
        .sidebar-nav::-webkit-scrollbar { width:3px; }
        .sidebar-nav::-webkit-scrollbar-track { background:transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background:#2d2d2d; border-radius:3px; }
        .nav-section-label {
            font-size:9px; text-transform:uppercase; letter-spacing:.8px;
            color:#4a4a4a; font-weight:700; padding:0 8px; margin-bottom:4px; margin-top:12px;
        }
        .nav-section-label:first-child { margin-top:4px; }
        .sidebar-link {
            display:flex; align-items:center; gap:9px;
            padding:9px 10px; border-radius:8px;
            font-size:12.5px; font-weight:500; color:#9a9a9a;
            text-decoration:none; transition:all .18s; margin-bottom:1px;
            white-space:nowrap;
        }
        .sidebar-link:hover { background:rgba(255,252,238,.05); color:#FFFCEE; }
        .sidebar-link.active { background:rgba(253,181,21,.1); color:#FDB515; font-weight:600; }
        .sidebar-link svg { flex-shrink:0; opacity:.65; width:15px; height:15px; }
        .sidebar-link.active svg { opacity:1; }
        .sidebar-link .badge {
            margin-left:auto; background:#FDB515; color:#171818;
            font-size:9px; font-weight:800; padding:2px 6px; border-radius:8px;
        }

        /* Units mini card - compact */
        .sidebar-units {
            margin:0 10px 10px; flex-shrink:0;
            background:#1a1a1a; border:1px solid rgba(255,252,238,.06);
            border-radius:8px; padding:10px 12px;
        }
        .sidebar-units .u-label { font-size:8px; color:#6e6e6e; text-transform:uppercase; letter-spacing:.6px; margin-bottom:3px; }
        .sidebar-units .u-value { font-size:1.2rem; font-weight:700; font-family:'Clash Display',sans-serif; line-height:1; }

        /* Back to site */
        .sidebar-back {
            padding:10px 16px; flex-shrink:0;
            border-top:1px solid rgba(255,252,238,.07);
        }
        .sidebar-back a {
            display:flex; align-items:center; gap:8px;
            font-size:11px; color:#3a3a3a; text-decoration:none;
            transition:color .15s;
        }
        .sidebar-back a:hover { color:#6e6e6e; }

        /* ── Main content ── */
        #main {
            margin-left:240px; flex:1; min-height:100vh;
            display:flex; flex-direction:column;
        }
        .portal-header {
            background:rgba(20,20,20,.95); border-bottom:1px solid rgba(255,252,238,.06);
            padding:0 32px; height:60px; display:flex; align-items:center;
            justify-content:space-between; position:sticky; top:0; z-index:100;
            backdrop-filter:blur(12px);
        }
        .portal-header h1 {
            font-family:'Clash Display',sans-serif; font-size:1.1rem;
            font-weight:500; color:#FFFCEE;
        }
        .portal-content { flex:1; padding:32px; width:100%; min-width:0; }

        /* Hamburger for mobile */
        #menuToggle {
            display:none; background:none; border:none; cursor:pointer;
            color:#FFFCEE; padding:4px;
        }
        #sidebarOverlay {
            display:none; position:fixed; inset:0; background:rgba(0,0,0,.6);
            z-index:199;
        }

        @media(max-width:768px){
            #sidebar { transform:translateX(-100%); }
            #sidebar.open { transform:translateX(0); }
            #main { margin-left:0; }
            #menuToggle { display:block; }
            #sidebarOverlay.open { display:block; }
            .portal-content { padding:20px 16px; }
            .portal-header { padding:0 16px; }
        }

        /* ── Stat cards ── */
        .stat-card {
            background:#1a1a1a; border:1px solid rgba(255,252,238,.07);
            border-radius:14px; padding:22px 24px;
            transition:border-color .2s;
        }
        .stat-card:hover { border-color:rgba(253,181,21,.2); }
        .stat-label { font-size:10px; text-transform:uppercase; letter-spacing:.6px; color:#6e6e6e; margin-bottom:8px; }
        .stat-value { font-family:'Clash Display',sans-serif; font-size:2rem; font-weight:600; line-height:1; }
        .stat-sub { font-size:12px; color:#6e6e6e; margin-top:6px; }

        /* ── Alerts ── */
        .portal-alert {
            border-radius:12px; padding:14px 18px;
            display:flex; align-items:center; gap:12px; margin-bottom:20px;
        }
        .portal-alert.extended { background:rgba(99,102,241,.1); border:1px solid rgba(99,102,241,.25); }
        .portal-alert.warning  { background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.2); }
        .portal-alert.success  { background:rgba(0,209,91,.08); border:1px solid rgba(0,209,91,.2); }

    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar overlay (mobile) -->
<div id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar">
    <div class="sidebar-logo">
        <a href="/subscriber/dashboard">
            <img src="{{ asset('images/inspin-logo.png') }}?v=2" alt="INSPIN">
        </a>
    </div>

    <!-- User info -->
    @auth
    @php $sub = auth()->user()->activeSubscription()?->load('package'); @endphp
    <div class="sidebar-user">
        <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div>
            <div class="sidebar-user-name">{{ Str::limit(auth()->user()->name, 18) }}</div>
            <div class="sidebar-user-pkg">{{ $sub ? $sub->max_stars.'★ Access' : 'No Package' }}</div>
        </div>
    </div>

    @if($sub)
    <div class="sidebar-pkg-badge">
        <div class="pkg-label">Active Package</div>
        <div class="pkg-name">{{ $sub->packageName() }}</div>
        <div class="pkg-stars">{{ str_repeat('★', $sub->max_stars > 5 ? 5 : $sub->max_stars) }}{{ $sub->max_stars > 5 ? '+' : '' }}</div>
        <div class="pkg-exp">
            @if($sub->status_note === 'extended')
                Extended (unit-based)
            @elseif($sub->isExpired())
                Expired
            @else
                Expires {{ $sub->expires_at->format('M d, Y') }}
            @endif
        </div>
    </div>
    @endif
    @endauth

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu</div>

        <a href="/subscriber/dashboard" class="sidebar-link {{ request()->is('subscriber/dashboard') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <a href="/subscriber/picks" class="sidebar-link {{ request()->is('subscriber/picks*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><path d="M21 12c0 4.97-4.03 9-9 9S3 16.97 3 12 7.03 3 12 3s9 4.03 9 9z"/></svg>
            My Picks
        </a>

        <a href="/profile" class="sidebar-link {{ request()->is('profile') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            My Profile
        </a>

        <a href="/account/settings" class="sidebar-link {{ request()->is('account/settings') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            Settings
        </a>

        <div class="nav-section-label">Content</div>

        <a href="/subscriber/articles" class="sidebar-link {{ request()->is('subscriber/article*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Articles
        </a>

        <a href="/subscriber/consensus" class="sidebar-link {{ request()->is('subscriber/consensus*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Consensus
        </a>

        <a href="/subscriber/trends" class="sidebar-link {{ request()->is('subscriber/trends*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Trends
        </a>

        <a href="/subscriber/odds" class="sidebar-link {{ request()->is('subscriber/odds*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            Live Odds
        </a>

        <div class="nav-section-label">Account</div>

        @if($sub && $sub->max_stars < 10)
        <a href="/subscriber/packages" class="sidebar-link {{ request()->is('subscriber/packages') ? 'active' : '' }}" style="color:#FDB515;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            Upgrade Package
            <span class="badge">↑</span>
        </a>
        @endif

        <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="margin-top:4px;">
            @csrf
            <button type="button" onclick="confirmLogout()" class="sidebar-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Log Out
            </button>
        </form>

        {{-- Logout confirm modal --}}
        <div id="logoutModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(6px);">
            <div style="background:#1a1a1a;border:1px solid rgba(255,252,238,.1);border-radius:16px;padding:32px;max-width:340px;width:90%;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.7);">
                <div style="font-size:2.5rem;margin-bottom:14px;">👋</div>
                <h3 style="font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:500;color:#FFFCEE;margin-bottom:8px;">Log Out?</h3>
                <p style="font-size:13px;color:#6e6e6e;margin-bottom:24px;">You'll need to log back in to access your picks and dashboard.</p>
                <div style="display:flex;gap:10px;justify-content:center;">
                    <button onclick="document.getElementById('logoutModal').style.display='none'"
                        style="padding:10px 24px;background:#212121;border:1px solid rgba(255,252,238,.1);color:#9a9a9a;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:all .15s;"
                        onmouseover="this.style.borderColor='rgba(255,252,238,.25)';this.style.color='#FFFCEE'"
                        onmouseout="this.style.borderColor='rgba(255,252,238,.1)';this.style.color='#9a9a9a'">
                        Stay
                    </button>
                    <button onclick="document.getElementById('logoutForm').submit()"
                        style="padding:10px 24px;background:#ef4444;border:none;color:#fff;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:opacity .15s;"
                        onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </nav>

    @if($sub)
    <!-- Units mini in sidebar -->
    @php $u = (float)($sub->units_total ?? 0); @endphp
    <div class="sidebar-units">
        <div class="u-label">My Units</div>
        <div class="u-value" style="color:{{ $u >= 0 ? '#00D15B' : '#ef4444' }};">{{ $u >= 0 ? '+' : '' }}{{ number_format($u, 2) }}</div>
    </div>
    @endif

    <div class="sidebar-back">
        <a href="/">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Back to INSPIN.com
        </a>
    </div>
</aside>

<!-- Main -->
<div id="main">
    <header class="portal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <button id="menuToggle" onclick="toggleSidebar()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <h1>@yield('page-title', 'Member Portal')</h1>
        </div>
        <div style="display:flex;align-items:center;gap:16px;">
            <span style="font-size:12px;color:#6e6e6e;">{{ date('l, F j, Y') }}</span>
        </div>
    </header>

    <main class="portal-content">
        @yield('content')
    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('open');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('open');
}
function confirmLogout() {
    var m = document.getElementById('logoutModal');
    m.style.display = 'flex';
}
// Close modal on backdrop click
document.getElementById('logoutModal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@stack('scripts')
</body>
</html>

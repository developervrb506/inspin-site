<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - INSPIN')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --sidebar-w: 260px;
            --header-h: 64px;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --danger: #dc2626;
            --success: #16a34a;
            --warning: #d97706;
            --bg: #f1f5f9;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active: #fff;
            --card-bg: #fff;
            --border: #e2e8f0;
            --text: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
        a { color: var(--primary); text-decoration: none; }
        a:hover { color: var(--primary-hover); }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-w);
            background: var(--sidebar-bg); z-index: 100; overflow-y: auto;
            transition: transform 0.3s;
        }
        .sidebar-logo {
            padding: 20px 24px; border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-logo a { color: #fff; font-size: 1.4rem; font-weight: 900; letter-spacing: -0.5px; }
        .sidebar-logo a span { color: #fbbf24; }
        .sidebar-logo .badge-admin { background: var(--primary); color: #fff; font-size: 10px; padding: 2px 8px; border-radius: 10px; font-weight: 700; text-transform: uppercase; }
        .sidebar-nav { padding: 16px 0; }
        .sidebar-section { padding: 8px 24px 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #475569; margin-top: 8px; }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px; padding: 10px 24px;
            color: var(--sidebar-text); font-size: 14px; font-weight: 500;
            transition: all 0.15s; border-left: 3px solid transparent;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.05); color: #cbd5e1; }
        .sidebar-link.active { background: rgba(79,70,229,0.15); color: var(--sidebar-active); border-left-color: var(--primary); }
        .sidebar-link svg { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.7; }
        .sidebar-link.active svg { opacity: 1; }
        .sidebar-link .count { margin-left: auto; background: rgba(255,255,255,0.1); color: #94a3b8; font-size: 11px; padding: 2px 8px; border-radius: 10px; }

        /* Header */
        .header {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: var(--header-h);
            background: var(--card-bg); border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px; z-index: 90;
        }
        .header-left { display: flex; align-items: center; gap: 16px; }
        .header-left h1 { font-size: 1.25rem; font-weight: 700; color: var(--text); }
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); }
        .breadcrumb a { color: var(--text-muted); }
        .breadcrumb a:hover { color: var(--primary); }
        .breadcrumb .sep { color: var(--text-light); }
        .header-right { display: flex; align-items: center; gap: 16px; }
        .header-user { display: flex; align-items: center; gap: 10px; }
        .header-avatar {
            width: 36px; height: 36px; border-radius: 50%; background: var(--primary);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
        }
        .header-user-info { line-height: 1.3; }
        .header-user-name { font-size: 14px; font-weight: 600; color: var(--text); }
        .header-user-role { font-size: 12px; color: var(--text-muted); }
        .btn-logout {
            padding: 6px 14px; background: transparent; border: 1px solid var(--border);
            border-radius: 6px; color: var(--text-muted); font-size: 13px; cursor: pointer;
            transition: all 0.15s;
        }
        .btn-logout:hover { background: #fee2e2; color: var(--danger); border-color: #fecaca; }

        /* Main Content */
        .main { margin-left: var(--sidebar-w); margin-top: var(--header-h); padding: 32px; min-height: calc(100vh - var(--header-h)); }

        /* Stat Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px; }
        .stat-card {
            background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px;
            padding: 24px; display: flex; align-items: center; gap: 16px;
            transition: box-shadow 0.2s, transform 0.15s;
        }
        .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); transform: translateY(-1px); }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px; display: flex;
            align-items: center; justify-content: center; flex-shrink: 0;
        }
        .stat-icon svg { width: 24px; height: 24px; }
        .stat-icon.blue { background: #eff6ff; color: #2563eb; }
        .stat-icon.green { background: #f0fdf4; color: #16a34a; }
        .stat-icon.purple { background: #faf5ff; color: #9333ea; }
        .stat-icon.red { background: #fef2f2; color: #dc2626; }
        .stat-icon.amber { background: #fffbeb; color: #d97706; }
        .stat-icon.teal { background: #f0fdfa; color: #0d9488; }
        .stat-value { font-size: 1.75rem; font-weight: 800; color: var(--text); line-height: 1; }
        .stat-label { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

        /* Cards */
        .card {
            background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px;
            overflow: hidden; margin-bottom: 24px;
        }
        .card-header {
            padding: 20px 24px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h2 { font-size: 1.1rem; font-weight: 700; color: var(--text); }
        .card-body { padding: 24px; }
        .card-footer { padding: 16px 24px; border-top: 1px solid var(--border); background: #f8fafc; }

        /* Tables */
        .table-wrap { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th {
            background: #f8fafc; padding: 12px 16px; text-align: left;
            font-size: 12px; color: var(--text-muted); text-transform: uppercase;
            letter-spacing: 0.5px; font-weight: 700; border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }
        .table td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; vertical-align: middle; }
        .table tr:hover { background: #f8fafc; }
        .table tr:last-child td { border-bottom: none; }

        /* Badges */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-neutral { background: #f1f5f9; color: #475569; }
        .badge-primary { background: #e0e7ff; color: #3730a3; }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px;
            border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;
            border: none; transition: all 0.15s; text-decoration: none;
        }
        .btn svg { width: 16px; height: 16px; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-hover); color: #fff; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { background: #15803d; color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #b91c1c; color: #fff; }
        .btn-ghost { background: transparent; color: var(--text-muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: #f1f5f9; color: var(--text); }
        .btn-sm { padding: 5px 10px; font-size: 12px; }
        .btn-sm svg { width: 14px; height: 14px; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; color: var(--text); }
        .form-group .hint { font-size: 12px; color: var(--text-muted); margin-top: 4px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 10px 14px; background: #fff; border: 1.5px solid var(--border);
            border-radius: 8px; font-size: 14px; color: var(--text); transition: all 0.2s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(79,70,229,0.08);
        }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-actions { display: flex; gap: 10px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border); }

        /* Alerts */
        .alert { padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
        .alert svg { width: 20px; height: 20px; flex-shrink: 0; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .alert-info { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

        /* Search bar */
        .search-bar { display: flex; gap: 12px; margin-bottom: 24px; }
        .search-bar input { flex: 1; padding: 10px 16px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; }
        .search-bar input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(79,70,229,0.08); }

        /* Pagination */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 24px; }
        .pagination a, .pagination span { padding: 8px 14px; border-radius: 8px; font-size: 13px; }
        .pagination a { background: #fff; border: 1px solid var(--border); color: var(--text-muted); }
        .pagination a:hover { background: #f1f5f9; }
        .pagination .active { background: var(--primary); color: #fff; border-color: var(--primary); }

        /* Empty state */
        .empty-state { text-align: center; padding: 48px 24px; color: var(--text-muted); }
        .empty-state svg { width: 48px; height: 48px; margin-bottom: 16px; color: var(--text-light); }
        .empty-state h3 { font-size: 1.1rem; color: var(--text); margin-bottom: 8px; }

        /* Modal overlay */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 200; display: none; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.active { display: flex; }
        .modal-box { background: #fff; border-radius: 16px; padding: 32px; max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.15); text-align: center; animation: modalIn 0.2s ease-out; }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .modal-icon { width: 56px; height: 56px; border-radius: 50%; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .modal-icon svg { width: 28px; height: 28px; }
        .modal-box h3 { font-size: 1.25rem; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .modal-box p { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; }
        .modal-actions { display: flex; gap: 10px; justify-content: center; }
        .modal-actions .btn { min-width: 100px; justify-content: center; }

        /* Mobile toggle */
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; color: var(--text); }
        .sidebar-toggle svg { width: 24px; height: 24px; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .header { left: 0; }
            .main { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .form-row { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('dashboard') }}"><img src="{{ asset('images/inspin-logo.png') }}" alt="INSPIN" style="height:36px;width:auto;"></a>
            <span class="badge-admin">Admin</span>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section">Main</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                Dashboard
            </a>

            <div class="sidebar-section">Content</div>
            <a href="{{ route('admin.articles.index') }}" class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Exclusive Articles
                @if(isset($stats['articles']))<span class="count">{{ $stats['articles'] }}</span>@endif
            </a>
            <a href="{{ route('admin.picks.index') }}" class="sidebar-link {{ request()->routeIs('admin.picks.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                Picks
                @if(isset($stats['picks']))<span class="count">{{ $stats['picks'] }}</span>@endif
            </a>

            <div class="sidebar-section">Management</div>
            <a href="{{ route('tickets.index') }}" class="sidebar-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                Support Tickets
                @if(isset($stats['tickets']))<span class="count">{{ $stats['tickets'] }}</span>@endif
            </a>
            <a href="{{ route('contests.index') }}" class="sidebar-link {{ request()->routeIs('contests.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Contests
                @if(isset($stats['contests']))<span class="count">{{ $stats['contests'] }}</span>@endif
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </a>
            <a href="{{ route('admin.experts.index') }}" class="sidebar-link {{ request()->routeIs('admin.experts.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Experts
                @if(isset($stats['experts']))<span class="count">{{ $stats['experts'] }}</span>@endif
            </a>
            <a href="{{ route('admin.whale-packages.index') }}" class="sidebar-link {{ request()->routeIs('admin.whale-packages.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Whale Packages
            </a>

            <div class="sidebar-section">Settings</div>
            <a href="{{ route('account.settings') }}" class="sidebar-link {{ request()->routeIs('account.settings') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Settings
            </a>
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Public Site
            </a>
        </nav>
    </aside>

    <header class="header">
        <div class="header-left">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Admin</a>
                    @hasSection('breadcrumb')
                        <span class="sep">/</span>
                        @yield('breadcrumb')
                    @endif
                </div>
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
        </div>
        <div class="header-right">
            <div class="header-user">
                <div class="header-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="header-user-info">
                    <div class="header-user-name">{{ Auth::user()->name }}</div>
                    <div class="header-user-role">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</div>
                </div>
            </div>
            <button type="button" class="btn-logout" onclick="openLogoutModal()">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:14px;height:14px;margin-right:6px;vertical-align:-2px;"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </div>
    </header>

    <main class="main">
        @if (session('success'))
            <div class="alert alert-success">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.add('active');
        }
        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLogoutModal();
        });
    </script>

    <!-- Logout Confirmation Modal -->
    <div class="modal-overlay" id="logoutModal">
        <div class="modal-box">
            <div class="modal-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </div>
            <h3>Sign Out</h3>
            <p>Are you sure you want to sign out of your account? You'll need to sign in again to access the admin panel.</p>
            <div class="modal-actions">
                <button class="btn btn-ghost" onclick="closeLogoutModal()">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Yes, Sign Out</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

@extends('layouts.subscriber')
@section('title', 'Account Settings - INSPIN')
@section('page-title', 'Account Settings')

@section('content')
@php $isAdmin = false; @endphp

@if(session('success'))
<div style="background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.25);border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#00D15B;">
    ✓ {{ session('success') }}
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
    {{-- Profile form --}}
    <div class="{{ $isAdmin ? 'card' : 'stat-card' }}">
        @if($isAdmin)<div class="card-header"><h2>Profile Information</h2></div><div class="card-body">@else<div class="stat-label" style="margin-bottom:16px;">Profile Information</div>@endif
        <form method="POST" action="{{ route('account.settings.profile') }}">
            @csrf @method('PUT')
            <div style="display:flex;flex-direction:column;gap:14px;">
                <div>
                    <label style="font-size:12px;font-weight:600;color:{{ $isAdmin?'#374151':'#9a9a9a' }};display:block;margin-bottom:5px;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        style="width:100%;padding:10px 14px;background:{{ $isAdmin?'#fff':'#111' }};border:1px solid {{ $isAdmin?'#d1d5db':'rgba(255,252,238,.1)' }};border-radius:8px;font-size:14px;color:{{ $isAdmin?'#111':'#FFFCEE' }};outline:none;">
                    @error('name')<div style="color:#ef4444;font-size:12px;margin-top:3px;">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:{{ $isAdmin?'#374151':'#9a9a9a' }};display:block;margin-bottom:5px;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        style="width:100%;padding:10px 14px;background:{{ $isAdmin?'#fff':'#111' }};border:1px solid {{ $isAdmin?'#d1d5db':'rgba(255,252,238,.1)' }};border-radius:8px;font-size:14px;color:{{ $isAdmin?'#111':'#FFFCEE' }};outline:none;">
                    @error('email')<div style="color:#ef4444;font-size:12px;margin-top:3px;">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:{{ $isAdmin?'#374151':'#9a9a9a' }};display:block;margin-bottom:5px;">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Optional"
                        style="width:100%;padding:10px 14px;background:{{ $isAdmin?'#fff':'#111' }};border:1px solid {{ $isAdmin?'#d1d5db':'rgba(255,252,238,.1)' }};border-radius:8px;font-size:14px;color:{{ $isAdmin?'#111':'#FFFCEE' }};outline:none;">
                </div>
            </div>
            <div style="margin-top:18px;">
                <button type="submit" style="padding:10px 22px;background:#FDB515;color:#171818;border:none;border-radius:8px;font-weight:700;font-size:13px;cursor:pointer;">Save Profile</button>
            </div>
        </form>
        @if($isAdmin)</div>@endif
    </div>

    {{-- Password form --}}
    <div class="{{ $isAdmin ? 'card' : 'stat-card' }}">
        @if($isAdmin)<div class="card-header"><h2>Change Password</h2></div><div class="card-body">@else<div class="stat-label" style="margin-bottom:16px;">Change Password</div>@endif
        <form method="POST" action="{{ route('account.settings.password') }}">
            @csrf @method('PUT')
            <div style="display:flex;flex-direction:column;gap:14px;">
                <div>
                    <label style="font-size:12px;font-weight:600;color:{{ $isAdmin?'#374151':'#9a9a9a' }};display:block;margin-bottom:5px;">Current Password</label>
                    <input type="password" name="current_password" required placeholder="Enter current password"
                        style="width:100%;padding:10px 14px;background:{{ $isAdmin?'#fff':'#111' }};border:1px solid {{ $isAdmin?'#d1d5db':'rgba(255,252,238,.1)' }};border-radius:8px;font-size:14px;color:{{ $isAdmin?'#111':'#FFFCEE' }};outline:none;">
                    @error('current_password')<div style="color:#ef4444;font-size:12px;margin-top:3px;">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:{{ $isAdmin?'#374151':'#9a9a9a' }};display:block;margin-bottom:5px;">New Password</label>
                    <input type="password" name="password" required minlength="8" placeholder="Minimum 8 characters"
                        style="width:100%;padding:10px 14px;background:{{ $isAdmin?'#fff':'#111' }};border:1px solid {{ $isAdmin?'#d1d5db':'rgba(255,252,238,.1)' }};border-radius:8px;font-size:14px;color:{{ $isAdmin?'#111':'#FFFCEE' }};outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:{{ $isAdmin?'#374151':'#9a9a9a' }};display:block;margin-bottom:5px;">Confirm New Password</label>
                    <input type="password" name="password_confirmation" required minlength="8" placeholder="Re-enter new password"
                        style="width:100%;padding:10px 14px;background:{{ $isAdmin?'#fff':'#111' }};border:1px solid {{ $isAdmin?'#d1d5db':'rgba(255,252,238,.1)' }};border-radius:8px;font-size:14px;color:{{ $isAdmin?'#111':'#FFFCEE' }};outline:none;">
                </div>
            </div>
            <div style="margin-top:18px;">
                <button type="submit" style="padding:10px 22px;background:#171818;border:1px solid rgba(255,252,238,.2);color:#FFFCEE;border-radius:8px;font-weight:700;font-size:13px;cursor:pointer;">Update Password</button>
            </div>
        </form>
        @if($isAdmin)</div>@endif
    </div>
</div>

{{-- Account info strip --}}
<div class="{{ $isAdmin ? 'card' : 'stat-card' }}">
    @if($isAdmin)<div class="card-header"><h2>Account Details</h2></div><div class="card-body">@else<div class="stat-label" style="margin-bottom:16px;">Account Details</div>@endif
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;">
        @foreach(['Member Since'=>$user->created_at?->format('M d, Y'),'Last Updated'=>$user->updated_at?->format('M d, Y'),'User ID'=>'#'.$user->id,'Status'=>'Active'] as $label=>$val)
        <div style="padding:14px;background:rgba(255,252,238,.03);border:1px solid rgba(255,252,238,.06);border-radius:8px;">
            <div style="font-size:10px;color:#6e6e6e;text-transform:uppercase;letter-spacing:.5px;font-weight:700;margin-bottom:4px;">{{ $label }}</div>
            <div style="font-size:13px;font-weight:600;color:{{ $label==='Status'?'#00D15B':'#FFFCEE' }};">{{ $val }}</div>
        </div>
        @endforeach
    </div>
    @if($isAdmin)</div>@endif
</div>
@endsection

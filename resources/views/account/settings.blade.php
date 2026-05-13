@extends('layouts.subscriber')
@section('title','Account Settings - INSPIN')
@section('page-title','Account Settings')

@push('styles')
<style>
.s-label { font-size:12px; font-weight:600; color:rgba(255,255,255,.5); display:block; margin-bottom:5px; }
.s-input { width:100%; padding:10px 14px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1); border-radius:10px; font-size:13px; color:#fff; font-family:'Inter',sans-serif; outline:none; transition:border-color .2s; }
.s-input::placeholder { color:rgba(255,255,255,.2); }
.s-input:focus { border-color:rgba(253,181,21,.4); }
.s-input:disabled { opacity:.4; cursor:not-allowed; }
.s-btn-gold { padding:10px 22px; background:var(--gold); color:#000; border:none; border-radius:10px; font-weight:700; font-size:13px; cursor:pointer; font-family:'Inter',sans-serif; transition:opacity .15s; }
.s-btn-gold:hover { opacity:.85; }
.s-btn-dark { padding:10px 22px; background:rgba(255,255,255,.07); color:#fff; border:1px solid rgba(255,255,255,.12); border-radius:10px; font-weight:700; font-size:13px; cursor:pointer; font-family:'Inter',sans-serif; transition:background .15s; }
.s-btn-dark:hover { background:rgba(255,255,255,.12); }
</style>
@endpush

@section('content')
@if(session('success'))
<div style="background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.25);border-radius:10px;padding:12px 16px;margin-bottom:14px;font-size:13px;color:#00D15B;">✓ {{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
    {{-- Profile form --}}
    <div class="s-card" style="padding:20px;">
        <h3 style="font-size:14px;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:18px;">Profile Information</h3>
        <form method="POST" action="{{ route('account.settings.profile') }}">
            @csrf @method('PUT')
            <div style="display:flex;flex-direction:column;gap:14px;">
                <div><label class="s-label">Full Name</label><input type="text" name="name" value="{{ old('name',$user->name) }}" class="s-input" required>@error('name')<div style="color:#ef4444;font-size:11px;margin-top:3px;">{{ $message }}</div>@enderror</div>
                <div><label class="s-label">Email Address</label><input type="email" name="email" value="{{ old('email',$user->email) }}" class="s-input" required>@error('email')<div style="color:#ef4444;font-size:11px;margin-top:3px;">{{ $message }}</div>@enderror</div>
                <div><label class="s-label">Phone Number</label><input type="text" name="phone" value="{{ old('phone',$user->phone) }}" class="s-input" placeholder="Optional"></div>
            </div>
            <div style="margin-top:18px;"><button type="submit" class="s-btn-gold">Save Profile</button></div>
        </form>
    </div>

    {{-- Password form --}}
    <div class="s-card" style="padding:20px;">
        <h3 style="font-size:14px;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:18px;">Change Password</h3>
        <form method="POST" action="{{ route('account.settings.password') }}">
            @csrf @method('PUT')
            <div style="display:flex;flex-direction:column;gap:14px;">
                <div><label class="s-label">Current Password</label><input type="password" name="current_password" class="s-input" required placeholder="Enter current password">@error('current_password')<div style="color:#ef4444;font-size:11px;margin-top:3px;">{{ $message }}</div>@enderror</div>
                <div><label class="s-label">New Password</label><input type="password" name="password" class="s-input" required minlength="8" placeholder="Minimum 8 characters"></div>
                <div><label class="s-label">Confirm New Password</label><input type="password" name="password_confirmation" class="s-input" required minlength="8" placeholder="Re-enter new password"></div>
            </div>
            <div style="margin-top:18px;"><button type="submit" class="s-btn-dark">Update Password</button></div>
        </form>
    </div>
</div>

{{-- Account details strip --}}
<div class="s-card" style="padding:18px 20px;">
    <h3 style="font-size:13px;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px;">Account Details</h3>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;">
        @foreach(['Member Since'=>$user->created_at?->format('M d, Y'),'Last Updated'=>$user->updated_at?->format('M d, Y'),'User ID'=>'#'.$user->id,'Status'=>'Active'] as $label=>$val)
        <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:12px;">
            <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:rgba(255,255,255,.3);margin-bottom:5px;">{{ $label }}</div>
            <div style="font-size:13px;font-weight:600;color:{{ $label==='Status'?'#00D15B':'#fff' }};">{{ $val }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection

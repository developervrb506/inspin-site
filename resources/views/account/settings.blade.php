@extends('admin.layouts.admin')

@section('title', 'Settings - INSPIN Admin')
@section('page-title', 'Account Settings')
@section('breadcrumb')
    <span>Settings</span>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    <div class="card">
        <div class="card-header">
            <h2>Profile Information</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('account.settings.profile') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Optional">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <input type="text" value="{{ ucfirst($user->role ?? 'free') }}" disabled style="background:#f8fafc;color:#64748b;">
                    <div class="hint">Contact an admin to change your role</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                        Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Change Password</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('account.settings.password') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required placeholder="Enter current password">
                    @error('current_password')
                        <div style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required minlength="8" placeholder="Minimum 8 characters">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="Re-enter new password">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card" style="margin-top:24px;">
    <div class="card-header">
        <h2>Account Details</h2>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;">
            <div style="padding:16px;background:#f8fafc;border-radius:8px;">
                <div style="font-size:12px;color:#64748b;text-transform:uppercase;font-weight:700;margin-bottom:4px;">Member Since</div>
                <div style="font-weight:600;">{{ $user->created_at?->format('M d, Y') ?? 'N/A' }}</div>
            </div>
            <div style="padding:16px;background:#f8fafc;border-radius:8px;">
                <div style="font-size:12px;color:#64748b;text-transform:uppercase;font-weight:700;margin-bottom:4px;">Last Updated</div>
                <div style="font-weight:600;">{{ $user->updated_at?->format('M d, Y') ?? 'N/A' }}</div>
            </div>
            <div style="padding:16px;background:#f8fafc;border-radius:8px;">
                <div style="font-size:12px;color:#64748b;text-transform:uppercase;font-weight:700;margin-bottom:4px;">User ID</div>
                <div style="font-weight:600;">#{{ $user->id }}</div>
            </div>
            <div style="padding:16px;background:#f8fafc;border-radius:8px;">
                <div style="font-size:12px;color:#64748b;text-transform:uppercase;font-weight:700;margin-bottom:4px;">Account Status</div>
                <span class="badge badge-success">Active</span>
            </div>
        </div>
    </div>
</div>
@endsection

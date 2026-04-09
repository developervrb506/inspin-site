@extends('admin.layouts.admin')

@section('title', 'Edit User - INSPIN Admin')
@section('page-title', 'Edit User')
@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}">Users</a>
    <span class="sep">/</span>
    <span>Edit: {{ $user->name }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit User: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Users
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;padding:16px;background:#f8fafc;border-radius:10px;">
                <div style="width:48px;height:48px;border-radius:50%;background:#4f46e5;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:20px;">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <div style="font-weight:700;font-size:16px;">{{ $user->name }}</div>
                    <div style="color:#64748b;font-size:14px;">{{ $user->email }}</div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="role">Role *</label>
                    <select id="role" name="role" required>
                        @foreach (['free', 'member', 'vip', 'admin'] as $role)
                            <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="hint">Controls access to premium content</div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Optional">
                </div>
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" minlength="8" placeholder="Leave blank to keep current password">
                <div class="hint">Minimum 8 characters. Leave blank to keep the current password.</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                    Update User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

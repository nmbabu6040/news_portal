@extends('admin.layout')

@section('title', 'নতুন ইউজার - অ্যাডমিন প্যানেল')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold">নতুন ইউজার যোগ করুন</h3>
    </div>

    <div class="card p-4 shadow-sm" style="max-width: 600px;">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">নাম</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">ইমেইল</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">রোল (Role)</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">পাসওয়ার্ড</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> সেভ করুন</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">ফিরে যান</a>
        </form>
    </div>
@endsection

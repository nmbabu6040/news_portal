@extends('admin.layout')

@section('title', 'ইউজার এডিট - অ্যাডমিন প্যানেল')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold">ইউজার এডিট: {{ $user->name }}</h3>
    </div>

    <div class="card p-4 shadow-sm" style="max-width: 600px;">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">নাম</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">ইমেইল</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">রোল (Role)</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required
                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if ($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <small class="text-muted">নিজের রোল পরিবর্তন করতে পারবেন না।</small>
                @endif
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">নতুন পাসওয়ার্ড (ঐচ্ছিক)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="পাসওয়ার্ড পরিবর্তন না করতে চাইলে খালি রাখুন">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-repeat"></i> আপডেট করুন</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">ফিরে যান</a>
        </form>
    </div>
@endsection

@extends('admin.layout')
@section('content')
    <h3 class="mb-4"><i class="bi bi-gear"></i> সাইট সেটিংস</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>এই সমস্যাগুলোর জন্য সেভ হয়নি:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card p-4 mb-3">
            <h5 class="mb-3">সাধারণ তথ্য</h5>
            <div class="mb-3">
                <label class="form-label">সাইটের নাম</label>
                <input type="text" name="site_name" class="form-control"
                    value="{{ old('site_name', $settings->site_name) }}" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">হেডার লোগো</label>
                    @if ($settings->header_logo_url)
                        <div class="mb-2"><img src="{{ $settings->header_logo_url }}" style="height:50px;"
                                class="border rounded p-1"></div>
                    @endif
                    <input type="file" name="header_logo" class="form-control" accept="image/*">
                    <small class="text-muted">খালি রাখলে টেক্সট লোগো (সাইটের নাম) দেখাবে।</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">ফুটার লোগো</label>
                    @if ($settings->footer_logo_url)
                        <div class="mb-2"><img src="{{ $settings->footer_logo_url }}" style="height:50px;"
                                class="border rounded p-1 bg-dark"></div>
                    @endif
                    <input type="file" name="footer_logo" class="form-control" accept="image/*">
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h5 class="mb-3">আমাদের সম্পর্কে</h5>
            <textarea name="about_text" class="form-control" rows="4"
                placeholder="সাইট সম্পর্কে সংক্ষিপ্ত বিবরণ (ফুটারে দেখাবে)">{{ old('about_text', $settings->about_text) }}</textarea>
        </div>

        <div class="card p-4 mb-3">
            <h5 class="mb-3">যোগাযোগের তথ্য</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">ঠিকানা</label>
                    <input type="text" name="address" class="form-control"
                        value="{{ old('address', $settings->address) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">ফোন</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings->phone) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">ইমেইল</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email) }}">
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h5 class="mb-3">সোশ্যাল মিডিয়া লিংক</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-facebook"></i> Facebook URL</label>
                    <input type="url" name="facebook_url" class="form-control"
                        value="{{ old('facebook_url', $settings->facebook_url) }}" placeholder="https://facebook.com/...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-twitter-x"></i> Twitter/X URL</label>
                    <input type="url" name="twitter_url" class="form-control"
                        value="{{ old('twitter_url', $settings->twitter_url) }}" placeholder="https://x.com/...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-youtube"></i> YouTube URL</label>
                    <input type="url" name="youtube_url" class="form-control"
                        value="{{ old('youtube_url', $settings->youtube_url) }}" placeholder="https://youtube.com/...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-instagram"></i> Instagram URL</label>
                    <input type="url" name="instagram_url" class="form-control"
                        value="{{ old('instagram_url', $settings->instagram_url) }}"
                        placeholder="https://instagram.com/...">
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h5 class="mb-3">ফুটার কপিরাইট টেক্সট</h5>
            <textarea name="footer_text" class="form-control" rows="2"
                placeholder="© 2026 নিউজ পোর্টাল। সর্বস্বত্ব সংরক্ষিত।">{{ old('footer_text', $settings->footer_text) }}</textarea>
        </div>

        <button type="submit" class="btn btn-danger px-4">সংরক্ষণ করুন</button>
    </form>
@endsection

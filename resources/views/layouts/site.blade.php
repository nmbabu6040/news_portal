<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'নিউজ পোর্টাল')</title>
    <meta name="description" content="@yield('meta_description', 'বাংলাদেশ ও বিশ্বের সর্বশেষ সংবাদ')">
    @hasSection('meta_image')
        <meta property="og:image" content="@yield('meta_image')">
    @endif
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="{{ route('feed') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans Bengali', sans-serif; background:#f5f5f5; }
        .navbar-brand { font-weight:700; font-size:1.6rem; color:#c00 !important; }
        .breaking-bar { background:#c00; color:#fff; padding:.4rem 0; font-size:.9rem; }
        .article-card img { height:180px; object-fit:cover; }
        .category-badge { font-size:.75rem; }
        a { text-decoration:none; }
        footer { background:#1a1a1a; color:#ccc; padding:2rem 0; margin-top:3rem; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="breaking-bar">
        <div class="container d-flex align-items-center overflow-hidden">
            <span class="fw-bold me-2 text-nowrap">সর্বশেষ:</span>
            <div class="text-nowrap">
                @forelse($tickerHeadlines ?? [] as $slug => $title)
                    <a href="{{ route('article.show', $slug) }}" class="text-white me-4">{{ $title }}</a>
                @empty
                    সাইট আপডেট হচ্ছে প্রতি মুহূর্তে
                @endforelse
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">নিউজ পোর্টাল</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="navMenu">
                <div class="offcanvas-header">
                    <h5>মেনু</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    @include('partials.nav-links')
                </div>
            </div>
            <div class="collapse navbar-collapse d-none d-lg-flex">
                @include('partials.nav-links')
            </div>
            <form action="{{ route('search') }}" method="GET" class="d-flex ms-auto">
                <input class="form-control form-control-sm" type="search" name="q" placeholder="খুঁজুন...">
            </form>
        </div>
    </nav>

    <main class="container my-4">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>

    <footer>
        <div class="container text-center">
            <p class="mb-2">নিউজলেটার সাবস্ক্রাইব করুন</p>
            <form action="{{ route('subscribe') }}" method="POST" class="d-flex justify-content-center gap-2 mb-3">
                @csrf
                <input type="email" name="email" class="form-control" style="max-width:250px;" placeholder="আপনার ইমেইল" required>
                <button class="btn btn-danger">সাবস্ক্রাইব</button>
            </form>
            <p class="mb-1">© {{ date('Y') }} নিউজ পোর্টাল। সর্বস্বত্ব সংরক্ষিত।</p>
            <small>Laravel + Bootstrap দিয়ে তৈরি</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
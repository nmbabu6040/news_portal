<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $settings->site_name)</title>
    <meta name="description" content="@yield('meta_description', $settings->about_text ?: 'বাংলাদেশ ও বিশ্বের সর্বশেষ সংবাদ')">
    @hasSection('meta_image')
        <meta property="og:image" content="@yield('meta_image')">
    @endif
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="{{ route('feed') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background: #f5f5f5;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: #c00 !important;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .navbar-brand img {
            height: 40px;
        }

        .breaking-bar {
            background: #c00;
            color: #fff;
            padding: .4rem 0;
            font-size: .9rem;
        }

        .article-card img {
            height: 180px;
            object-fit: cover;
        }

        .category-badge {
            font-size: .75rem;
        }

        a {
            text-decoration: none;
        }

        footer {
            background: #fff;
            color: #000;
            padding: 2.5rem 0 1rem;
            margin-top: 3rem;
        }

        footer h6 {
            color: #000;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        footer a {
            color: #010101;
        }

        footer a:hover {
            color: #c00;
        }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: #fff;
            border-radius: 50%;
            margin-right: .5rem;
            font-size: 1.1rem;
        }

        .footer-social a:hover {
            background: #c00;
            color: #fff;
        }

        .footer-logo {
            height: 45px;
            margin-bottom: 1rem;
        }
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
            <a class="navbar-brand" href="{{ route('home') }}">
                @if ($settings->header_logo_url)
                    <img src="{{ $settings->header_logo_url }}" alt="{{ $settings->site_name }}">
                @else
                    {{ $settings->site_name }}
                @endif
            </a>
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
        <div class="container">
            <div class="row mb-4">
                {{-- লোগো + About --}}
                <div class="col-md-4 mb-4">
                    @if ($settings->footer_logo_url)
                        <img src="{{ $settings->footer_logo_url }}" alt="{{ $settings->site_name }}"
                            class="footer-logo">
                    @else
                        <h5 class="text-white">{{ $settings->site_name }}</h5>
                    @endif
                    @if ($settings->about_text)
                        <p class="small">{{ $settings->about_text }}</p>
                    @endif
                    @if ($settings->facebook_url || $settings->twitter_url || $settings->youtube_url || $settings->instagram_url)
                        <div class="footer-social mt-3">
                            @if ($settings->facebook_url)
                                <a href="{{ $settings->facebook_url }}" target="_blank"><i
                                        class="bi bi-facebook"></i></a>
                            @endif
                            @if ($settings->twitter_url)
                                <a href="{{ $settings->twitter_url }}" target="_blank"><i
                                        class="bi bi-twitter-x"></i></a>
                            @endif
                            @if ($settings->youtube_url)
                                <a href="{{ $settings->youtube_url }}" target="_blank"><i
                                        class="bi bi-youtube"></i></a>
                            @endif
                            @if ($settings->instagram_url)
                                <a href="{{ $settings->instagram_url }}" target="_blank"><i
                                        class="bi bi-instagram"></i></a>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- দ্রুত লিংক --}}
                <div class="col-md-4 mb-4">
                    <h6>দ্রুত লিংক</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('epaper') }}">ই-পেপার</a></li>
                        <li class="mb-2"><a href="{{ route('feed') }}">RSS ফিড</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}">সার্চ</a></li>
                    </ul>
                </div>

                {{-- যোগাযোগ --}}
                <div class="col-md-4 mb-4">
                    <h6>যোগাযোগ</h6>
                    <ul class="list-unstyled small">
                        @if ($settings->address)
                            <li class="mb-2"><i class="bi bi-geo-alt me-1"></i> {{ $settings->address }}</li>
                        @endif
                        @if ($settings->phone)
                            <li class="mb-2"><i class="bi bi-telephone me-1"></i> {{ $settings->phone }}</li>
                        @endif
                        @if ($settings->email)
                            <li class="mb-2"><i class="bi bi-envelope me-1"></i> {{ $settings->email }}</li>
                        @endif
                    </ul>
                </div>
            </div>

            <hr class="border-secondary">

            <div class="text-center">
                <p class="mb-2">নিউজলেটার সাবস্ক্রাইব করুন</p>
                <form action="{{ route('subscribe') }}" method="POST"
                    class="d-flex justify-content-center gap-2 mb-3">
                    @csrf
                    <input type="email" name="email" class="form-control" style="max-width:250px;"
                        placeholder="আপনার ইমেইল" required>
                    <button class="btn btn-danger">সাবস্ক্রাইব</button>
                </form>
                <p class="mb-1 small">
                    {{ $settings->footer_text ?: '© ' . date('Y') . ' ' . $settings->site_name . '। সর্বস্বত্ব সংরক্ষিত।' }}
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>

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

    {{-- <link rel="icon" href="https://www.prothomalo.com/default.svg" type="image/svg+xml"> --}}

    <!-- Site Icon / Favicon Dynamic Link -->
    @if ($setting && $setting->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $setting->favicon) }}">
        <link rel="shortcut icon" href="{{ asset('storage/' . $setting->favicon) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $setting->favicon) }}">
    @else
        <!-- ডিফল্ট আইকন (যদি ডাটাবেজে না থাকে) -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="{{ route('feed') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background: #f8f9fa;
            color: #212529;
        }

        /* Top Header Bar */
        .top-bar {
            background-color: #2b2b2b;
            color: #d1d1d1;
            font-size: 0.85rem;
            padding: 4px 0;
            border-bottom: 1px solid #3d3d3d;
        }

        .top-bar a {
            color: #d1d1d1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .top-bar a:hover {
            color: #fff;
        }

        /* Main Navbar */
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: #c00 !important;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .navbar-brand img {
            height: 42px;
        }

        /* Breaking News Ticker */
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

        a {
            text-decoration: none;
        }

        /* Footer Styles */
        footer {
            background: #1a1a1a;
            color: #a0a0a0;
            padding: 3rem 0 1rem;
            margin-top: 3rem;
            border-top: 4px solid #c00;
        }

        footer h6 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 1.2rem;
            position: relative;
            padding-bottom: 8px;
        }

        footer h6::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 35px;
            height: 2px;
            background-color: #c00;
        }

        footer p {
            color: #b0b0b0;
        }

        footer a {
            color: #b0b0b0;
            transition: color 0.2s ease;
        }

        footer a:hover {
            color: #ffffff;
        }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: #2b2b2b;
            color: #fff;
            border-radius: 50%;
            margin-right: .5rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background: #c00;
            color: #fff;
            transform: translateY(-3px);
        }

        .footer-logo {
            /* height: 45px; */
            width: 200px;
            margin-bottom: 1rem;
            /* filter: brightness(0) invert(1); */
        }

        .tag-cloud a {
            display: inline-block;
            background: #2b2b2b;
            padding: 3px 8px;
            font-size: 0.8rem;
            border-radius: 3px;
            margin-bottom: 5px;
        }

        .tag-cloud a:hover {
            background: #c00;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- ১. টপ বার (তারিখ, সময় ও কুইক মেনু) -->
    <div class="top-bar d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-calendar3 me-1"></i> {{ date('l, d F Y') }}
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('epaper') }}"><i class="bi bi-journal-text me-1"></i> ই-পেপার</a>
                <a href="#"><i class="bi bi-phone me-1"></i> মোবাইল অ্যাপস</a>
                <a href="#"><i class="bi bi-archive me-1"></i> আর্কাইভ</a>
            </div>
        </div>
    </div>

    <!-- ২. মেইন নেভিগেশন বার -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if ($settings->header_logo_url)
                    <img src="{{ $settings->header_logo_url }}" alt="{{ $settings->site_name }}" class=""
                        style="width: 140px; height: 80px; overflow: hidden;">
                @else
                    {{ $settings->site_name }}
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="navMenu">
                <div class="offcanvas-header">
                    <h5 class="fw-bold">{{ $settings->site_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    @include('partials.nav-links')
                </div>
            </div>

            <div class="collapse navbar-collapse d-none d-lg-flex">
                @include('partials.nav-links')
            </div>

            <!-- হেডার সার্চ ও ইউজার বাটন -->
            <div class="d-flex align-items-center ms-auto gap-2">
                <form action="{{ route('search') }}" method="GET" class="d-flex">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="search" name="q" placeholder="খুঁজুন..." required>
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                @auth
                    {{-- User jodi Admin hoy tobe Admin Dashboard --}}
                    @if (auth()->user()->isAdmin())
                        {{-- Apnar User model-er attribute অনুযায়ী (যেমন: role == 'admin') --}}
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-danger"
                            title="Admin Dashboard">
                            <i class="bi bi-speedometer2"></i>
                        </a>
                    @else
                        {{-- Sadharon User hole Profile Page --}}
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-danger" title="My Profile">
                            <i class="bi bi-person-circle"></i>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-danger text-nowrap">
                        <i class="bi bi-box-arrow-in-right"></i> সাইন ইন
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ৩. ব্রেকিং নিউজ স্ক্রলার -->
    <div class="breaking-bar">
        <div class="container d-flex align-items-center overflow-hidden">
            <span class="fw-bold me-2 text-nowrap badge bg-black"><i
                    class="bi bi-lightning-charge-fill me-1"></i>সর্বশেষ:</span>
            <div class="text-nowrap overflow-hidden">
                @forelse($tickerHeadlines ?? [] as $slug => $title)
                    <a href="{{ route('article.show', $slug) }}" class="text-white me-4"><i class="bi bi-dot"></i>
                        {{ $title }}</a>
                @empty
                    <span>সাইট আপডেট হচ্ছে প্রতি মুহূর্তে...</span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- মূল কনটেন্ট সেকশন -->
    <main class="container my-4">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- ৪. অ্যাডভান্সড ফুটার সেকশন -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-4">

                <!-- কলাম ১: লোগো, তথ্য ও সোশ্যাল লিংক -->
                <div class="col-lg-4 col-md-6">
                    @if ($settings->footer_logo_url)
                        <img src="{{ $settings->footer_logo_url }}" alt="{{ $settings->site_name }}"
                            class="footer-logo">
                    @else
                        <h4 class="text-white fw-bold mb-3">{{ $settings->site_name }}</h4>
                    @endif

                    <p class="small mb-3">
                        {{ $settings->about_text ?: 'সত্য ও বস্তুনিষ্ঠ সংবাদের নির্ভরযোগ্য মাধ্যম। ২৪ ঘণ্টা আপডেটসহ দেশ-বিদেশের সব খবর পড়ুন।' }}
                    </p>

                    <!-- সম্পাদকীয় তথ্য -->
                    <div class="small mb-3">
                        <div><strong>সম্পাদক ও প্রকাশক:</strong> {{ $settings->editor_name ?? 'সম্পাদক নাম' }}</div>
                        <div><strong>রেজিস্ট্রেশন নং:</strong> {{ $settings->reg_no ?? '১২৩৪/২০২৪' }}</div>
                    </div>

                    @if ($settings->facebook_url || $settings->twitter_url || $settings->youtube_url || $settings->instagram_url)
                        <div class="footer-social">
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

                <!-- কলাম ২: দ্রুত লিংক ও লিগ্যাল పేজ -->
                <div class="col-lg-2 col-md-6">
                    <h6>প্রয়োজনীয় লিংক</h6>
                    <ul class="list-unstyled small lh-lg">
                        <li><a href="{{ route('epaper') }}">ই-পেপার</a></li>
                        <li><a href="{{ route('feed') }}">RSS ফিড</a></li>
                        <li><a href="{{ route('page.show', 'about-us') }}">আমাদের সম্পর্কে</a></li>
                        <li><a href="{{ route('page.show', 'terms-and-conditions') }}">ব্যবহারের শর্তাবলী</a></li>
                        <li><a href="{{ route('page.show', 'advertisement') }}">বিজ্ঞাপন</a></li>
                        <li><a href="{{ route('page.show', 'circulation') }}">সার্কুলেশন</a></li>
                        <li><a href="{{ route('page.show', 'contact') }}">যোগাযোগ</a></li>
                    </ul>
                </div>


                <!-- কলাম ৩: ট্রেন্ডিং ট্যাগস / ক্যাটাগরি -->
                <div class="col-lg-3 col-md-6">
                    <h6>জনপ্রিয় বিষয়</h6>
                    <div class="tag-cloud">
                        @forelse($footerCategories ?? [] as $category)
                            <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                        @empty
                            <span class="text-muted small">কোনো ক্যাটাগরি পাওয়া যায়নি</span>
                        @endforelse
                    </div>
                </div>

                <!-- কলাম ৪: যোগাযোগ ও নিউজলেটার -->
                <div class="col-lg-3 col-md-6">
                    <h6>যোগাযোগ</h6>
                    <ul class="list-unstyled small mb-3">
                        @if ($settings->address)
                            <li class="mb-2"><i class="bi bi-geo-alt me-2 text-danger"></i>
                                {{ $settings->address }}</li>
                        @endif
                        @if ($settings->phone)
                            <li class="mb-2"><i class="bi bi-telephone me-2 text-danger"></i>
                                {{ $settings->phone }}</li>
                        @endif
                        @if ($settings->email)
                            <li class="mb-2"><i class="bi bi-envelope me-2 text-danger"></i> {{ $settings->email }}
                            </li>
                        @endif
                    </ul>

                    <h6 class="mt-4">নিউজলেটার</h6>
                    <form action="{{ route('subscribe') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input type="email" name="email" class="form-control" placeholder="আপনার ইমেইল"
                                required>
                            <button class="btn btn-danger" type="submit">যুক্ত হোন</button>
                        </div>
                    </form>
                </div>

            </div>

            <hr class="border-secondary my-3">

            <!-- ফুটারের নিচের অংশ -->
            <div class="row align-items-center small ">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    {{ $settings->footer_text ?: '© ' . date('Y') . ' ' . $settings->site_name . '। সর্বস্বত্ব সংরক্ষিত।' }}
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span>ডেলিভারড বাই <strong>{{ $settings->site_name }}</strong></span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>

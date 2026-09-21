<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'অ্যাডমিন প্যানেল')</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="https://www.prothomalo.com/default.svg">
    <style>
        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background: #f0f2f5;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            width: 230px;
        }

        .sidebar a {
            color: #b8c1ec;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .6rem .9rem;
            border-radius: .5rem;
            margin-bottom: .2rem;
            transition: all .15s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        .sidebar .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.2rem;
            padding: .5rem .9rem 1.2rem;
        }

        .stat-card {
            border: none;
            border-radius: .8rem;
            color: #fff;
            overflow: hidden;
            position: relative;
        }

        .stat-card .bi {
            font-size: 2.2rem;
            opacity: .35;
            position: absolute;
            right: 1rem;
            top: 1rem;
        }

        .stat-card h3 {
            font-weight: 700;
        }

        .bg-c1 {
            background: linear-gradient(135deg, #c00, #7a0000);
        }

        .bg-c2 {
            background: linear-gradient(135deg, #198754, #0c4128);
        }

        .bg-c3 {
            background: linear-gradient(135deg, #6f42c1, #3d2466);
        }

        .bg-c4 {
            background: linear-gradient(135deg, #0d6efd, #043b8f);
        }

        .bg-c5 {
            background: linear-gradient(135deg, #fd7e14, #a3540a);
        }

        .bg-c6 {
            background: linear-gradient(135deg, #20c997, #0e6e56);
        }

        .card {
            border: none;
            border-radius: .8rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        }

        .table {
            border-radius: .5rem;
            overflow: hidden;
        }

        .progress {
            height: .6rem;
            border-radius: .5rem;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="d-flex">
        <div class="sidebar text-white p-3">
            <div class="brand"><i class="bi bi-newspaper me-2"></i>নিউজ পোর্টাল</div>
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i>
                ড্যাশবোর্ড</a>
            <a href="{{ route('admin.articles.index') }}"
                class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"><i class="bi bi-file-text"></i>
                আর্টিকেল</a>
            <a href="{{ route('admin.pages.index') }}"
                class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"><i
                    class="bi bi-file-earmark-text"></i> পেজসমূহ
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="bi bi-grid"></i>
                ক্যাটাগরি</a>
            <a href="{{ route('admin.tags.index') }}"
                class="{{ request()->routeIs('admin.tags.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> ট্যাগ</a>
            <a href="{{ route('admin.comments.index') }}"
                class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}"><i class="bi bi-chat-dots"></i>
                মন্তব্য</a>
            <a href="{{ route('admin.epapers.index') }}"
                class="{{ request()->routeIs('admin.epapers.*') ? 'active' : '' }}"><i class="bi bi-file-pdf"></i>
                ই-পেপার</a>
            <a href="{{ route('admin.subscribers.index') }}"
                class="{{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}"><i class="bi bi-envelope"></i>
                সাবস্ক্রাইবার</a>
            <a href="{{ route('admin.settings.edit') }}"
                class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="bi bi-gear"></i>
                সেটিংস</a>
            <hr class="text-white-50">
            <a href="{{ route('home') }}"><i class="bi bi-globe"></i> সাইট দেখুন</a>
        </div>
        <div class="flex-fill p-4">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'অ্যাডমিন প্যানেল')</title>

    <!-- Admin Panel Favicon -->
    @if (isset($setting) && $setting->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $setting->favicon) }}">
        <link rel="shortcut icon" href="{{ asset('storage/' . $setting->favicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background: #f0f2f5;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            width: 240px;
        }

        .sidebar a {
            color: #b8c1ec;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .55rem .9rem;
            border-radius: .5rem;
            margin-bottom: .2rem;
            transition: all .15s;
            font-size: 0.92rem;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        .sidebar .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.15rem;
            padding: .5rem .9rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.8rem;
        }

        .sidebar-heading {
            font-size: 0.72rem;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 700;
            margin-top: 0.8rem;
            margin-bottom: 0.3rem;
            padding-left: 0.9rem;
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

        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            width: 240px;
            flex-shrink: 0;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar text-white p-3">
            <div class="brand"><i class="bi bi-newspaper me-2"></i>নিউজ পোর্টাল</div>

            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
            </a>

            <div class="sidebar-heading">সংবাদ ও কনটেন্ট</div>
            <a href="{{ route('admin.articles.index') }}"
                class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i> আর্টিকেল
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> ক্যাটাগরি
            </a>
            <a href="{{ route('admin.tags.index') }}" class="{{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> ট্যাগ
            </a>

            <div class="sidebar-heading">মিডিয়া ও পেজ</div>
            <a href="{{ route('admin.epapers.index') }}"
                class="{{ request()->routeIs('admin.epapers.*') ? 'active' : '' }}">
                <i class="bi bi-file-pdf"></i> ই-পেপার
            </a>
            <a href="{{ route('admin.pages.index') }}"
                class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> পেজসমূহ
            </a>

            <div class="sidebar-heading">পাঠক ইন্টারঅ্যাকশন</div>
            <a href="{{ route('admin.comments.index') }}"
                class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i> মন্তব্য
            </a>
            <a href="{{ route('admin.subscribers.index') }}"
                class="{{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> সাবস্ক্রাইবার
            </a>

            <div class="sidebar-heading">সিস্টেম</div>
            <a href="{{ route('admin.settings.edit') }}"
                class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> সেটিংস
            </a>

            <div class="sidebar-heading">ইউজার ও পারমিশন</div>
            <a href="{{ route('admin.users.index') }}"
                class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> ইউজার লিস্ট
            </a>

            <hr class="text-white-50 my-3">

            <a href="{{ route('home') }}" target="_blank"><i class="bi bi-globe"></i> সাইট দেখুন</a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-100 text-start border-0 bg-transparent py-2 px-3 text-danger fw-semibold"
                    style="font-size: 0.92rem;">
                    <i class="bi bi-box-arrow-right"></i> লগআউট
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="flex-fill p-4">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>

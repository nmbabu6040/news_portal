<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'অ্যাডমিন প্যানেল')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{font-family:sans-serif;background:#f0f2f5;}
        .sidebar{min-height:100vh;background:#1a1a1a;}
        .sidebar a:hover{color:#fff !important;}
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar text-white p-3" style="width:220px;">
        <h5 class="mb-4">অ্যাডমিন প্যানেল</h5>
        <a href="{{ route('admin.dashboard') }}" class="d-block text-white mb-2">ড্যাশবোর্ড</a>
        <a href="{{ route('admin.articles.index') }}" class="d-block text-white mb-2">আর্টিকেল</a>
        <a href="{{ route('admin.categories.index') }}" class="d-block text-white mb-2">ক্যাটাগরি</a>
        <a href="{{ route('admin.tags.index') }}" class="d-block text-white mb-2">ট্যাগ</a>
        <a href="{{ route('admin.comments.index') }}" class="d-block text-white mb-2">মন্তব্য</a>
        <a href="{{ route('admin.epapers.index') }}" class="d-block text-white mb-2">ই-পেপার</a>
        <a href="{{ route('admin.subscribers.index') }}" class="d-block text-white mb-2">সাবস্ক্রাইবার</a>
        <a href="{{ route('home') }}" class="d-block text-white-50 mb-2">সাইট দেখুন</a>
    </div>
    <div class="flex-fill p-4">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@extends('admin.layout')
@section('content')
    <h3 class="mb-4"><i class="bi bi-graph-up"></i> অ্যানালিটিক্স</h3>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-c4 p-3">
                <i class="bi bi-eye"></i>
                <small>মোট ভিউ</small>
                <h3 class="mb-0">{{ number_format($totals['views']) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-c1 p-3">
                <i class="bi bi-heart-fill"></i>
                <small>মোট লাইক</small>
                <h3 class="mb-0">{{ number_format($totals['likes']) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-c3 p-3">
                <i class="bi bi-chat-dots"></i>
                <small>মোট মন্তব্য</small>
                <h3 class="mb-0">{{ number_format($totals['comments']) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-c6 p-3">
                <i class="bi bi-share-fill"></i>
                <small>মোট শেয়ার</small>
                <h3 class="mb-0">{{ number_format($totals['shares']) }}</h3>
            </div>
        </div>
    </div>

    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">আর্টিকেল-ভিত্তিক পারফরম্যান্স</h6>
            <div class="btn-group btn-group-sm">
                <a href="?sort=views_count"
                    class="btn btn-outline-secondary {{ $sort === 'views_count' ? 'active' : '' }}">ভিউ</a>
                <a href="?sort=likes_count"
                    class="btn btn-outline-secondary {{ $sort === 'likes_count' ? 'active' : '' }}">লাইক</a>
                <a href="?sort=comments_count"
                    class="btn btn-outline-secondary {{ $sort === 'comments_count' ? 'active' : '' }}">মন্তব্য</a>
                <a href="?sort=shares_count"
                    class="btn btn-outline-secondary {{ $sort === 'shares_count' ? 'active' : '' }}">শেয়ার</a>
            </div>
        </div>
        <table class="table table-sm align-middle">
            <thead>
                <tr>
                    <th>শিরোনাম</th>
                    <th>ক্যাটাগরি</th>
                    <th class="text-center"><i class="bi bi-eye"></i> ভিউ</th>
                    <th class="text-center"><i class="bi bi-heart-fill text-danger"></i> লাইক</th>
                    <th class="text-center"><i class="bi bi-chat-dots"></i> মন্তব্য</th>
                    <th class="text-center"><i class="bi bi-share-fill"></i> শেয়ার</th>
                    <th class="text-center">এনগেজমেন্ট</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    @php
                        $engagement = $article->likes_count + $article->comments_count + $article->shares_count;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('article.show', $article->slug) }}" target="_blank" class="text-dark">
                                {{ \Illuminate\Support\Str::limit($article->title, 40) }}
                            </a>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $article->category->name }}</span></td>
                        <td class="text-center">{{ number_format($article->views_count) }}</td>
                        <td class="text-center">{{ number_format($article->likes_count) }}</td>
                        <td class="text-center">{{ number_format($article->comments_count) }}</td>
                        <td class="text-center">{{ number_format($article->shares_count) }}</td>
                        <td class="text-center"><span class="badge bg-danger">{{ number_format($engagement) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $articles->links() }}
    </div>
@endsection

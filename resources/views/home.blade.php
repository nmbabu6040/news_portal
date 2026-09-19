@extends('layouts.site')

@section('content')
    @if($featured)
    <div class="row mb-4">
        <div class="col-lg-8">
            <a href="{{ route('article.show', $featured->slug) }}" class="text-decoration-none text-dark">
                <img src="{{ $featured->thumbnail ? asset('storage/'.$featured->thumbnail) : 'https://via.placeholder.com/800x400' }} → {{ $featured->thumbnail_url ?: 'https://picsum.photos/800/400' }}" class="img-fluid rounded mb-2" alt="">
                <span class="badge bg-danger category-badge">{{ $featured->category->name }}</span>
                <h2 class="mt-2">{{ $featured->title }}</h2>
                <p class="text-muted">{{ $featured->excerpt }}</p>
            </a>
        </div>
        <div class="col-lg-4">
            <h5 class="border-bottom pb-2">সর্বাধিক পঠিত</h5>
            @foreach($mostRead as $i => $item)
                <a href="{{ route('article.show', $item->slug) }}" class="d-flex mb-3 text-dark">
                    <span class="fw-bold fs-4 text-danger me-2">{{ $i+1 }}</span>
                    <span>{{ $item->title }}</span>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <h4 class="border-bottom pb-2 mb-3">সর্বশেষ</h4>
    <div class="row">
        @foreach($latest as $article)
        <div class="col-md-3 mb-4">
            <div class="card article-card h-100">
                <img src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : 'https://via.placeholder.com/300x180' }} → {{ $article->thumbnail_url ?: 'https://picsum.photos/300/180' }}" class="card-img-top" alt="">
                <div class="card-body">
                    <span class="badge bg-secondary category-badge">{{ $article->category->name }}</span>
                    <h6 class="mt-2"><a href="{{ route('article.show', $article->slug) }}" class="text-dark">{{ $article->title }}</a></h6>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @foreach($categories as $category)
        @if($category->articles->count())
        <div class="mt-4">
            <h4 class="border-bottom pb-2 mb-3">
                <a href="{{ route('category.show', $category->slug) }}" class="text-dark">{{ $category->name }}</a>
            </h4>
            <div class="row">
                @foreach($category->articles as $article)
                <div class="col-md-3 mb-3">
                    <a href="{{ route('article.show', $article->slug) }}" class="text-dark">
                        <img src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : 'https://via.placeholder.com/300x160' }} → {{ $article->thumbnail_url ?: 'https://picsum.photos/300/160' }}" class="img-fluid rounded mb-1" alt="">
                        <div>{{ $article->title }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
@endsection

@extends('layouts.site')

@section('title', $user->name)

@section('content')
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width:60px;height:60px;font-size:1.5rem;">
            {{ mb_substr($user->name, 0, 1) }}
        </div>
        <div class="ms-3">
            <h4 class="mb-0">{{ $user->name }}</h4>
            <small class="text-muted">প্রতিবেদক</small>
        </div>
    </div>

    <h5 class="border-bottom pb-2 mb-3">{{ $user->name }}-এর প্রতিবেদন সমূহ</h5>
    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card article-card h-100">
                <img src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : 'https://via.placeholder.com/300x180' }} → {{ $article->thumbnail_url ?: 'https://picsum.photos/300/180' }}" class="card-img-top" alt="">
                <div class="card-body">
                    <h6><a href="{{ route('article.show', $article->slug) }}" class="text-dark">{{ $article->title }}</a></h6>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $articles->links() }}
@endsection

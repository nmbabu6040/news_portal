@extends('layouts.site')

@section('content')
    <h3 class="mb-4">{{ $category->name }}</h3>
    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card article-card h-100">
                <img src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : 'https://via.placeholder.com/300x180' }} → {{ $article->thumbnail_url ?: 'https://picsum.photos/300/180' }}" class="card-img-top" alt="">
                <div class="card-body">
                    <h6><a href="{{ route('article.show', $article->slug) }}" class="text-dark">{{ $article->title }}</a></h6>
                    <p class="text-muted small">{{ $article->excerpt }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $articles->links() }}
@endsection

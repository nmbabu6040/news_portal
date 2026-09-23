@extends('layouts.site')

@section('content')
    @include('partials.breadcrumb', ['items' => [['label' => 'সার্চ রেজাল্ট']]])
    <h4 class="mb-4">"{{ $query }}" এর জন্য {{ $articles->total() }} টি রেজাল্ট</h4>
    <div class="row">
        @foreach ($articles as $article)
            <div class="col-md-4 mb-4">
                <div class="card article-card h-100">
                    <div class="card-body">
                        <h6><a href="{{ route('article.show', $article->slug) }}" class="text-dark">{{ $article->title }}</a>
                        </h6>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $articles->links() }}
@endsection

@extends('layouts.site')

@section('content')
    <h3 class="mb-4">{{ $category->name }}</h3>
    <div class="row">
        @foreach ($articles as $article)
            <div class="col-md-4 mb-4">
                <div class="card article-card h-100">
                    {{-- Thumbnail Logic Fix --}}
                    @php
                        if ($article->thumbnail) {
                            // যদি thumbnail Base64/SVG হয় বা সরাসরি http/https দিয়ে শুরু হয়
                            if (Str::startsWith($article->thumbnail, ['data:', 'http://', 'https://'])) {
                                $src = $article->thumbnail;
                            } else {
                                // যদি storage এ আপলোড করা ফাইল পাথ হয়
                                $src = asset('storage/' . $article->thumbnail);
                            }
                        } elseif (isset($article->thumbnail_url) && $article->thumbnail_url) {
                            $src = $article->thumbnail_url;
                        } else {
                            // কোনো থাম্বনেইল না থাকলে ডিফল্ট প্লেসহোল্ডার
                            $src = 'https://picsum.photos/300/180';
                        }
                    @endphp

                    <img src="{{ $src }}" class="card-img-top" alt="{{ $article->title }}">

                    <div class="card-body">
                        <h6>
                            <a href="{{ route('article.show', $article->slug) }}" class="text-dark">
                                {{ $article->title }}
                            </a>
                        </h6>
                        <p class="text-muted small">{{ $article->excerpt }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $articles->links() }}
@endsection

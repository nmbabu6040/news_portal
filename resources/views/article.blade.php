@extends('layouts.site')

@section('title', $article->title)
@section('meta_description', $article->excerpt)
@section('meta_image', $article->thumbnail ? asset('storage/'.$article->thumbnail) : '') → @section('meta_image', $article->thumbnail_url ?: '')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <span class="badge bg-danger">{{ $article->category->name }}</span>
            <h1 class="mt-2">{{ $article->title }}</h1>
            <p class="text-muted">
                @if($article->author)
                    <a href="{{ route('author.show', $article->author) }}" class="text-muted">{{ $article->author->name }}</a>
                @else
                    প্রতিবেদক
                @endif
                | {{ $article->published_at?->format('d M Y, h:i A') }}
                | দেখা হয়েছে {{ $article->views_count }} বার
            </p>
            @if($article->thumbnail && $article->type === 'article')
                <img src="{{ asset('storage/'.$article->thumbnail) }} → {{ $article->thumbnail_url }}" class="img-fluid rounded mb-3" alt="">
            @endif

            @if($article->type === 'video' && $article->video_url)
                <div class="ratio ratio-16x9 mb-3">
                    <iframe src="{{ $article->video_url }}" allowfullscreen></iframe>
                </div>
            @endif

            <div class="fs-5">{!! nl2br(e($article->content)) !!}</div>

            @if($article->type === 'gallery' && $article->photos->count())
                <div class="row mt-3">
                    @foreach($article->photos as $photo)
                        <div class="col-md-4 mb-3">
                            <img src="{{ asset('storage/'.$photo->image_path) }} → {{ $photo->image_url }}" class="img-fluid rounded">
                            @if($photo->caption)
                                <small class="text-muted">{{ $photo->caption }}</small>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            @if($article->tags->count())
            <div class="mt-3">
                @foreach($article->tags as $tag)
                    <span class="badge bg-light text-dark border">#{{ $tag->name }}</span>
                @endforeach
            </div>
            @endif

            <hr class="mt-4">

            {{-- Approved comments --}}
            @php $approved = $article->comments->where('is_approved', true); @endphp
            <h5 class="mb-3">মন্তব্য ({{ $approved->count() }})</h5>
            @forelse($approved as $comment)
                <div class="border-bottom pb-2 mb-2">
                    <strong>{{ $comment->name }}</strong>
                    <small class="text-muted">— {{ $comment->created_at->diffForHumans() }}</small>
                    <p class="mb-0">{{ $comment->body }}</p>
                </div>
            @empty
                <p class="text-muted">এখনো কোনো মন্তব্য নেই।</p>
            @endforelse

            {{-- Comment form --}}
            <h6 class="mt-4 mb-2">মন্তব্য করুন</h6>
            <form action="{{ route('comment.store', $article) }}" method="POST">
                @csrf
                <div class="row g-2 mb-2">
                    <div class="col-md-6"><input name="name" class="form-control" placeholder="আপনার নাম" required></div>
                    <div class="col-md-6"><input type="email" name="email" class="form-control" placeholder="ইমেইল" required></div>
                </div>
                <textarea name="body" class="form-control mb-2" rows="3" placeholder="আপনার মন্তব্য লিখুন" required></textarea>
                <button class="btn btn-danger">মন্তব্য পাঠান</button>
            </form>
        </div>
        <div class="col-lg-4">
            <h5 class="border-bottom pb-2">সম্পর্কিত খবর</h5>
            @foreach($related as $item)
                <a href="{{ route('article.show', $item->slug) }}" class="d-block mb-3 text-dark">{{ $item->title }}</a>
            @endforeach
        </div>
    </div>
@endsection

@extends('admin.layout')

@section('content')
    <h3 class="mb-4">ড্যাশবোর্ড</h3>

    {{-- মূল স্ট্যাটস কার্ড --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c1 p-3">
                <i class="bi bi-file-text"></i>
                <small>মোট আর্টিকেল</small>
                <h3 class="mb-0">{{ $stats['total_articles'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c2 p-3">
                <i class="bi bi-check-circle"></i>
                <small>প্রকাশিত</small>
                <h3 class="mb-0">{{ $stats['published'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c5 p-3">
                <i class="bi bi-pencil"></i>
                <small>ড্রাফট</small>
                <h3 class="mb-0">{{ $stats['drafts'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c4 p-3">
                <i class="bi bi-eye"></i>
                <small>মোট ভিউ</small>
                <h3 class="mb-0">{{ number_format($stats['total_views']) }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c3 p-3">
                <i class="bi bi-chat-dots"></i>
                <small>অপেক্ষমান মন্তব্য</small>
                <h3 class="mb-0">{{ $stats['pending_comments'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c6 p-3">
                <i class="bi bi-envelope"></i>
                <small>সাবস্ক্রাইবার</small>
                <h3 class="mb-0">{{ $stats['subscribers'] }}</h3>
            </div>
        </div>
    </div>

    {{-- সেকেন্ডারি স্ট্যাটস --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <i class="bi bi-grid fs-3 text-danger"></i>
                <small class="text-muted d-block mt-1">ক্যাটাগরি</small>
                <strong class="fs-5">{{ $stats['categories'] }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <i class="bi bi-tags fs-3 text-success"></i>
                <small class="text-muted d-block mt-1">ট্যাগ</small>
                <strong class="fs-5">{{ $stats['tags'] }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <i class="bi bi-images fs-3 text-primary"></i>
                <small class="text-muted d-block mt-1">গ্যালারি আর্টিকেল</small>
                <strong class="fs-5">{{ $stats['gallery_count'] }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <i class="bi bi-play-circle fs-3 text-warning"></i>
                <small class="text-muted d-block mt-1">ভিডিও আর্টিকেল</small>
                <strong class="fs-5">{{ $stats['video_count'] }}</strong>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- ক্যাটাগরি-ভিত্তিক আর্টিকেল বার চার্ট --}}
        <div class="col-lg-6">
            <div class="card p-3 h-100">
                <h6 class="mb-3"><i class="bi bi-bar-chart"></i> ক্যাটাগরি-ভিত্তিক আর্টিকেল</h6>
                @foreach ($categoryStats as $cat)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between small">
                            <span>{{ $cat->name }}</span>
                            <span class="text-muted">{{ $cat->articles_count }}</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger"
                                style="width: {{ ($cat->articles_count / $maxCategoryCount) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- সর্বাধিক পঠিত --}}
        <div class="col-lg-6">
            <div class="card p-3 h-100">
                <h6 class="mb-3"><i class="bi bi-fire"></i> সর্বাধিক পঠিত আর্টিকেল</h6>
                @foreach ($topArticles as $i => $article)
                    <div class="d-flex align-items-center mb-2 pb-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <span class="badge bg-danger rounded-circle me-2"
                            style="width:1.6rem;height:1.6rem;">{{ $i + 1 }}</span>
                        <div class="flex-fill">
                            <a href="{{ route('article.show', $article->slug) }}" target="_blank"
                                class="text-dark small">{{ Str::limit($article->title, 45) }}</a>
                        </div>
                        <span class="text-muted small"><i class="bi bi-eye"></i>
                            {{ number_format($article->views_count) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- সাম্প্রতিক আর্টিকেল --}}
        <div class="col-lg-7">
            <div class="card p-3">
                <h6 class="mb-3"><i class="bi bi-clock-history"></i> সাম্প্রতিক আর্টিকেল</h6>
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>শিরোনাম</th>
                            <th>ক্যাটাগরি</th>
                            <th>স্ট্যাটাস</th>
                            <th>তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentArticles as $a)
                            <tr>
                                <td>{{ Str::limit($a->title, 35) }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $a->category->name }}</span></td>
                                <td>
                                    @if ($a->status === 'published')
                                        <span class="badge bg-success">প্রকাশিত</span>
                                    @else
                                        <span class="badge bg-secondary">ড্রাফট</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $a->created_at->format('d M') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- অপেক্ষমান মন্তব্য --}}
        <div class="col-lg-5">
            <div class="card p-3">
                <h6 class="mb-3"><i class="bi bi-exclamation-circle text-danger"></i> অপেক্ষমান মন্তব্য</h6>
                @forelse($recentComments as $comment)
                    <div class="mb-2 pb-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <strong class="small">{{ $comment->name }}</strong>
                        <p class="small text-muted mb-0">{{ Str::limit($comment->body, 50) }}</p>
                    </div>
                @empty
                    <p class="text-muted small mb-0">কোনো অপেক্ষমান মন্তব্য নেই।</p>
                @endforelse
                @if ($stats['pending_comments'] > 0)
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-outline-danger mt-2 w-100">সব
                        দেখুন</a>
                @endif
            </div>
        </div>
    </div>
@endsection

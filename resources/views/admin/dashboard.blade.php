@extends('admin.layout')

@section('title', 'ড্যাশবোর্ড - অ্যাডমিন প্যানেল')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0 fw-bold">ড্যাশবোর্ড</h3>
        <span class="text-muted small"><i class="bi bi-clock"></i> আজকের তারিখ: {{ date('d M, Y') }}</span>
    </div>

    {{-- মূল স্ট্যাটস কার্ড --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c1 p-3">
                <i class="bi bi-file-text"></i>
                <small>মোট আর্টিকেল</small>
                <h3 class="mb-0">{{ number_format($stats['total_articles']) }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c2 p-3">
                <i class="bi bi-check-circle"></i>
                <small>প্রকাশিত</small>
                <h3 class="mb-0">{{ number_format($stats['published']) }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c5 p-3">
                <i class="bi bi-pencil"></i>
                <small>ড্রাফট</small>
                <h3 class="mb-0">{{ number_format($stats['drafts']) }}</h3>
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
                <h3 class="mb-0">{{ number_format($stats['pending_comments']) }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card bg-c6 p-3">
                <i class="bi bi-envelope"></i>
                <small>সাবস্ক্রাইবার</small>
                <h3 class="mb-0">{{ number_format($stats['subscribers']) }}</h3>
            </div>
        </div>
    </div>

    {{-- সেকেন্ডারি স্ট্যাটস --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center border-0 shadow-sm">
                <i class="bi bi-grid fs-3 text-danger"></i>
                <small class="text-muted d-block mt-1">ক্যাটাগরি</small>
                <strong class="fs-5">{{ $stats['categories'] }}</strong>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center border-0 shadow-sm">
                <i class="bi bi-tags fs-3 text-success"></i>
                <small class="text-muted d-block mt-1">ট্যাগ</small>
                <strong class="fs-5">{{ $stats['tags'] }}</strong>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center border-0 shadow-sm">
                <i class="bi bi-images fs-3 text-primary"></i>
                <small class="text-muted d-block mt-1">গ্যালারি খবর</small>
                <strong class="fs-5">{{ $stats['gallery_count'] }}</strong>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center border-0 shadow-sm">
                <i class="bi bi-play-circle fs-3 text-warning"></i>
                <small class="text-muted d-block mt-1">ভিডিও খবর</small>
                <strong class="fs-5">{{ $stats['video_count'] }}</strong>
            </div>
        </div>
    </div>

    {{-- ডাটা চার্ট ও শীর্ষ আর্টিকেল --}}
    <div class="row g-3 mb-4">
        <!-- ক্যাটাগরি-ভিত্তিক আর্টিকেল বার চার্ট -->
        <div class="col-lg-6">
            <div class="card p-3 h-100 shadow-sm">
                <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart text-danger me-1"></i> ক্যাটাগরি-ভিত্তিক আর্টিকেল</h6>
                @forelse ($categoryStats as $cat)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>{{ $cat->name }}</span>
                            <span class="text-muted fw-semibold">{{ $cat->articles_count }} টি</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger"
                                style="width: {{ ($cat->articles_count / $maxCategoryCount) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small my-auto text-center">কোনো ক্যাটাগরি তথ্য নেই</p>
                @endforelse
            </div>
        </div>

        <!-- সর্বাধিক পঠিত খবর -->
        <div class="col-lg-6">
            <div class="card p-3 h-100 shadow-sm">
                <h6 class="fw-bold mb-3"><i class="bi bi-fire text-danger me-1"></i> সর্বাধিক পঠিত আর্টিকেল</h6>
                @forelse ($topArticles as $i => $article)
                    <div class="d-flex align-items-center mb-2 pb-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <span class="badge bg-danger rounded-circle me-2 d-flex align-items-center justify-content-center"
                            style="width:1.6rem;height:1.6rem;">{{ $i + 1 }}</span>
                        <div class="flex-fill text-truncate">
                            <a href="{{ route('article.show', $article->slug) }}" target="_blank"
                                class="text-dark text-decoration-none small fw-semibold">{{ Str::limit($article->title, 50) }}</a>
                        </div>
                        <span class="text-muted small ms-2"><i class="bi bi-eye"></i>
                            {{ number_format($article->views_count) }}</span>
                    </div>
                @empty
                    <p class="text-muted small my-auto text-center">কোনো পঠিত খবর পাওয়া যায়নি</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- সাম্প্রতিক খবর ও মন্তব্য --}}
    <div class="row g-3">
        <!-- সাম্প্রতিক আর্টিকেল -->
        <div class="col-lg-7">
            <div class="card p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold m-0"><i class="bi bi-clock-history text-primary me-1"></i> সাম্প্রতিক আর্টিকেল</h6>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-link text-decoration-none">সব দেখুন
                        <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr class="table-light">
                                <th>শিরোনাম</th>
                                <th>ক্যাটাগরি</th>
                                <th>স্ট্যাটাস</th>
                                <th>তারিখ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentArticles as $a)
                                <tr>
                                    <td><span class="d-inline-block text-truncate"
                                            style="max-width: 180px;">{{ $a->title }}</span></td>
                                    <td><span
                                            class="badge bg-light text-dark border">{{ $a->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if ($a->status === 'published')
                                            <span class="badge bg-success">প্রকাশিত</span>
                                        @else
                                            <span class="badge bg-secondary">ড্রাফট</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $a->created_at->format('d M') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">কোনো সাম্প্রতিক সংবাদ নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- অপেক্ষমান মন্তব্য -->
        <div class="col-lg-5">
            <div class="card p-3 shadow-sm">
                <h6 class="fw-bold mb-3"><i class="bi bi-exclamation-circle text-danger me-1"></i> অপেক্ষমান মন্তব্য</h6>
                @forelse($recentComments as $comment)
                    <div class="mb-2 pb-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <strong class="small d-block">{{ $comment->name }}</strong>
                        <p class="small text-muted mb-0 text-truncate">{{ Str::limit($comment->body, 50) }}</p>
                    </div>
                @empty
                    <p class="text-muted small mb-0 py-2">কোনো অপেক্ষমান মন্তব্য নেই।</p>
                @endforelse

                @if ($stats['pending_comments'] > 0)
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-outline-danger mt-3 w-100">
                        সবগুলো দেখুন ({{ $stats['pending_comments'] }})
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection

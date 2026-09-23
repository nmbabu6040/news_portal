@extends('layouts.site')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-danger"><i class="bi bi-bar-chart-line-fill"></i> রিপোর্ট এবং অ্যানালিটিক্স</h3>

            {{-- ডাউনলোড বাটনসমূহ --}}
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-download"></i> রিপোর্ট ডাউনলোড করুন
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <h6 class="dropdown-header">PDF ফরম্যাট</h6>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports.export.pdf', $filter) }}"><i
                                class="bi bi-file-earmark-pdf text-danger"></i> PDF রিপোর্ট ডাউনলোড</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <h6 class="dropdown-header">Excel / CSV</h6>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports.export.excel', [$filter, 'xlsx']) }}"><i
                                class="bi bi-file-earmark-excel text-success"></i> Excel (.xlsx) ডাউনলোড</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports.export.excel', [$filter, 'csv']) }}"><i
                                class="bi bi-file-earmark-text text-primary"></i> CSV (.csv) ডাউনলোড</a></li>
                </ul>
            </div>
        </div>

        {{-- ফিল্টার ফিল্ডস --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body bg-light rounded">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label class="fw-bold">রিপোর্ট নির্বাচন করুন:</label>
                    </div>
                    <div class="col-auto">
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>দৈনিক (Today)</option>
                            <option value="weekly" {{ $filter == 'weekly' ? 'selected' : '' }}>সাপ্তাহিক (This Week)
                            </option>
                            <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>মাসিক (This Month)</option>
                            <option value="yearly" {{ $filter == 'yearly' ? 'selected' : '' }}>বাৎসরিক (This Year)</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        {{-- ডাটা টেবিল প্রিভিউ --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-danger text-white">
                            <tr>
                                <th>#ID</th>
                                <th>শিরোনাম</th>
                                <th>ক্যাটাগরি</th>
                                <th>ভিউ</th>
                                <th>তারিখ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($articles as $article)
                                <tr>
                                    <td>{{ $article->id }}</td>
                                    <td class="fw-semibold">{{ Str::limit($article->title, 60) }}</td>
                                    <td><span class="badge bg-secondary">{{ $article->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td><span class="badge bg-danger">{{ $article->views ?? 0 }}</span></td>
                                    <td>{{ $article->created_at->format('d M, Y - h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">কোন তথ্য পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $articles->appends(['filter' => $filter])->links() }}
        </div>
    </div>
@endsection

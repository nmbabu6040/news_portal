@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>পেজ তালিকা</h4>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> নতুন পেজ যুক্ত
                করুন</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>শিরোনাম</th>
                            <th>Slug</th>
                            <th>স্ট্যাটাস</th>
                            <th>অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $page->title }}</strong></td>
                                <td><code>/page/{{ $page->slug }}</code></td>
                                <td>
                                    @if ($page->is_active)
                                        <span class="badge bg-success">সক্রিয়</span>
                                    @else
                                        <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                                        class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.pages.edit', $page->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('আপনি কি এটি মুছে ফেলতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">কোনো পেজ পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">
            {{ $pages->links() }}
        </div>
    </div>
@endsection

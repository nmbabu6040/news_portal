@extends('admin.layout')
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>আর্টিকেল সমূহ</h3>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-danger">+ নতুন আর্টিকেল</a>
    </div>
    <table class="table bg-white">
        <thead>
            <tr>
                <th>ক্রম</th>
                <th>শিরোনাম</th>
                <th>ক্যাটাগরি</th>
                <th>স্ট্যাটাস</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr>
                    <td>{{ $articles->firstItem() + $loop->index }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->category->name }}</td>
                    <td><span
                            class="badge bg-{{ $article->status === 'published' ? 'success' : 'secondary' }}">{{ $article->status }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-outline-primary">এডিট</a>
                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $articles->links() }}
@endsection

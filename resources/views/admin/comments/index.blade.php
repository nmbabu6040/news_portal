@extends('admin.layout')
@section('content')
<h3 class="mb-4">মন্তব্য মডারেশন</h3>
<table class="table bg-white">
    <thead><tr><th>আর্টিকেল</th><th>নাম</th><th>মন্তব্য</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
    @foreach($comments as $comment)
        <tr>
            <td><a href="{{ route('article.show', $comment->article->slug) }}" target="_blank">{{ Str::limit($comment->article->title, 30) }}</a></td>
            <td>{{ $comment->name }}<br><small class="text-muted">{{ $comment->email }}</small></td>
            <td>{{ Str::limit($comment->body, 60) }}</td>
            <td>
                @if($comment->is_approved)
                    <span class="badge bg-success">অনুমোদিত</span>
                @else
                    <span class="badge bg-secondary">অপেক্ষমান</span>
                @endif
            </td>
            <td>
                @unless($comment->is_approved)
                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-outline-success">অনুমোদন</button>
                </form>
                @endunless
                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $comments->links() }}
@endsection

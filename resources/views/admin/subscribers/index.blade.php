@extends('admin.layout')
@section('content')
<h3 class="mb-4">নিউজলেটার সাবস্ক্রাইবার</h3>
<table class="table bg-white">
    <thead><tr><th>ইমেইল</th><th>সাবস্ক্রাইবের তারিখ</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
    @foreach($subscribers as $sub)
        <tr>
            <td>{{ $sub->email }}</td>
            <td>{{ $sub->created_at->format('d M Y') }}</td>
            <td>
                <form action="{{ route('admin.subscribers.destroy', $sub) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $subscribers->links() }}
@endsection

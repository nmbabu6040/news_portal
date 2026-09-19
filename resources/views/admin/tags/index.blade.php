@extends('admin.layout')
@section('content')
<h3 class="mb-4">ট্যাগ সমূহ</h3>
<form action="{{ route('admin.tags.store') }}" method="POST" class="row g-2 mb-4">
    @csrf
    <div class="col-md-4"><input name="name" class="form-control" placeholder="নতুন ট্যাগের নাম" required></div>
    <div class="col-md-2"><button class="btn btn-danger w-100">যুক্ত করুন</button></div>
</form>
<table class="table bg-white">
    <thead><tr><th>নাম</th><th>আর্টিকেল সংখ্যা</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
    @foreach($tags as $tag)
        <tr>
            <td>{{ $tag->name }}</td>
            <td>{{ $tag->articles_count }}</td>
            <td>
                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection

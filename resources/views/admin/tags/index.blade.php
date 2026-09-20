@extends('admin.layout')
@section('content')
    <h3 class="mb-4">ট্যাগ সমূহ</h3>
    <form action="{{ route('admin.tags.store') }}" method="POST" class="row g-2 mb-4">
        @csrf
        <div class="col-md-4"><input name="name" class="form-control" placeholder="নতুন ট্যাগের নাম" required></div>
        <div class="col-md-2"><button class="btn btn-danger w-100">যুক্ত করুন</button></div>
    </form>
    <table class="table bg-white">
        <thead>
            <tr>
                <th>ক্রম</th>
                <th>নাম</th>
                <th>আর্টিকেল সংখ্যা</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td>{{ $tags->firstItem() + $loop->index }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->articles_count }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#editTagModal{{ $tag->id }}">এডিট</button>
                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                        </form>
                    </td>
                </tr>

                {{-- এডিট মোডাল --}}
                <div class="modal fade" id="editTagModal{{ $tag->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">ট্যাগ এডিট করুন</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">ট্যাগের নাম</label>
                                    <input type="text" name="name" class="form-control" value="{{ $tag->name }}"
                                        required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                                    <button type="submit" class="btn btn-danger">সংরক্ষণ করুন</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    {{ $tags->links() }}
@endsection

@extends('admin.layout')
@section('content')
    <h3 class="mb-4">ক্যাটাগরি সমূহ</h3>
    <form action="{{ route('admin.categories.store') }}" method="POST" class="row g-2 mb-4">
        @csrf
        <div class="col-md-4"><input name="name" class="form-control" placeholder="ক্যাটাগরির নাম" required></div>
        <div class="col-md-4"><input name="description" class="form-control" placeholder="বিবরণ (ঐচ্ছিক)"></div>
        <div class="col-md-2"><button class="btn btn-danger w-100">যুক্ত করুন</button></div>
    </form>
    <table class="table bg-white">
        <thead>
            <tr>
                <th>#</th>
                <th>নাম</th>
                <th>আর্টিকেল সংখ্যা</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $cat)
                <tr>
                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->articles_count }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#editCatModal{{ $cat->id }}">এডিট</button>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                        </form>
                    </td>
                </tr>

                {{-- এডিট মোডাল --}}
                <div class="modal fade" id="editCatModal{{ $cat->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.categories.update', $cat) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">ক্যাটাগরি এডিট করুন</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">নাম</label>
                                    <input type="text" name="name" class="form-control mb-3"
                                        value="{{ $cat->name }}" required>
                                    <label class="form-label">বিবরণ (ঐচ্ছিক)</label>
                                    <textarea name="description" class="form-control" rows="3">{{ $cat->description }}</textarea>
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
    {{ $categories->links() }}
@endsection

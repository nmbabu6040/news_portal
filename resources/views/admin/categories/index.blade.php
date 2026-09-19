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
                <th>ক্রম</th>
                <th>নাম</th>
                <th>আর্টিকেল সংখ্যা</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $cat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->articles_count }}</td>
                    <td>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

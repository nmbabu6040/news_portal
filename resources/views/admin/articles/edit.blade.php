@extends('admin.layout')

@section('content')
    <h3 class="mb-4">আর্টিকেল এডিট</h3>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.articles._form')

        <button type="submit" class="btn btn-danger mt-3">আপডেট করুন</button>
    </form>

    {{-- গ্যালারির ছবি ডিলিট করার ফর্মগুলো মূল আর্টিকেলের ফর্মের একদম বাইরে থাকবে --}}
    @if (isset($article) && $article->photos->count())
        @foreach ($article->photos as $photo)
            <form id="delete-photo-form-{{ $photo->id }}" action="{{ route('admin.photos.destroy', $photo) }}"
                method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif

@endsection

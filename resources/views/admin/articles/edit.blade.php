@extends('admin.layout')
@section('content')
<h3 class="mb-4">আর্টিকেল এডিট</h3>
<form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.articles._form')
    <button class="btn btn-danger mt-3">আপডেট করুন</button>
</form>
@endsection

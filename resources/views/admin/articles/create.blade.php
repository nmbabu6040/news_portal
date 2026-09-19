@extends('admin.layout')
@section('content')
<h3 class="mb-4">নতুন আর্টিকেল</h3>
<form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.articles._form')
    <button class="btn btn-danger mt-3">সংরক্ষণ করুন</button>
</form>
@endsection

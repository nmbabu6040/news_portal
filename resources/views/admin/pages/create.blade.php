@extends('admin.layout')

@section('title', 'নতুন পেজ তৈরি করুন')

<!-- Summernote CSS CDN -->
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="card p-4 shadow-sm">
        <h4 class="mb-4">নতুন পেজ যোগ করুন</h4>

        <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Page Title (শিরোনাম)</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}"
                        placeholder="example: advertise">
                </div>
            </div>

            <hr class="my-3">
            <h5 class="text-primary mb-3">সাধারণ পেজ কন্টেন্ট (১-কলাম লেআউটের জন্য)</h5>

            <div class="mb-3">
                <label class="form-label">Main Content</label>
                <textarea name="content" class="summernote form-control">{{ old('content') }}</textarea>
            </div>

            <hr class="my-4">
            <h5 class="text-danger mb-3">২-কলাম লেআউট কন্টেন্ট (বিজ্ঞাপন পেজের জন্য)</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">English Content (Left Column)</label>
                    <textarea name="content_en" class="summernote form-control">{{ old('content_en') }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Bangla Content (Right Column)</label>
                    <textarea name="content_bn" class="summernote form-control">{{ old('content_bn') }}</textarea>
                </div>
            </div>

            <div class="row bg-light p-3 rounded mb-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Print Rate Card (PDF/Image)</label>
                    <input type="file" name="print_rate_card" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Digital Media Kit (PDF/Image)</label>
                    <input type="file" name="digital_media_kit" class="form-control">
                </div>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">পাবলিশ করুন (Active)</label>
            </div>

            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> সেভ করুন</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">ফিরে যান</a>
        </form>
    </div>
@endsection

<!-- Summernote JS CDN & Script -->
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'এখানে কন্টেন্ট লিখুন...',
                tabsize: 2,
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });
    </script>
@endpush

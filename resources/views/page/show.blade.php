@extends('layouts.site')

@section('title', $page->title)

@section('content')
    <div class="container py-4">
        {{-- যদি ২-কলামের কন্টেন্ট (বাংলা ও ইংরেজি) থাকে --}}
        @if ($page->content_en || $page->content_bn)
            <div class="row gx-5">
                <!-- বাম পাশ: ইংরেজি কন্টেন্ট -->
                <div class="col-md-6 border-end pe-md-4">
                    <h2 class="text-danger fw-bold mb-4" style="color: #c00 !important;">{{ $page->title }}</h2>

                    <div class="content-en" style="font-size: 0.95rem; line-height: 1.6; text-align: justify;">
                        {!! $page->content_en !!}
                    </div>

                    <!-- প্রিন্ট এডিশন ডাউনলোড বাটন -->
                    @if ($page->print_rate_card)
                        <div class="mt-4">
                            <h6 class="fw-bold">Print Edition (ছাপা সংস্করণ)</h6>
                            <a href="{{ asset('storage/' . $page->print_rate_card) }}" target="_blank"
                                class="btn btn-primary btn-sm px-3 py-2 fw-bold">
                                <i class="bi bi-download me-1"></i> Download Rate Card
                            </a>
                        </div>
                    @endif

                    <!-- ডিজিটাল মিডিয়া কিট ডাউনলোড বাটন -->
                    @if ($page->digital_media_kit)
                        <div class="mt-4">
                            <h6 class="fw-bold">Digital Edition</h6>
                            <a href="{{ asset('storage/' . $page->digital_media_kit) }}" target="_blank"
                                class="btn btn-primary btn-sm px-3 py-2 fw-bold">
                                <i class="bi bi-download me-1"></i> Download Media Kit
                            </a>
                        </div>
                    @endif
                </div>

                <!-- ডান পাশ: বাংলা কন্টেন্ট -->
                <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
                    <h2 class="text-danger fw-bold mb-4" style="color: #c00 !important;">{{ $page->title }}</h2>

                    <div class="content-bn" style="font-size: 0.95rem; line-height: 1.7; text-align: justify;">
                        {!! $page->content_bn !!}
                    </div>
                </div>
            </div>
        @else
            {{-- সাধারণ ১-কলামের পেজ --}}
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm p-4 p-md-5 bg-white">
                        <h1 class="fw-bold mb-4 border-bottom pb-3 text-danger">{{ $page->title }}</h1>
                        <div class="page-content lh-lg">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

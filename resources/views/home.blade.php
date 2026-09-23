@extends('layouts.site')

@section('content')


    {{-- থাম্বনেইল পাথ রিটার্ন করার ইনলাইন Blade Helper/Closure --}}

    @php

        $getThumbnail = function ($article, $defaultUrl = 'https://picsum.photos/300/180') {
            if (!empty($article->thumbnail)) {
                // যদি Base64 SVG বাExternal URL (http/https) হয়

                if (\Illuminate\Support\Str::startsWith($article->thumbnail, ['data:', 'http://', 'https://'])) {
                    return $article->thumbnail;
                }

                // যদি Storage এ থাকা পাথ হয়

                return asset('storage/' . $article->thumbnail);
            }

            if (!empty($article->thumbnail_url)) {
                return $article->thumbnail_url;
            }

            return $defaultUrl;
        };

    @endphp



    {{-- ===== হিরো সেকশন: প্রধান খবর + সেকেন্ডারি খবর + সর্বাধিক পঠিত ===== --}}

    @if ($featured)
        <div class="row mb-4 g-3">

            <div class="col-lg-6">

                <a href="{{ route('article.show', $featured->slug) }}" class="text-decoration-none text-dark">

                    <img src="{{ $getThumbnail($featured, 'https://picsum.photos/800/450') }}" class="img-fluid rounded mb-2"
                        style="height:380px;width:100%;object-fit:cover;" alt="{{ $featured->title }}">

                    <span class="badge bg-danger category-badge">{{ $featured->category->name }}</span>

                    <h2 class="mt-2">{{ $featured->title }}</h2>

                    <p class="text-muted">{{ $featured->excerpt }}</p>

                </a>

            </div>



            <div class="col-lg-3">

                @foreach ($secondaryFeatured as $item)
                    <a href="{{ route('article.show', $item->slug) }}" class="text-decoration-none text-dark d-block mb-3">

                        <img src="{{ $getThumbnail($item, 'https://picsum.photos/400/220') }}"
                            class="img-fluid rounded mb-2" style="height:170px;width:100%;object-fit:cover;"
                            alt="{{ $item->title }}">

                        <span class="badge bg-secondary category-badge">{{ $item->category->name }}</span>

                        <h6 class="mt-1">{{ $item->title }}</h6>

                    </a>
                @endforeach

            </div>



            <div class="col-lg-3">

                <div class="bg-white rounded p-3 h-100">

                    <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-fire text-danger"></i> সর্বাধিক পঠিত</h5>

                    @foreach ($mostRead as $i => $item)
                        <a href="{{ route('article.show', $item->slug) }}" class="d-flex mb-3 text-dark">

                            <span class="fw-bold fs-4 text-danger me-2">{{ $i + 1 }}</span>

                            <span class="small">{{ $item->title }}</span>

                        </a>
                    @endforeach

                </div>

            </div>

        </div>
    @endif



    {{-- ===== সর্বশেষ খবর গ্রিড ===== --}}

    <h4 class="border-start border-danger border-4 ps-2 mb-3">সর্বশেষ</h4>

    <div class="row">

        @foreach ($latest as $article)
            <div class="col-md-3 mb-4">

                <div class="card article-card h-100">

                    <img src="{{ $getThumbnail($article, 'https://picsum.photos/300/180') }}" class="card-img-top"
                        alt="{{ $article->title }}">

                    <div class="card-body">

                        <span class="badge bg-secondary category-badge">{{ $article->category->name }}</span>

                        <h6 class="mt-2"><a href="{{ route('article.show', $article->slug) }}"
                                class="text-dark">{{ $article->title }}</a></h6>

                    </div>

                </div>

            </div>
        @endforeach

    </div>



    {{-- ===== ক্যাটাগরি-ভিত্তিক সেকশন ===== --}}

    @foreach ($categories as $category)
        @if ($category->articles->count())
            <div class="mt-4">

                <h4 class="border-start border-danger border-4 ps-2 mb-3">

                    <a href="{{ route('category.show', $category->slug) }}" class="text-dark">{{ $category->name }}</a>

                </h4>

                <div class="row">

                    @foreach ($category->articles as $article)
                        <div class="col-md-3 mb-3">

                            <a href="{{ route('article.show', $article->slug) }}" class="text-dark">

                                <img src="{{ $getThumbnail($article, 'https://picsum.photos/300/160') }}"
                                    class="img-fluid rounded mb-1" style="height:150px;width:100%;object-fit:cover;"
                                    alt="{{ $article->title }}">

                                <div class="small">{{ $article->title }}</div>

                            </a>

                        </div>
                    @endforeach

                </div>

            </div>
        @endif
    @endforeach



    {{-- ===== ভিডিও সেকশন ===== --}}

    @if ($videos->count())
        <div class="mt-4">

            <h4 class="border-start border-danger border-4 ps-2 mb-3"><i class="bi bi-play-circle-fill text-danger"></i>

                ভিডিও</h4>

            <div class="row">

                @foreach ($videos as $video)
                    <div class="col-md-3 mb-3">

                        <a href="{{ route('article.show', $video->slug) }}" class="text-dark position-relative d-block">

                            <img src="{{ $getThumbnail($video, 'https://picsum.photos/300/180') }}"
                                class="img-fluid rounded" style="height:160px;width:100%;object-fit:cover;"
                                alt="{{ $video->title }}">

                            <span
                                class="position-absolute top-50 start-50 translate-middle bg-danger rounded-circle d-flex align-items-center justify-content-center"
                                style="width:45px;height:45px;">

                                <i class="bi bi-play-fill text-white fs-4"></i>

                            </span>

                            <div class="small mt-1">{{ $video->title }}</div>

                        </a>

                    </div>
                @endforeach

            </div>

        </div>
    @endif



    {{-- ===== ফটো গ্যালারি সেকশন ===== --}}

    @if ($galleries->count())
        <div class="mt-4 mb-4">

            <h4 class="border-start border-danger border-4 ps-2 mb-3"><i class="bi bi-images text-danger"></i> ছবি</h4>

            <div class="row">

                @foreach ($galleries as $gallery)
                    <div class="col-md-3 mb-3">

                        <a href="{{ route('article.show', $gallery->slug) }}" class="text-dark position-relative d-block">

                            <img src="{{ $getThumbnail($gallery, 'https://picsum.photos/300/180') }}"
                                class="img-fluid rounded" style="height:160px;width:100%;object-fit:cover;"
                                alt="{{ $gallery->title }}">

                            <span
                                class="position-absolute bottom-0 end-0 bg-dark bg-opacity-75 text-white small px-2 py-1 rounded-top-start">

                                <i class="bi bi-images"></i> গ্যালারি

                            </span>

                            <div class="small mt-1">{{ $gallery->title }}</div>

                        </a>

                    </div>
                @endforeach

            </div>

        </div>
    @endif



@endsection

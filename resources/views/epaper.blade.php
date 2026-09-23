@extends('layouts.site')

@section('title', 'ই-পেপার')

@section('content')

    @include('partials.breadcrumb', ['items' => [['label' => 'ই-পেপার']]])
    <h3 class="mb-4">ই-পেপার</h3>

    @if ($latest)
        <div class="mb-4">
            <h5>{{ $latest->edition_date->format('d M Y') }}-এর সংস্করণ</h5>
            <embed src="{{ asset('storage/' . $latest->pdf_path) }}" type="application/pdf" width="100%" height="700px"
                class="rounded border">
        </div>
    @else
        <p class="text-muted">এখনো কোনো ই-পেপার আপলোড করা হয়নি।</p>
    @endif

    <h6 class="border-bottom pb-2 mb-3">পুরোনো সংস্করণ</h6>
    <div class="row">
        @foreach ($epapers as $epaper)
            <div class="col-md-3 mb-3">
                <a href="{{ asset('storage/' . $epaper->pdf_path) }}" target="_blank" class="card p-3 text-center text-dark">
                    📄 {{ $epaper->edition_date->format('d M Y') }}
                </a>
            </div>
        @endforeach
    </div>
    {{ $epapers->links() }}
@endsection

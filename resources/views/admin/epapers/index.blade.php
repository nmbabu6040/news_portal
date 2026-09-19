@extends('admin.layout')
@section('content')
<h3 class="mb-4">ই-পেপার ম্যানেজমেন্ট</h3>
<form action="{{ route('admin.epapers.store') }}" method="POST" enctype="multipart/form-data" class="row g-2 mb-4">
    @csrf
    <div class="col-md-3"><input type="date" name="edition_date" class="form-control" required></div>
    <div class="col-md-5"><input type="file" name="pdf" class="form-control" accept="application/pdf" required></div>
    <div class="col-md-2"><button class="btn btn-danger w-100">আপলোড</button></div>
</form>
<table class="table bg-white">
    <thead><tr><th>তারিখ</th><th>ফাইল</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
    @foreach($epapers as $epaper)
        <tr>
            <td>{{ $epaper->edition_date->format('d M Y') }}</td>
            <td><a href="{{ asset('storage/'.$epaper->pdf_path) }}" target="_blank">দেখুন</a></td>
            <td>
                <form action="{{ route('admin.epapers.destroy', $epaper) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $epapers->links() }}
@endsection

@extends('admin.layout')
@section('content')
    <h3 class="mb-4">ই-পেপার ম্যানেজমেন্ট</h3>
    <form action="{{ route('admin.epapers.store') }}" method="POST" enctype="multipart/form-data" class="row g-2 mb-4">
        @csrf
        <div class="col-md-3"><input type="date" name="edition_date" class="form-control" required></div>
        <div class="col-md-5"><input type="file" name="pdf" class="form-control" accept="application/pdf" required>
        </div>
        <div class="col-md-2"><button class="btn btn-danger w-100">আপলোড</button></div>
    </form>
    <table class="table bg-white">
        <thead>
            <tr>
                <th>#</th>
                <th>তারিখ</th>
                <th>ফাইল</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($epapers as $epaper)
                <tr>
                    <td>{{ $epapers->firstItem() + $loop->index }}</td>
                    <td>{{ $epaper->edition_date->format('d M Y') }}</td>
                    <td><a href="{{ asset('storage/' . $epaper->pdf_path) }}" target="_blank">দেখুন</a></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#editEpaperModal{{ $epaper->id }}">এডিট</button>
                        <form action="{{ route('admin.epapers.destroy', $epaper) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('নিশ্চিত?')">ডিলিট</button>
                        </form>
                    </td>
                </tr>

                {{-- এডিট মোডাল --}}
                <div class="modal fade" id="editEpaperModal{{ $epaper->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.epapers.update', $epaper) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">ই-পেপার এডিট করুন</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">তারিখ</label>
                                    <input type="date" name="edition_date" class="form-control mb-3"
                                        value="{{ $epaper->edition_date->format('Y-m-d') }}" required>
                                    <label class="form-label">নতুন PDF (ঐচ্ছিক — খালি রাখলে পুরনো ফাইলই থাকবে)</label>
                                    <input type="file" name="pdf" class="form-control" accept="application/pdf">
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
    {{ $epapers->links() }}
@endsection

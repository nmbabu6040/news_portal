@extends('admin.layout')
@section('content')
    <h3 class="mb-4">ড্যাশবোর্ড</h3>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card p-3"><small>মোট আর্টিকেল</small>
                <h3>{{ $stats['total_articles'] }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3"><small>প্রকাশিত</small>
                <h3>{{ $stats['published'] }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3"><small>ড্রাফট</small>
                <h3>{{ $stats['drafts'] }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3"><small>মোট ভিউ</small>
                <h3>{{ $stats['total_views'] }}</h3>
            </div>
        </div>
    </div>
    <h5>সাম্প্রতিক আর্টিকেল</h5>
    <table class="table bg-white">
        <thead>
            <tr>
                <th>ক্রম</th>
                <th>শিরোনাম</th>
                <th>স্ট্যাটাস</th>
                <th>তারিখ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recentArticles as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->title }}</td>
                    <td>{{ $a->status }}</td>
                    <td>{{ $a->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

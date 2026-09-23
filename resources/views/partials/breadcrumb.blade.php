{{--
    ব্যবহার: @include('partials.breadcrumb', ['items' => [
        ['label' => 'ক্যাটাগরি নাম', 'url' => route('category.show', $slug)],
        ['label' => 'আর্টিকেলের শিরোনাম'], // url না দিলে এটাই current/শেষ পেজ হিসেবে দেখাবে
    ]])
--}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}"><i class="bi bi-house-door-fill"></i> হোম</a>
        </li>
        @foreach ($items as $item)
            @if (!empty($item['url']) && !$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ \Illuminate\Support\Str::limit($item['label'], 60) }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>

<ul class="navbar-nav">
    @foreach(\App\Models\Category::all() as $cat)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a>
        </li>
    @endforeach
</ul>

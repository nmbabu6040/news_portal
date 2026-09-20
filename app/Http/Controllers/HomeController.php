<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Article::published()->where('is_featured', true)
            ->latest('published_at')->first();

        // হিরো সেকশনের পাশে দেখানোর জন্য পরের ২টা গুরুত্বপূর্ণ খবর
        $secondaryFeatured = Article::published()
            ->where('id', '!=', $featured->id ?? 0)
            ->latest('published_at')
            ->take(2)
            ->get();

        $latest = Article::published()
            ->where('id', '!=', $featured->id ?? 0)
            ->whereNotIn('id', $secondaryFeatured->pluck('id'))
            ->latest('published_at')
            ->take(8)
            ->get();

        $categories = Category::with(['articles' => function ($q) {
            $q->published()->latest('published_at')->take(4);
        }])->get();

        $mostRead = Article::published()
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $videos = Article::published()
            ->where('type', 'video')
            ->latest('published_at')
            ->take(4)
            ->get();

        $galleries = Article::published()
            ->where('type', 'gallery')
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('home', compact(
            'featured',
            'secondaryFeatured',
            'latest',
            'categories',
            'mostRead',
            'videos',
            'galleries'
        ));
    }
}

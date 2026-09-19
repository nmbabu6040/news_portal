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

        $latest = Article::published()
            ->where('id', '!=', $featured->id ?? 0)
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

        return view('home', compact('featured', 'latest', 'categories', 'mostRead'));
    }
}

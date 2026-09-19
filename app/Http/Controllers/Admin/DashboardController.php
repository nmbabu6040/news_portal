<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'drafts' => Article::where('status', 'draft')->count(),
            'categories' => Category::count(),
            'total_views' => Article::sum('views_count'),
        ];

        $recentArticles = Article::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentArticles'));
    }
}

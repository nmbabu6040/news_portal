<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Epaper;
use App\Models\Subscriber;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'drafts' => Article::where('status', 'draft')->count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'total_views' => Article::sum('views_count'),
            'pending_comments' => Comment::where('is_approved', false)->count(),
            'approved_comments' => Comment::where('is_approved', true)->count(),
            'subscribers' => Subscriber::count(),
            'epapers' => Epaper::count(),
            'gallery_count' => Article::where('type', 'gallery')->count(),
            'video_count' => Article::where('type', 'video')->count(),
        ];

        $recentArticles = Article::with('category')->latest()->take(8)->get();

        $topArticles = Article::published()
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $categoryStats = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->get();

        $maxCategoryCount = $categoryStats->max('articles_count') ?: 1;

        $recentComments = Comment::with('article')
            ->where('is_approved', false)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentArticles',
            'topArticles',
            'categoryStats',
            'maxCategoryCount',
            'recentComments'
        ));
    }
}

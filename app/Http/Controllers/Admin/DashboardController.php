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
            'total_articles'   => Article::count(),
            'published'        => Article::where('status', 'published')->count(),
            'drafts'           => Article::where('status', 'draft')->count(),
            'categories'       => Category::count(),
            'tags'             => Tag::count(),
            'total_views'      => Article::sum('views_count') ?? 0,
            'pending_comments' => Comment::where('is_approved', false)->count(),
            'approved_comments' => Comment::where('is_approved', true)->count(),
            'subscribers'      => Subscriber::count(),
            'epapers'          => Epaper::count(),
            'gallery_count'    => Article::where('type', 'gallery')->count(),
            'video_count'      => Article::where('type', 'video')->count(),
        ];

        // সাম্প্রতিক পোস্ট ও শীর্ষ পঠিত পোস্ট
        $recentArticles = Article::with('category')->latest()->take(8)->get();

        $topArticles = Article::published()
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        // সর্বোচ্চ নিবন্ধ যুক্ত শীর্ষ ৬টি ক্যাটাগরি
        $categoryStats = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(6)
            ->get();

        $maxCategoryCount = $categoryStats->max('articles_count') ?: 1;

        // অপেক্ষমান মন্তব্য
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

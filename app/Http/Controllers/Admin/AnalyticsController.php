<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'views_count');
        $allowedSorts = ['views_count', 'shares_count', 'likes_count', 'comments_count'];
        if (! in_array($sort, $allowedSorts)) {
            $sort = 'views_count';
        }

        $articles = Article::withCount(['likes', 'comments'])
            ->with('category')
            ->orderByDesc($sort)
            ->paginate(20)
            ->withQueryString();

        $totals = [
            'views' => Article::sum('views_count'),
            'likes' => \App\Models\Like::count(),
            'comments' => \App\Models\Comment::count(),
            'shares' => Article::sum('shares_count'),
        ];

        return view('admin.analytics.index', compact('articles', 'totals', 'sort'));
    }
}

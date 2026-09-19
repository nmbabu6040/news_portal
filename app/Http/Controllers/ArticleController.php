<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        abort_unless($article->status === 'published', 404);

        $article->increment('views_count');

        $related = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('article', compact('article', 'related'));
    }
}

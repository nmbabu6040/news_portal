<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ShareController extends Controller
{
    public function increment(Article $article)
    {
        $article->increment('shares_count');

        return response()->json(['count' => $article->shares_count]);
    }
}
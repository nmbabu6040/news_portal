<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Response;

class FeedController extends Controller
{
    public function index(): Response
    {
        $articles = Article::published()->latest('published_at')->take(30)->get();

        $xml = view('feed', compact('articles'))->render();

        return response($xml, 200)->header('Content-Type', 'application/rss+xml');
    }
}

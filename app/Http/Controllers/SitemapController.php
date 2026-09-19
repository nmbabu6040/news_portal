<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $articles = Article::published()->latest('published_at')->take(1000)->get();
        $categories = Category::all();

        $xml = view('sitemap', compact('articles', 'categories'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}

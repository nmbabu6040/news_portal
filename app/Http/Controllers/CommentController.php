<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'body' => 'required|string|max:1000',
        ]);

        $article->comments()->create($data + ['is_approved' => false]);

        return back()->with('status', 'আপনার মন্তব্য পাঠানো হয়েছে, মডারেশনের পর প্রকাশিত হবে।');
    }
}

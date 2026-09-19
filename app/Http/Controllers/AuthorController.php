<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;

class AuthorController extends Controller
{
    public function show(User $user)
    {
        $articles = Article::published()
            ->where('user_id', $user->id)
            ->latest('published_at')
            ->paginate(10);

        return view('author', compact('user', 'articles'));
    }
}

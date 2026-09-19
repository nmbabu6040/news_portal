<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $articles = $category->articles()
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('category', compact('category', 'articles'));
    }
}

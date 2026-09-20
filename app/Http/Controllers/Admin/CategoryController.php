<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return back()->with('status', 'ক্যাটাগরি যুক্ত হয়েছে');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // নোট: slug/URL ইচ্ছাকৃতভাবে বদলানো হচ্ছে না, যাতে আগের আর্টিকেল লিংক কাজ করে
        $category->update($data);

        return back()->with('status', 'ক্যাটাগরি আপডেট হয়েছে');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('status', 'ক্যাটাগরি ডিলিট হয়েছে');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('articles')->latest()->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:100']);
        Tag::firstOrCreate(
            ['slug' => Str::slug($data['name'])],
            ['name' => $data['name'], 'slug' => Str::slug($data['name'])]
        );

        return back()->with('status', 'ট্যাগ যুক্ত হয়েছে');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('status', 'ট্যাগ ডিলিট হয়েছে');
    }
}

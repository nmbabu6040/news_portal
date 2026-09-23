<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $article = Article::create($data);
        $article->tags()->sync($request->input('tag_ids', []));
        $this->storeGalleryPhotos($request, $article);

        return redirect()->route('admin.articles.index')->with('status', 'আর্টিকেল তৈরি হয়েছে');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validated($request);

        // ১. নতুন ফাইল আপডেট প্রসেসিং
        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail && !\Illuminate\Support\Str::startsWith($article->thumbnail, ['data:', 'http'])) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            unset($data['thumbnail']); // নতুন ছবি না দিলে পুরানোটাই থাকবে
        }

        // ২. স্ট্যাটাস হ্যান্ডলিং
        if ($data['status'] === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        }

        // ৩. ডাটাবেজ আপডেট
        $article->update($data);
        $article->tags()->sync($request->input('tag_ids', []));
        $this->storeGalleryPhotos($request, $article);

        return redirect()->route('admin.articles.index')->with('status', 'আর্টিকেল আপডেট হয়েছে');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'type' => 'required|in:article,gallery,video',
            'video_url' => 'nullable|url',
            'is_featured' => 'nullable',
            // 'image' রুল তুলে 'file' রাখা হয়েছে যাতে AVIF বা অন্য ফরম্যাটের জন্য এরর না আসে
            'thumbnail' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:10240',
            'gallery_photos.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:10240',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        return $validated;
    }

    public function destroyPhoto(Photo $photo)
    {
        if ($photo->image_path && !Str::startsWith($photo->image_path, ['data:', 'http'])) {
            Storage::disk('public')->delete($photo->image_path);
        }
        $photo->delete();
        return back()->with('status', 'ছবি ডিলিট হয়েছে');
    }


    private function storeGalleryPhotos(Request $request, Article $article): void
    {
        if ($request->hasFile('gallery_photos')) {
            foreach ($request->file('gallery_photos') as $photo) {
                $path = $photo->store('gallery', 'public');
                $article->photos()->create([
                    'image_path' => $path,
                ]);
            }
        }
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail && !Str::startsWith($article->thumbnail, ['data:', 'http'])) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();
        return back()->with('status', 'আর্টিকেল ডিলিট হয়েছে');
    }
}

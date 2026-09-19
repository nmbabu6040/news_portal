<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $article = Article::create($data);
        $article->tags()->sync($this->tagIds($request));
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

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update($data);
        $article->tags()->sync($this->tagIds($request));
        $this->storeGalleryPhotos($request, $article);

        return redirect()->route('admin.articles.index')->with('status', 'আর্টিকেল আপডেট হয়েছে');
    }

    public function destroyPhoto(Photo $photo)
    {
        $photo->delete();
        return back()->with('status', 'ছবি ডিলিট হয়েছে');
    }

    /**
     * Turn a comma-separated "tags" input (names) into tag IDs,
     * creating any tag that doesn't exist yet.
     */
    private function tagIds(Request $request): array
    {
        $names = array_filter(array_map('trim', explode(',', (string) $request->input('tags'))));

        return array_map(function ($name) {
            return Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name)]
            )->id;
        }, $names);
    }

    /**
     * Store any uploaded gallery photos (used when article type = gallery).
     */
    private function storeGalleryPhotos(Request $request, Article $article): void
    {
        if (! $request->hasFile('gallery_photos')) {
            return;
        }

        foreach ($request->file('gallery_photos') as $photo) {
            $article->photos()->create([
                'image_path' => $photo->store('gallery', 'public'),
            ]);
        }
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('status', 'আর্টিকেল ডিলিট হয়েছে');
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
            'is_featured' => 'boolean',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        unset($validated['thumbnail']);
        return $validated;
    }
}

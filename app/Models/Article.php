<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'category_id',
        'user_id',
        'is_featured',
        'status',
        'type',
        'video_url',
        'views_count',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }


    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }


    public function views(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    /**
     * Full thumbnail URL — works whether "thumbnail" holds a full
     * external URL (e.g. seeded demo data) or a local storage path
     * (e.g. uploaded via the admin panel).
     */
    // public function getThumbnailUrlAttribute(): ?string
    // {
    //     if (! $this->thumbnail) {
    //         return null;
    //     }

    //     return str_starts_with($this->thumbnail, 'http')
    //         ? $this->thumbnail
    //         : asset('storage/' . $this->thumbnail);
    // }

    public function getThumbnailUrlAttribute(): ?string
    {
        // যদি thumbnail ফিল্ডে কিছুই না থাকে
        if (! $this->thumbnail) {
            return null;
        }

        // ১. যদি সিডার/এক্সটার্নাল ইউআরএল (http, https বা base64/data:) হয়
        if (Str::startsWith($this->thumbnail, ['http://', 'https://', 'data:'])) {
            return $this->thumbnail;
        }

        // ২. যদি লোকালি আপলোড করা ফাইল হয় এবং স্টোরেজে ফাইলটি সত্যই বিদ্যমান থাকে
        if (Storage::disk('public')->exists($this->thumbnail)) {
            return asset('storage/' . $this->thumbnail);
        }

        // ৩. ফাইল পাথ ডাটাবেজে আছে কিন্তু স্টোরেজে ফাইলটি নেই (ফাইল ডিলিট হয়ে গেছে বা পাওয়া যাচ্ছে না)
        return null;
    }
}

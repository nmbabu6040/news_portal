<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = ['article_id', 'image_path', 'caption'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Full image URL — works for both external URLs (seeded demo data)
     * and local storage paths (uploaded via the admin panel).
     */
    public function getImageUrlAttribute(): string
    {
        if (! $this->image_path) {
            return null;
        }

        if (Str::startsWith($this->image_path, ['http://', 'https://', 'data:'])) {
            return $this->image_path;
        }

        if (Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }

        return null;
    }
}

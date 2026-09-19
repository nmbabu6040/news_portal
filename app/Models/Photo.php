<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return str_starts_with($this->image_path, 'http')
            ? $this->image_path
            : asset('storage/' . $this->image_path);
    }
}
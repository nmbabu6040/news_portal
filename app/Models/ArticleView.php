<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleView extends Model
{
    public $timestamps = false;

    protected $fillable = ['article_id', 'ip_address', 'created_at'];

    protected $casts = ['created_at' => 'datetime'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
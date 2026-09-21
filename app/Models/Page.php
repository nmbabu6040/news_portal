<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'content_en',
        'content_bn',
        'print_rate_card',
        'digital_media_kit',
        'is_active'
    ];
}

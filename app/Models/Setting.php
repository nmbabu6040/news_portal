<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'header_logo',
        'footer_logo',
        'about_text',
        'address',
        'phone',
        'email',
        'favicon',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'instagram_url',
        'footer_text',
    ];

    /**
     * সেটিংস টেবিলে সবসময় একটাই রো থাকে (সিঙ্গেলটন)।
     * না থাকলে ডিফল্ট ভ্যালু দিয়ে অটোমেটিক তৈরি হয়ে যাবে।
     */
    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }

    public function getHeaderLogoUrlAttribute(): ?string
    {
        return $this->header_logo ? asset('storage/' . $this->header_logo) : null;
    }

    public function getFooterLogoUrlAttribute(): ?string
    {
        return $this->footer_logo ? asset('storage/' . $this->footer_logo) : null;
    }

    public function getFaviconUrlAttribute(): ?string
    {
        return $this->favicon ? asset('storage/' . $this->favicon) : null;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * IP-ভিত্তিক টগল: প্রথমবার ক্লিকে লাইক হয়, দ্বিতীয়বার ক্লিকে আনলাইক হয়।
     */
    public function toggle(Request $request, Article $article)
    {
        $ip = $request->ip();
        $existing = $article->likes()->where('ip_address', $ip)->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            $article->likes()->create(['ip_address' => $ip]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $article->likes()->count(),
        ]);
    }
}
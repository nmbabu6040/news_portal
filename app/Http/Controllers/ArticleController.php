<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request, Article $article)
    {
        abort_unless($article->status === 'published', 404);

        $this->recordView($request, $article);

        $related = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('article', compact('article', 'related'));
    }

    /**
     * একই IP থেকে গত ২৪ ঘণ্টার মধ্যে এই আর্টিকেলে ভিউ থাকলে আবার গণনা করে না।
     * এভাবে রিফ্রেশ/বার বার ভিজিটে ভুয়া ভিউ বাড়ে না — বাস্তব ইউনিক ভিউ গণনা হয়।
     */
    private function recordView(Request $request, Article $article): void
    {
        $ip = $request->ip();

        $alreadyViewed = $article->views()
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();

        if ($alreadyViewed) {
            return;
        }

        $article->views()->create(['ip_address' => $ip]);
        $article->increment('views_count');
    }
}

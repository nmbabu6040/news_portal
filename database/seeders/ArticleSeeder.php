<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::first() ?? User::create([
            'name' => 'সম্পাদক',
            'email' => 'editor@newsportal.test',
            'password' => bcrypt('password'),
        ]);

        $sampleTitles = [
            'নতুন উদ্যোগে বদলে যাচ্ছে দেশের অর্থনীতি',
            'রাজধানীতে যানজট নিরসনে নতুন পরিকল্পনা',
            'আন্তর্জাতিক সম্মেলনে বাংলাদেশের প্রতিনিধিত্ব',
            'তরুণদের উদ্যোক্তা হওয়ার আগ্রহ বাড়ছে',
            'খেলাধুলায় নতুন সাফল্যের গল্প',
            'শিক্ষাক্ষেত্রে ডিজিটাল রূপান্তরের অগ্রগতি',
        ];

        // ডেমো ভিডিওর জন্য একটা সাধারণ পাবলিক YouTube embed লিংক
        $demoVideoUrl = 'https://www.youtube.com/embed/dQw4w9WgXcQ';

        foreach (Category::all() as $category) {
            foreach ($sampleTitles as $i => $title) {
                $fullTitle = $title . ' - ' . $category->name;
                $seed = $category->slug . '-' . $i;

                // ৬টার মধ্যে একটাকে গ্যালারি, একটাকে ভিডিও, বাকিগুলো সাধারণ আর্টিকেল বানানো হলো
                $type = match (true) {
                    $i === 3 => 'gallery',
                    $i === 4 => 'video',
                    default => 'article',
                };

                $article = Article::create([
                    'title' => $fullTitle,
                    'slug' => Str::slug($seed . '-' . Str::random(5)),
                    'excerpt' => 'এই প্রতিবেদনে বিস্তারিত তুলে ধরা হয়েছে সংশ্লিষ্ট বিষয়ের গুরুত্বপূর্ণ দিকগুলো।',
                    'content' => "বিস্তারিত প্রতিবেদন: {$fullTitle}\n\nএখানে সম্পূর্ণ সংবাদের বিস্তারিত বিবরণ যুক্ত করা হবে। এই কনটেন্ট এডিটর প্যানেল থেকে সহজেই পরিবর্তনযোগ্য।",
                    'thumbnail' => "https://placehold.co/800x450/c00000/white?text=" . urlencode($category->name),
                    'category_id' => $category->id,
                    'user_id' => $author->id,
                    'is_featured' => $i === 0,
                    'status' => 'published',
                    'type' => $type,
                    'video_url' => $type === 'video' ? $demoVideoUrl : null,
                    'views_count' => rand(50, 5000),
                    'published_at' => now()->subHours(rand(1, 72)),
                ]);

                if ($type === 'gallery') {
                    for ($p = 1; $p <= 3; $p++) {
                        $article->photos()->create([
                            'image_path' => "https://placehold.co/600x400/333/white?text=Photo+{$p}",
                            'caption' => "নমুনা ছবি {$p}",
                        ]);
                    }
                }
            }
        }
    }
}

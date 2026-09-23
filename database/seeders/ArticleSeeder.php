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
            'email' => 'nmbabu6040@gmail.com',
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

        // রঙের প্যালেট — প্রতিটা ক্যাটাগরির জন্য ভিন্ন রঙ, দেখতে সহজে আলাদা করা যায়
        $colors = ['c00000', '1a5f7a', '2d6a4f', '7b2d8e', 'b5651d', '2b4162', '8b0000', '3d5a80', '5f0f40'];

        foreach (Category::all() as $ci => $category) {
            $color = $colors[$ci % count($colors)];

            foreach ($sampleTitles as $i => $title) {
                $fullTitle = $title . ' - ' . $category->name;
                $seed = $category->slug . '-' . $i;

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
                    'thumbnail' => $this->placeholderImage($category->name, $color, 800, 450),
                    'category_id' => $category->id,
                    'user_id' => $author->id,
                    'is_featured' => $i === 0,
                    'status' => 'published',
                    'type' => $type,
                    'video_url' => $type === 'video' ? $demoVideoUrl : null,
                    'views_count' => 0,
                    'published_at' => now()->subHours(rand(1, 72)),
                ]);

                if ($type === 'gallery') {
                    for ($p = 1; $p <= 3; $p++) {
                        $article->photos()->create([
                            'image_path' => $this->placeholderImage("ছবি {$p}", $color, 600, 400),
                            'caption' => "নমুনা ছবি {$p}",
                        ]);
                    }
                }
            }
        }
    }

    /**
     * নেটওয়ার্ক/ইন্টারনেটের উপর নির্ভর না করে সরাসরি কোডের ভেতরে
     * একটা রঙিন প্লেসহোল্ডার ছবি (SVG) তৈরি করে base64 হিসেবে রিটার্ন করে।
     * এটা কখনো "broken image" দেখাবে না, কারণ কোনো external রিকোয়েস্ট লাগে না।
     */
    private function placeholderImage(string $text, string $hexColor, int $width, int $height): string
    {
        $safeText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}" viewBox="0 0 {$width} {$height}">
    <rect width="100%" height="100%" fill="#{$hexColor}"/>
    <text x="50%" y="50%" font-size="32" fill="#ffffff" text-anchor="middle" dominant-baseline="middle" font-family="sans-serif" font-weight="bold">{$safeText}</text>
</svg>
SVG;

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}

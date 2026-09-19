<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'বাংলাদেশ' => 'bangladesh',
            'রাজনীতি' => 'politics',
            'বিশ্ব' => 'world',
            'বাণিজ্য' => 'business',
            'মতামত' => 'opinion',
            'খেলা' => 'sports',
            'বিনোদন' => 'entertainment',
            'চাকরি' => 'jobs',
            'জীবনযাপন' => 'lifestyle',
        ];

        foreach ($categories as $name => $slug) {
            Category::create(['name' => $name, 'slug' => $slug]);
        }
    }
}

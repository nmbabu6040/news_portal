<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('thumbnail')->nullable()->change();
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->text('image_path')->change();
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->change();
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->string('image_path')->change();
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('shares_count')->default(0)->after('views_count');
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->timestamps();

            // একই IP থেকে একই আর্টিকেলে একবারের বেশি লাইক গোনা যাবে না
            $table->unique(['article_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('shares_count');
        });
    }
};
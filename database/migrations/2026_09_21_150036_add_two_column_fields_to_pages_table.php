<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->longText('content_en')->nullable()->after('content');
            $table->longText('content_bn')->nullable()->after('content_en');
            $table->string('print_rate_card')->nullable()->after('content_bn');
            $table->string('digital_media_kit')->nullable()->after('print_rate_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['content_en', 'content_bn', 'print_rate_card', 'digital_media_kit']);
        });
    }
};

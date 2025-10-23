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
        Schema::create('cms_content', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('e.g., homepage_hero_title');
            $table->enum('content_type', ['text', 'image_url', 'page_title'])->default('text');
            $table->longText('value');
            $table->string('page_slug')->default('landing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_content');
    }
};

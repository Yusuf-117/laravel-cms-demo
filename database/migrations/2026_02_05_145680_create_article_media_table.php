<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_media', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();

            $table->string('context', 30)->default('inline');
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->primary(['article_id', 'media_id', 'context']);
            $table->index(['article_id', 'context', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_media');
    }
};
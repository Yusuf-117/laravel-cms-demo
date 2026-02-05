<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title', 180);
            $table->string('slug', 200)->unique();

            $table->string('excerpt', 280)->nullable();
            $table->longText('content');

            $table->string('status', 20)->default('draft')->index();
            $table->string('visibility', 20)->default('public')->index();

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['category_id', 'status', 'visibility']);
            $table->index(['category_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
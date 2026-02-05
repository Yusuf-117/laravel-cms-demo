<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            $table->string('disk', 50)->default('public');
            $table->string('path', 255)->unique();

            $table->string('original_name', 255);
            $table->string('mime_type', 120)->index();
            $table->unsignedBigInteger('size_bytes')->default(0);

            $table->string('sha256', 64)->nullable()->index();

            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            $table->timestamps();

            $table->index(['disk', 'mime_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
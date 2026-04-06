<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Viewer
        User::updateOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name' => 'Demo Viewer',
                'password' => Hash::make('password'),
                'role' => 'viewer',
            ]
        );

        $author = User::first();

        $intro = Category::updateOrCreate(
            ['slug' => 'intro'],
            [
                'name' => 'Intro',
                'parent_id' => null,
                'sort_order' => 1,
            ]
        );

        Article::updateOrCreate(
            ['slug' => 'introduction'],
            [
                'category_id' => $intro->id,
                'author_id' => $author?->id,
                'title' => 'Introduction',
                'excerpt' => 'A quick overview of this CMS, why it exists, and how to safely explore the admin.',
                'content' => 'First'
                ]
        );
    }
}

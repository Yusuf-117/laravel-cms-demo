<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    public function create()
    {
        return inertia('Admin/Import');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'json' => ['required', 'string'],
        ]);

        $payload = json_decode($data['json'], true);

        if (!isset($payload['categories']) || !is_array($payload['categories'])) {
            return back()->withErrors(['json' => 'Invalid JSON structure']);
        }

        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return back()->withErrors(['json' => 'No admin user found']);
        }

        DB::transaction(function () use ($payload, $admin) {

            foreach ($payload['categories'] as $catData) {

                if (!isset($catData['name'])) continue;

                $category = Category::firstOrCreate(
                    ['name' => $catData['name']],
                    ['slug' => Str::slug($catData['name'])]
                );

                if (!isset($catData['articles']) || !is_array($catData['articles'])) continue;

                foreach ($catData['articles'] as $index => $articleData) {

                    if (!isset($articleData['title'])) continue;

                    $baseSlug = Str::slug($articleData['title']);
                    $slug = $baseSlug;
                    $counter = 1;

                    while (Article::where('slug', $slug)->exists()) {
                        $slug = $baseSlug . '-' . $counter++;
                    }

                    Article::create([
                        'category_id' => $category->id,
                        'author_id' => $admin->id,

                        'title' => $articleData['title'],
                        'slug' => $slug,

                        'excerpt' => $articleData['excerpt'] ?? null,
                        'content' => $articleData['content'] ?? '',

                        'status' => $articleData['status'] ?? 'published',
                        'visibility' => $articleData['visibility'] ?? 'public',
                        'sort_order' => $index,
                    ]);
                }
            }
        });

        return back()->with('success', 'Import completed');
    }
}
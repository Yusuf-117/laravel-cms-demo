<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with('category')
            ->when($request->search, fn ($q) =>
                $q->where('title', 'like', "%{$request->search}%")
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Articles/Index', [
            'articles' => $articles,
            'filters' => $request->only('search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Articles/Create', [
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'tags' => Tag::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required'],
            'slug' => ['required', 'unique:articles,slug'],
            'category_id' => ['required', 'exists:categories,id'],
            'content' => ['nullable'],
            'status' => ['required'],
            'tags' => ['array'],
        ]);

        $article = Article::create($data);

        $tagIds = collect($request->tags ?? [])
            ->map(function ($tag) {
                if (is_numeric($tag)) return $tag;

                return Tag::firstOrCreate(
                    ['name' => $tag],
                    ['slug' => Str::slug($tag)]
                )->id;
            });

        $article->tags()->sync($tagIds);

        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        return Inertia::render('Admin/Articles/Edit', [
            'article' => $article->load('tags:id,name'),
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'tags' => Tag::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title' => ['required'],
            'slug' => ['required', "unique:articles,slug,{$article->id}"],
            'category_id' => ['required', 'exists:categories,id'],
            'content' => ['nullable'],
            'status' => ['required'],
            'tags' => ['array'],
        ]);

        $article->update($data);

        $tagIds = collect($request->tags ?? [])
            ->map(function ($tag) {
                if (is_numeric($tag)) return $tag;

                return Tag::firstOrCreate(
                    ['name' => ucfirst(strtolower($tag))],
                    ['slug' => Str::slug($tag)]
                )->id;
            });

        $article->tags()->sync($tagIds);

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back();
    }
}
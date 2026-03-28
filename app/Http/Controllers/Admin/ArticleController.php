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
            'attachments' => ['array'],
            'attachments.*.media_id' => ['required', 'exists:media,id'],
            'attachments.*.label' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
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

        if ($request->attachments) {
            foreach ($request->attachments as $i => $att) {
                $article->attachments()->create([
                    'media_id' => $att['media_id'],
                    'label' => $att['label'] ?? null,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('articles.index')->with('success', 'Article created');
    }

    public function edit(Article $article)
    {
        return Inertia::render('Admin/Articles/Edit', [
            'article' => $article->load([
                'tags:id,name',
                'attachments.media:id,path,original_name'
            ]),
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
            'attachments' => ['array'],
            'attachments.*.media_id' => ['required', 'exists:media,id'],
            'attachments.*.label' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
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
        $article->attachments()->delete();

        if ($request->attachments) {
            foreach ($request->attachments as $i => $att) {
                $article->attachments()->create([
                    'media_id' => $att['media_id'],
                    'label' => $att['label'] ?? null,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('articles.index')->with('success', 'Article updated');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back();
    }
}

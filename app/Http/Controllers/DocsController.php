<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocsController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'children.articles',
            'articles'
        ])
        ->whereNull('parent_id')
        ->orderBy('position')
        ->get();

        $firstArticle = Article::orderBy('position')->first();

        return redirect()->route('docs.articles.show', $firstArticle->slug);
    }

    public function category(Category $category)
    {
        $sidebarCategories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $articles = $category->articles()
            ->where('status', 'published')
            ->orderBy('title')
            ->get([
                'id',
                'title',
                'slug',
                'excerpt',
                'updated_at',
            ]);

        return Inertia::render('Docs/Category', [
            'category' => $category->only('id', 'name', 'slug'),
            'categories' => $sidebarCategories,
            'articles' => $articles,
        ]);
    }

    public function article(Article $article)
    {
        abort_unless($article->status === 'published', 404);

        $article->load('author:id,name', 'category:id,name','attachments.media');

        $categories = Category::with([
            'children.articles.author:id,name',
            'articles.author:id,name',
        ])
        ->whereNull('parent_id')
        ->whereHas('articles', function ($q) {
            $q->where('status', 'published');
        })
        ->orderBy('position')
        ->get();

        return Inertia::render('Docs/Show', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    public function search(Request $request)
    {
        $articles = Article::with('category')
            ->published()
            ->public()
            ->search($request->search)
            ->latest()
            ->take(8)
            ->get(['id', 'title', 'slug', 'category_id']);

        return response()->json([
            'articles' => $articles->map(fn ($a) => [
                'title' => $a->title,
                'slug' => $a->slug,
                'category' => $a->category?->name,
            ])
        ]);
    }

}

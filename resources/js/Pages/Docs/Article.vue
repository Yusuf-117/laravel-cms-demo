<script setup>
import { Link } from '@inertiajs/vue3'
import DocsLayout from '@/Layouts/DocsLayout.vue'

defineProps({
    category: Object,
    categories: Array,
    articles: Array,
})
</script>

<template>
    <DocsLayout :categories="categories">
        <div class="space-y-6">
            <div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Category</div>
                <h1 class="mt-1 text-3xl font-semibold tracking-tight">{{ category.name }}</h1>
            </div>

            <div v-if="articles.length" class="grid gap-4">
                <Link v-for="article in articles" :key="article.id" :href="route('docs.articles.show', article.slug)"
                    class="rounded-2xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-base font-medium">{{ article.title }}</div>
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ article.updated_at }}</div>
                    </div>

                    <p v-if="article.excerpt" class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ article.excerpt }}
                    </p>
                </Link>
            </div>

            <div v-else
                class="rounded-2xl border border-dashed border-zinc-300 p-8 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                No published articles in this category yet.
            </div>
        </div>
    </DocsLayout>
</template>

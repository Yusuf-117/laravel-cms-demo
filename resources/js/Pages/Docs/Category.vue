<script setup>
import { Link } from '@inertiajs/vue3'
import DocsLayout from '@/Layouts/DocsLayout.vue'

defineProps({
    categories: Array,
    articles: Array,
})
</script>

<template>
    <DocsLayout :categories="categories">
        <div class="space-y-8">
            <section
                class="rounded-3xl border border-zinc-200 bg-gradient-to-br from-white to-zinc-50 p-8 dark:border-zinc-800 dark:from-zinc-900 dark:to-zinc-950">
                <div class="max-w-3xl">
                    <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">
                        Documentation that feels usable
                    </h1>
                    <p class="mt-3 text-base text-zinc-600 dark:text-zinc-400">
                        Browse categories, open published articles, and treat this like a real product knowledge base.
                    </p>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Browse by category</h2>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <Link v-for="category in categories" :key="category.id"
                        :href="route('docs.categories.show', category.slug)"
                        class="rounded-2xl border border-zinc-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="text-base font-medium">{{ category.name }}</div>
                        <div class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ category.published_articles_count }} article<span
                                v-if="category.published_articles_count !== 1">s</span>
                        </div>
                    </Link>
                </div>
            </section>

            <section class="space-y-4">
                <h2 class="text-xl font-semibold">Recently updated</h2>

                <div class="grid gap-4">
                    <Link v-for="article in articles" :key="article.id"
                        :href="route('docs.articles.show', article.slug)"
                        class="rounded-2xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <div class="text-base font-medium">{{ article.title }}</div>
                                <div class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ article.category?.name }}
                                </div>
                            </div>

                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ article.updated_at }}
                            </div>
                        </div>

                        <p v-if="article.excerpt" class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ article.excerpt }}
                        </p>
                    </Link>
                </div>
            </section>
        </div>
    </DocsLayout>
</template>

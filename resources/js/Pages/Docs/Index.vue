<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <div class="min-h-screen bg-white text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100">
        <div class="border-b border-zinc-200 bg-white/90 backdrop-blur dark:border-zinc-800 dark:bg-zinc-950/90">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <Link :href="route('home')" class="text-lg font-semibold">
                    Knowledge Base
                </Link>

                <div class="flex items-center gap-3">
                    <Link :href="route('login')"
                        class="rounded-lg border border-zinc-300 px-3 py-2 text-sm hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-900">
                        Admin
                    </Link>
                </div>
            </div>
        </div>

        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[260px_minmax(0,1fr)] lg:px-8">
            <aside class="lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                        Categories
                    </div>

                    <nav class="space-y-1">
                        <Link v-for="category in categories" :key="category.id"
                            :href="route('docs.categories.show', category.slug)"
                            class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">
                            {{ category.name }}
                        </Link>
                    </nav>
                </div>
            </aside>

            <main class="min-w-0">
                <slot />
            </main>
        </div>
    </div>
</template>

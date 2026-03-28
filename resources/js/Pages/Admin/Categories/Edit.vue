<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import { useAuth } from "@/composables/useAuth";
const { canEdit } = useAuth();

const props = defineProps({
    category: Object,
});

const form = useForm({
    name: props.category.name,
    slug: props.category.slug,
});

function submit() {
    form.put(route("categories.update", props.category.id));
}

function destroy() {
    if (confirm("Delete this category?")) {
        router.delete(route("categories.destroy", props.category.id));
    }
}
</script>

<template>
    <AdminLayout>
        <div class="mx-auto max-w-3xl space-y-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold">Edit Category</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Update category details
                    </p>
                </div>

                <Link :href="route('categories.index')"
                    class="inline-flex items-center rounded-lg border border-zinc-300 px-4 py-2 text-sm hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800">
                    Back
                </Link>
            </div>

            <div
                class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium">Name</label>
                        <input v-model="form.name" type="text"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-black dark:border-zinc-700 dark:bg-zinc-950 dark:focus:ring-white" />
                        <p v-if="form.errors.name" class="text-sm text-red-600 dark:text-red-400">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium">Slug</label>
                        <input v-model="form.slug" type="text"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-black dark:border-zinc-700 dark:bg-zinc-950 dark:focus:ring-white" />
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            Used in URLs. Keep it short and clean.
                        </p>
                        <p v-if="form.errors.slug" class="text-sm text-red-600 dark:text-red-400">
                            {{ form.errors.slug }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <button v-if="canEdit" type="submit" :disabled="form.processing"
                                class="inline-flex items-center rounded-lg bg-black px-4 py-2.5 text-sm font-medium text-white hover:opacity-90 disabled:opacity-50 dark:bg-white dark:text-black">
                                Save Changes
                            </button>
                        </div>

                        <button v-if="canEdit" type="button" @click="destroy"
                            class="inline-flex items-center rounded-lg border border-red-300 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:border-red-900 dark:text-red-400 dark:hover:bg-red-950/40">
                            Delete Category
                        </button>
                    </div>
                </form>
                <div class="mt-10">
                    <h2 class="text-xl font-semibold mb-4">Articles</h2>

                    <div v-if="category.articles.length">
                        <ul class="space-y-2">
                            <li v-for="article in category.articles" :key="article.id">
                                <Link :href="route('articles.edit', article.id)" class="text-blue-600 hover:underline">
                                    {{ article.title }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <div v-else class="text-gray-500">
                        No articles in this category.
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

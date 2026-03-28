<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { watch } from 'vue'

const form = useForm({
    name: '',
    slug: '',
    sort_order: 0,
})
watch(
    () => form.name,
    (value) => {
        if (!form.slug || form.slug === slugify(form.name)) {
            form.slug = slugify(value)
        }
    }
)

function slugify(value) {
    return (value || '')
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
}

function submit() {
    form.post(route('categories.store'))
}
</script>

<template>
    <AdminLayout>
        <div class="mx-auto max-w-3xl space-y-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold">New Category</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Create a category for your knowledge base
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
                        <input v-model="form.name" type="text" placeholder="e.g. Getting Started"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-black dark:border-zinc-700 dark:bg-zinc-950 dark:focus:ring-white" />
                        <p v-if="form.errors.name" class="text-sm text-red-600 dark:text-red-400">
                            {{ form.errors.name }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium">Order</label>
                        <input
                            v-model="form.sort_order"
                            type="number"
                            class="w-full rounded-lg border border-zinc-300 px-4 py-2.5 text-sm dark:border-zinc-700 dark:bg-zinc-950"
                        />
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium">Slug</label>
                        <input v-model="form.slug" type="text" placeholder="e.g. getting-started"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-black dark:border-zinc-700 dark:bg-zinc-950 dark:focus:ring-white" />
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            Used in URLs. Keep it short and clean.
                        </p>
                        <p v-if="form.errors.slug" class="text-sm text-red-600 dark:text-red-400">
                            {{ form.errors.slug }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" :disabled="form.processing"
                            class="inline-flex items-center rounded-lg bg-black px-4 py-2.5 text-sm font-medium text-white hover:opacity-90 disabled:opacity-50 dark:bg-white dark:text-black">
                            Create Category
                        </button>

                        <Link :href="route('categories.index')"
                            class="inline-flex items-center rounded-lg border border-zinc-300 px-4 py-2.5 text-sm hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import Form from './_Form.vue'
import { useAuth } from '@/composables/useAuth';
const { canEdit } = useAuth();

const props = defineProps({
    article: Object,
    categories: Array,
    tags: Array,
})

const form = useForm({
    title: props.article.title,
    slug: props.article.slug,
    category_id: props.article.category_id,
    content: props.article.content,
    status: props.article.status,
    tags: props.article.tags.map(t => t.id),
    attachments: (props.article.attachments || []).map(a => ({
        media_id: a.media_id,
        label: a.label,
        sort_order: a.sort_order,
    })),
})

function submit() {
    form.put(route('articles.update', props.article.id))
}

function destroy() {
    if (confirm('Delete article?')) {
        router.delete(route('articles.destroy', props.article.id))
    }
}
</script>

<template>
    <AdminLayout>
        <div class="mx-auto max-w-3xl space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Edit Article</h1>
                <Link :href="route('articles.index')" class="text-sm underline">Back</Link>
            </div>

            <div class="bg-white dark:bg-zinc-900 border rounded-xl p-6">
                <Form :form="form" :categories="categories" :tags="tags" :submit="submit" :isEdit="true" />
            </div>

            <div class="flex justify-end">
                <button v-if="canEdit" @click="destroy" type="button" class="text-red-600 dark:text-red-400">
                    Delete
                </button>
            </div>
        </div>
    </AdminLayout>
</template>

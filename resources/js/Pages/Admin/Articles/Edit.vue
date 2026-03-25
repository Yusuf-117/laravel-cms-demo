<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router, useForm } from '@inertiajs/vue3'

const props = defineProps({
  article: Object,
  categories: Array,
})

const form = useForm({
  title: props.article.title,
  slug: props.article.slug,
  category_id: props.article.category_id,
  content: props.article.content,
  status: props.article.status,
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
    <div class="mx-auto max-w-5xl space-y-6">

      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Edit Article</h1>

        <Link :href="route('articles.index')" class="text-sm underline">
          Back
        </Link>
      </div>

      <form @submit.prevent="submit" class="space-y-6">

        <div class="grid md:grid-cols-2 gap-6">

          <div class="space-y-4">
            <input v-model="form.title" class="w-full p-3 border rounded-lg dark:bg-zinc-900" />
            <input v-model="form.slug" class="w-full p-3 border rounded-lg dark:bg-zinc-900" />

            <select v-model="form.category_id"
              class="w-full p-3 border rounded-lg dark:bg-zinc-900">
              <option v-for="c in categories" :key="c.id" :value="c.id">
                {{ c.name }}
              </option>
            </select>

            <select v-model="form.status"
              class="w-full p-3 border rounded-lg dark:bg-zinc-900">
              <option value="draft">Draft</option>
              <option value="published">Published</option>
            </select>
          </div>

          <textarea v-model="form.content"
            class="w-full h-64 p-3 border rounded-lg dark:bg-zinc-900"></textarea>

        </div>

        <div class="flex justify-between">
          <button class="bg-black text-white px-4 py-2 rounded dark:bg-white dark:text-black">
            Save
          </button>

          <button @click="destroy" type="button"
            class="text-red-600 dark:text-red-400">
            Delete
          </button>
        </div>

      </form>

    </div>
  </AdminLayout>
</template>
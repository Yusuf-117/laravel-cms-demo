<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { watch } from 'vue'

const props = defineProps({
  categories: Array,
})

const form = useForm({
  title: '',
  slug: '',
  category_id: '',
  content: '',
  status: 'draft',
})

watch(() => form.title, (v) => {
  if (!form.slug) {
    form.slug = v.toLowerCase().replace(/\s+/g, '-')
  }
})

function submit() {
  form.post(route('articles.store'))
}
</script>

<template>
  <AdminLayout>
    <div class="mx-auto max-w-5xl space-y-6">

      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">New Article</h1>

        <Link :href="route('articles.index')" class="text-sm underline">
          Back
        </Link>
      </div>

      <form @submit.prevent="submit" class="space-y-6">

        <div class="grid md:grid-cols-2 gap-6">

          <div class="space-y-4">
            <input v-model="form.title" placeholder="Title"
              class="w-full p-3 border rounded-lg dark:bg-zinc-900" />

            <input v-model="form.slug" placeholder="Slug"
              class="w-full p-3 border rounded-lg dark:bg-zinc-900" />

            <select v-model="form.category_id"
              class="w-full p-3 border rounded-lg dark:bg-zinc-900">
              <option value="">Select category</option>
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

          <div class="space-y-4">
            <textarea v-model="form.content"
              class="w-full h-64 p-3 border rounded-lg dark:bg-zinc-900"
              placeholder="Content..."></textarea>
          </div>

        </div>

        <button class="bg-black text-white px-4 py-2 rounded dark:bg-white dark:text-black">
          Create Article
        </button>

      </form>

    </div>
  </AdminLayout>
</template>
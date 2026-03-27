<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import Form from './_Form.vue'

const props = defineProps({
  categories: Array,
  tags: Array,
})

const form = useForm({
  title: '',
  slug: '',
  category_id: '',
  content: '',
  status: 'draft',
  tags: [],
  attachments: [],
})

function submit() {
  form.post(route('articles.store'))
}
</script>

<template>
  <AdminLayout>
    <div class="mx-auto max-w-3xl space-y-6">

      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold">New Article</h1>
        <Link :href="route('articles.index')" class="text-sm underline">Back</Link>
      </div>

      <div class="bg-white dark:bg-zinc-900 border rounded-xl p-6">
        <Form
          :form="form"
          :categories="categories"
          :tags="tags"
          :submit="submit"
          :isEdit="false"
        />
      </div>

    </div>
  </AdminLayout>
</template>
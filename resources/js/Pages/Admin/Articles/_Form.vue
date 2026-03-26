<script setup>
import { ref, watch } from 'vue'
import Editor from '@/Components/Editor.vue'

const props = defineProps({
  form: Object,
  categories: Array,
  submit: Function,
  isEdit: Boolean,
})

const content = ref(props.form.content || '<p></p>')

watch(content, (val) => {
  props.form.content = val
})

watch(
  () => props.form.content,
  (val) => {
    if (!val) return
    if (val === content.value) return
    content.value = val
  }
)
</script>

<template>
  <form @submit.prevent="submit" class="space-y-6">

    <div>
      <label class="block text-sm font-medium mb-1">Title</label>
      <input
        v-model="form.title"
        class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900"
      />
      <p v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</p>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Slug</label>
      <input
        v-model="form.slug"
        class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900"
      />
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Category</label>
      <select
        v-model="form.category_id"
        class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900"
      >
        <option value="">Select</option>
        <option v-for="c in categories" :key="c.id" :value="c.id">
          {{ c.name }}
        </option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Status</label>
      <select
        v-model="form.status"
        class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900"
      >
        <option value="draft">Draft</option>
        <option value="published">Published</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-2">Content</label>

      <Editor v-model="content" />
    </div>

    <div class="flex justify-between items-center pt-4">
      <button
        class="bg-black text-white px-5 py-2 rounded-lg dark:bg-white dark:text-black"
      >
        {{ isEdit ? 'Update' : 'Create' }}
      </button>
    </div>

  </form>
</template>
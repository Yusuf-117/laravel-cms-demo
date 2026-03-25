<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import debounce from 'lodash/debounce'

const props = defineProps({
  articles: Object,
  filters: Object,
})

const search = ref(props.filters.search || '')

const doSearch = debounce(() => {
  router.get(route('articles.index'), {
    search: search.value,
  }, {
    preserveState: true,
    replace: true,
  })
}, 300)

watch(search, doSearch)

function destroy(id) {
  if (confirm('Delete this article?')) {
    router.delete(route('articles.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <div class="space-y-6">

      <!-- HEADER -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-2xl font-semibold">Articles</h1>
          <p class="text-sm text-zinc-500 dark:text-zinc-400">
            Manage your knowledge base content
          </p>
        </div>

        <Link
          :href="route('articles.create')"
          class="inline-flex items-center px-4 py-2 rounded-lg bg-black text-white text-sm hover:opacity-90 dark:bg-white dark:text-black"
        >
          + New Article
        </Link>
      </div>

      <!-- SEARCH -->
      <div class="flex items-center gap-3">
        <input
          v-model="search"
          placeholder="Search articles..."
          class="w-full sm:w-80 px-4 py-2 rounded-lg border border-zinc-300 bg-white text-sm
                 focus:outline-none focus:ring-2 focus:ring-black
                 dark:bg-zinc-900 dark:border-zinc-700 dark:focus:ring-white"
        />
      </div>

      <!-- TABLE -->
      <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">

        <table class="w-full text-sm">
          <thead class="bg-zinc-50 dark:bg-zinc-800">
            <tr class="text-left text-zinc-600 dark:text-zinc-300">
              <th class="px-6 py-3 font-medium">Title</th>
              <th class="px-6 py-3 font-medium">Category</th>
              <th class="px-6 py-3 font-medium">Status</th>
              <th class="px-6 py-3 font-medium">Updated</th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="a in articles.data"
              :key="a.id"
              class="border-t border-zinc-100 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition"
            >
              <td class="px-6 py-4 font-medium">
                {{ a.title }}
              </td>

              <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400">
                {{ a.category?.name }}
              </td>

              <td class="px-6 py-4">
                <span
                  class="px-2 py-1 text-xs rounded-full"
                  :class="{
                    'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300': a.status === 'published',
                    'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300': a.status === 'draft'
                  }"
                >
                  {{ a.status }}
                </span>
              </td>

              <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400">
                {{ a.updated_at }}
              </td>

              <td class="px-6 py-4 text-right space-x-3">
                <Link
                  :href="route('articles.edit', a.id)"
                  class="text-sm text-blue-600 hover:underline dark:text-blue-400"
                >
                  Edit
                </Link>

                <button
                  @click="destroy(a.id)"
                  class="text-sm text-red-600 hover:underline dark:text-red-400"
                >
                  Delete
                </button>
              </td>
            </tr>

            <tr v-if="articles.data.length === 0">
              <td colspan="5" class="px-6 py-10 text-center text-zinc-500 dark:text-zinc-400">
                No articles found.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="flex flex-wrap gap-2">
        <Link
          v-for="link in articles.links"
          :key="link.label"
          :href="link.url || ''"
          v-html="link.label"
          class="px-3 py-1.5 rounded-md text-sm border
                 border-zinc-300 hover:bg-zinc-100
                 dark:border-zinc-700 dark:hover:bg-zinc-800"
          :class="{
            'bg-black text-white dark:bg-white dark:text-black': link.active,
            'opacity-50 pointer-events-none': !link.url
          }"
        />
      </div>

    </div>
  </AdminLayout>
</template>
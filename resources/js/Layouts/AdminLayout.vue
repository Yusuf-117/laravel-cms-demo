<script setup>
import { computed, onMounted, ref } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth?.user)

const theme = ref(document.documentElement.classList.contains('dark') ? 'dark' : 'light')

function setTheme(value) {
  theme.value = value

  if (value === 'dark') {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }

  localStorage.setItem('theme', value)
}

function toggleTheme() {
  setTheme(theme.value === 'dark' ? 'light' : 'dark')
}

onMounted(() => {
  const saved = localStorage.getItem('theme')
  setTheme(saved === 'dark' ? 'dark' : 'light')
})

function logout() {
  router.post(route('logout'))
}
</script>

<template>
  <div class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100">
    <div class="flex">
      <aside class="w-64 shrink-0 border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="h-14 flex items-center px-4 border-b border-zinc-200 dark:border-zinc-800">
          <Link :href="route('admin.dashboard')" class="font-semibold">
            Admin
          </Link>
        </div>

        <nav class="p-2 space-y-1">
          <Link
            :href="route('admin.dashboard')"
            class="block rounded px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800"
          >
            Dashboard
          </Link>
        </nav>
      </aside>

      <div class="flex-1 min-w-0">
        <header class="h-14 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between px-4">
          <div class="text-sm font-medium">Dashboard</div>

          <div class="flex items-center gap-3">
            <button
              type="button"
              @click="toggleTheme"
              class="text-sm rounded px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800"
            >
              {{ theme === 'dark' ? 'Light' : 'Dark' }}
            </button>

            <div v-if="user" class="text-sm text-zinc-600 dark:text-zinc-400">
              {{ user.name ?? user.email }}
            </div>

            <button
              v-if="user"
              type="button"
              @click="logout"
              class="text-sm rounded px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800"
            >
              Logout
            </button>

            <Link
              v-else
              :href="route('login')"
              class="text-sm rounded px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800"
            >
              Login
            </Link>
          </div>
        </header>

        <main class="p-6">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-h-screen bg-white text-zinc-900">
    <div class="mx-auto max-w-6xl px-4">
      <header class="h-14 flex items-center justify-between border-b border-zinc-200">
        <Link :href="route('Home')" class="font-semibold">Docs</Link>
        <nav class="flex items-center gap-2">
          <Link :href="route('login')" class="text-sm rounded px-3 py-2 hover:bg-zinc-100">Admin</Link>
        </nav>
      </header>

      <div class="flex gap-8">
        <aside class="w-64 shrink-0 py-6">
          <div class="text-xs font-semibold text-zinc-500 mb-2">Sections</div>
          <nav class="space-y-1">
            <a href="#" class="block rounded px-3 py-2 text-sm hover:bg-zinc-100">Getting started</a>
            <a href="#" class="block rounded px-3 py-2 text-sm hover:bg-zinc-100">Guides</a>
            <a href="#" class="block rounded px-3 py-2 text-sm hover:bg-zinc-100">Reference</a>
          </nav>
        </aside>

        <main class="flex-1 py-6 min-w-0">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
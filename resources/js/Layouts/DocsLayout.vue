<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed, onMounted, ref } from 'vue'

const props = defineProps({
  categories: {
    type: Array,
    default: () => [],
  },
})

const page = usePage()
const article = computed(() => page.props.article ?? null)
const currentSlug = computed(() => article.value?.slug ?? null)

const theme = ref('dark')
const open = ref({})

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
  setTheme(saved === 'light' ? 'light' : 'dark')

  const next = {}
  for (const cat of props.categories) {
    const catHasCurrent = (cat.articles || []).some(a => a.slug === currentSlug.value)
    const childHasCurrent = (cat.children || []).some(child =>
      (child.articles || []).some(a => a.slug === currentSlug.value)
    )

    next[`cat-${cat.id}`] = catHasCurrent || childHasCurrent

    for (const child of cat.children || []) {
      const hasCurrent = (child.articles || []).some(a => a.slug === currentSlug.value)
      next[`child-${child.id}`] = hasCurrent
    }
  }

  open.value = next
})

function toggleSection(key) {
  open.value[key] = !open.value[key]
}
</script>

<template>
  <div
    class="min-h-screen bg-[var(--docs-bg)] text-[var(--docs-text)]"
  >
    <div class="grid min-h-screen grid-cols-[260px_minmax(0,1fr)_300px]">
      <aside
        class="border-r border-[var(--docs-border)] bg-[var(--docs-panel)]"
      >
        <div class="flex h-14 items-center border-b border-[var(--docs-border)] px-4">
          <Link
            :href="route('home')"
            class="text-lg font-semibold tracking-tight text-[var(--docs-text)]"
          >
            Knowledge Archive
          </Link>
        </div>

        <div class="px-4 pb-6 pt-4">
          <div class="mb-6 text-[10px] uppercase tracking-[0.24em] text-[var(--docs-muted)]">
            Demo
          </div>

          <div class="space-y-1">
            <div
              v-for="cat in categories"
              :key="cat.id"
              class="space-y-1"
            >
              <button
                type="button"
                @click="toggleSection(`cat-${cat.id}`)"
                class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm font-medium transition hover:bg-[var(--docs-hover)]"
              >
                <span class="flex min-w-0 items-center gap-3">
                  <span
                    class="h-4 w-[3px] rounded-full"
                    :class="open[`cat-${cat.id}`] ? 'bg-[var(--docs-primary)]' : 'bg-transparent'"
                  />
                  <span class="truncate">{{ cat.name }}</span>
                </span>

                <svg
                  class="h-4 w-4 shrink-0 text-[var(--docs-muted)] transition"
                  :class="open[`cat-${cat.id}`] ? 'rotate-90' : ''"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M7.21 4.23a.75.75 0 011.06-.02l5.25 5a.75.75 0 010 1.08l-5.25 5a.75.75 0 11-1.04-1.08L11.94 10 7.23 5.31a.75.75 0 01-.02-1.08z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>

              <div
                v-show="open[`cat-${cat.id}`]"
                class="space-y-1 pl-3"
              >
                <Link
                  v-for="a in cat.articles || []"
                  :key="a.id"
                  :href="route('docs.articles.show', a.slug)"
                  class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition hover:bg-[var(--docs-hover)]"
                  :class="a.slug === currentSlug ? 'bg-[var(--docs-hover)] text-[var(--docs-primary)]' : 'text-[var(--docs-text)]'"
                >
                  <span
                    class="h-4 w-[3px] rounded-full"
                    :class="a.slug === currentSlug ? 'bg-[var(--docs-primary)]' : 'bg-transparent'"
                  />
                  <span class="truncate">{{ a.title }}</span>
                </Link>

                <div
                  v-for="child in cat.children || []"
                  :key="child.id"
                  class="space-y-1"
                >
                  <button
                    type="button"
                    @click="toggleSection(`child-${child.id}`)"
                    class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm text-[var(--docs-muted)] transition hover:bg-[var(--docs-hover)] hover:text-[var(--docs-text)]"
                  >
                    <span class="flex min-w-0 items-center gap-3">
                      <span
                        class="h-4 w-[3px] rounded-full"
                        :class="open[`child-${child.id}`] ? 'bg-[var(--docs-secondary)]' : 'bg-transparent'"
                      />
                      <span class="truncate">{{ child.name }}</span>
                    </span>

                    <svg
                      class="h-4 w-4 shrink-0 transition"
                      :class="open[`child-${child.id}`] ? 'rotate-90' : ''"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M7.21 4.23a.75.75 0 011.06-.02l5.25 5a.75.75 0 010 1.08l-5.25 5a.75.75 0 11-1.04-1.08L11.94 10 7.23 5.31a.75.75 0 01-.02-1.08z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>

                  <div
                    v-show="open[`child-${child.id}`]"
                    class="space-y-1 pl-3"
                  >
                    <Link
                      v-for="a in child.articles || []"
                      :key="a.id"
                      :href="route('docs.articles.show', a.slug)"
                      class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition hover:bg-[var(--docs-hover)]"
                      :class="a.slug === currentSlug ? 'bg-[var(--docs-hover)] text-[var(--docs-primary)]' : 'text-[var(--docs-text)]'"
                    >
                      <span
                        class="h-4 w-[3px] rounded-full"
                        :class="a.slug === currentSlug ? 'bg-[var(--docs-primary)]' : 'bg-transparent'"
                      />
                      <span class="truncate">{{ a.title }}</span>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </aside>

      <div class="min-w-0 bg-[var(--docs-bg)]">
        <header
          class="sticky top-0 z-20 flex h-14 items-center justify-end border-b border-[var(--docs-border)] bg-[var(--docs-bg)]/90 px-6 backdrop-blur"
        >
          <div class="flex items-center gap-3">
            <div class="relative hidden md:block">
              <svg
                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[var(--docs-muted)]"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M9 3.75a5.25 5.25 0 103.319 9.318l3.806 3.806a.75.75 0 101.06-1.06l-3.806-3.806A5.25 5.25 0 009 3.75zM5.25 9a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0z"
                  clip-rule="evenodd"
                />
              </svg>

              <input
                type="text"
                placeholder="Search archives..."
                class="h-10 w-64 rounded-lg border border-[var(--docs-border-strong)] bg-[var(--docs-panel-2)] pl-10 pr-4 text-sm text-[var(--docs-text)] outline-none placeholder:text-[var(--docs-muted)] focus:border-[var(--docs-primary)]"
              />
            </div>

            <button
              type="button"
              @click="toggleTheme"
              class="rounded-lg p-2 text-[var(--docs-muted)] transition hover:bg-[var(--docs-hover)] hover:text-[var(--docs-text)]"
            >
              <svg v-if="theme === 'dark'" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 2.75a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V3.5a.75.75 0 01.75-.75zm0 11.5a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V15a.75.75 0 01.75-.75zm7.25-4.25a.75.75 0 010 1.5h-1.5a.75.75 0 010-1.5h1.5zM5 10a.75.75 0 010 1.5H3.5a.75.75 0 010-1.5H5zm10.157-4.157a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zM7.963 13.037a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm7.194 2.12a.75.75 0 01-1.06 0l-1.06-1.06a.75.75 0 111.06-1.06l1.06 1.06a.75.75 0 010 1.06zM7.963 6.963a.75.75 0 01-1.06 0l-1.06-1.06a.75.75 0 011.06-1.06l1.06 1.06a.75.75 0 010 1.06zM10 6.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z"/>
              </svg>

              <svg v-else class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M17.293 13.293a.75.75 0 00-.982-.087 7.5 7.5 0 01-9.517-9.517.75.75 0 00-.94-.94A9 9 0 1018.233 14.233a.75.75 0 00-.94-.94z"/>
              </svg>
            </button>

            <Link
              :href="route('login')"
              class="rounded-lg p-2 text-[var(--docs-muted)] transition hover:bg-[var(--docs-hover)] hover:text-[var(--docs-text)]"
            >
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 10a3.25 3.25 0 100-6.5 3.25 3.25 0 000 6.5zM4.25 16A4.75 4.75 0 019 11.25h2A4.75 4.75 0 0115.75 16v.25H4.25V16z"/>
              </svg>
            </Link>
          </div>
        </header>

        <main class="px-8 py-7 xl:px-10">
          <div class="mb-4 text-[11px] uppercase tracking-[0.22em] text-[var(--docs-muted)]">
            Documentation
            <span class="mx-2 text-[var(--docs-border-strong)]">›</span>
            <span>{{ article?.category?.name ?? 'Category' }}</span>
            <span class="mx-2 text-[var(--docs-border-strong)]">›</span>
            <span class="text-[var(--docs-primary)]">{{ article?.title }}</span>
          </div>

          <div class="mb-8 max-w-4xl">
            <h1 class="text-5xl font-black leading-[0.95] tracking-[-0.04em] text-[var(--docs-text)]">
              {{ article?.title }}
            </h1>

            <div class="mt-5 flex flex-wrap items-center gap-3 text-sm text-[var(--docs-muted)]">
              <span class="inline-block h-7 w-[2px] rounded-full bg-[var(--docs-primary)]" />
              <span>Updated {{ article?.updated_at }}</span>
              <span>•</span>
              <span>{{ article?.author?.name }}</span>
            </div>
          </div>

          <div class="grid grid-cols-[minmax(0,1fr)_240px] gap-10">
            <div class="min-w-0">
              <slot />
            </div>

            <aside class="space-y-6 pt-2">
              <div>
                <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.24em] text-[var(--docs-text)]">
                  On this page
                </div>

                <div class="space-y-3 text-sm">
                  <div class="flex items-center gap-3 text-[var(--docs-primary)]">
                    <span class="h-5 w-[2px] rounded-full bg-[var(--docs-primary)]" />
                    <span>{{ article?.title }}</span>
                  </div>
                  <div class="pl-5 text-[var(--docs-muted)]">Something</div>
                  <div class="pl-5 text-[var(--docs-muted)]">or</div>
                  <div class="pl-5 text-[var(--docs-muted)]">other</div>
                </div>
              </div>

              <div class="overflow-hidden rounded-xl bg-gradient-to-br from-[var(--docs-primary)] to-[#d97b7b] p-[1px]">
                <div class="rounded-[11px] bg-[var(--docs-primary)]/95 p-5">
                  <div class="text-xl font-bold text-white">
                    Like this Demo?
                  </div>

                  <div class="mt-2 text-sm text-white/85">
                    Check out some of the creator's other projects
                  </div>

                  <button
                    type="button"
                    class="mt-5 w-full rounded-md bg-white px-4 py-2.5 text-xs font-bold uppercase tracking-[0.22em] text-[var(--docs-primary)]"
                  >
                    Visit
                  </button>
                </div>
              </div>
            </aside>
          </div>
        </main>
      </div>

      <div class="border-l border-[var(--docs-border)] bg-[var(--docs-bg)]" />
    </div>
  </div>
</template>
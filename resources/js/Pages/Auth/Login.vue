<script setup>
import { useForm } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

function submit() {
    form.post(route('login.store'))
}

const theme = ref('dark')

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
})
</script>

<template>
    <div class="min-h-screen flex items-center justify-center p-6
              bg-[var(--docs-bg)] text-[var(--docs-text)]">

        <button @click="toggleTheme" class="absolute top-6 right-6 text-sm px-3 py-1.5 rounded-lg
             border border-[var(--docs-border)]
             bg-[var(--docs-panel-2)]
             hover:bg-[var(--docs-hover)]">
            {{ theme === 'dark' ? 'Light' : 'Dark' }}
        </button>

        <div class="w-full max-w-sm">

            <div class="mb-6 text-center">
                <div class="text-2xl font-bold tracking-tight">
                    Welcome back
                </div>
                <div class="mt-1 text-sm text-[var(--docs-muted)]">
                    Access the admin dashboard
                </div>
            </div>

            <div class="rounded-2xl border border-[var(--docs-border)]
                  bg-[var(--docs-panel)]
                  p-6 shadow-[0_0_0_1px_rgba(255,255,255,0.02)_inset]">

                <form class="space-y-5" @submit.prevent="submit">

                    <div>
                        <label class="block text-xs uppercase tracking-wider mb-1 text-[var(--docs-muted)]">
                            Email
                        </label>

                        <input v-model="form.email" type="email" autocomplete="email" class="w-full rounded-lg border border-[var(--docs-border-strong)]
                     bg-[var(--docs-panel-2)]
                     px-3 py-2 text-sm
                     outline-none
                     focus:border-[var(--docs-primary)]" />

                        <div v-if="form.errors.email" class="mt-1 text-xs text-red-500">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider mb-1 text-[var(--docs-muted)]">
                            Password
                        </label>

                        <input v-model="form.password" type="password" autocomplete="current-password" class="w-full rounded-lg border border-[var(--docs-border-strong)]
                     bg-[var(--docs-panel-2)]
                     px-3 py-2 text-sm
                     outline-none
                     focus:border-[var(--docs-primary)]" />

                        <div v-if="form.errors.password" class="mt-1 text-xs text-red-500">
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-sm text-[var(--docs-muted)]">
                        <input v-model="form.remember" type="checkbox"
                            class="rounded border-[var(--docs-border-strong)] bg-transparent" />
                        Remember me
                    </label>

                    <button type="submit" :disabled="form.processing" class="w-full rounded-lg
                   bg-gradient-to-r from-[var(--docs-secondary)] to-[var(--docs-primary)]
                   px-4 py-2.5 text-sm font-semibold text-white
                   disabled:opacity-60">
                        Login
                    </button>

                </form>
            </div>

        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post(route('login.store'))
}
</script>

<template>
  <div class="min-h-screen bg-zinc-50 flex items-center justify-center p-6">
    <div class="w-full max-w-sm rounded border border-zinc-200 bg-white p-6">
      <div class="text-lg font-semibold">Login</div>
      <div class="mt-1 text-sm text-zinc-600">Access the admin dashboard.</div>

      <form class="mt-6 space-y-4" @submit.prevent="submit">
        <div>
          <label class="block text-sm font-medium text-zinc-700">Email</label>
          <input
            v-model="form.email"
            type="email"
            autocomplete="email"
            class="mt-1 w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none"
          />
          <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">
            {{ form.errors.email }}
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-zinc-700">Password</label>
          <input
            v-model="form.password"
            type="password"
            autocomplete="current-password"
            class="mt-1 w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none"
          />
          <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">
            {{ form.errors.password }}
          </div>
        </div>

        <label class="flex items-center gap-2 text-sm text-zinc-700">
          <input v-model="form.remember" type="checkbox" class="rounded border-zinc-300" />
          Remember me
        </label>

        <button
          type="submit"
          :disabled="form.processing"
          class="w-full rounded bg-zinc-900 px-3 py-2 text-sm font-medium text-white disabled:opacity-60"
        >
          Login
        </button>
      </form>
    </div>
  </div>
</template>
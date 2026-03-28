<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, onMounted } from 'vue'

const media = ref([])
const loading = ref(true)

async function load() {
    loading.value = true
    const res = await fetch(route('media.list'))
    const data = await res.json()
    media.value = data.media
    loading.value = false
}

async function upload(e) {
    const file = e.target.files[0]
    if (!file) return

    const formData = new FormData()
    formData.append('file', file)

    const res = await fetch(route('media.store'), {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })

    const data = await res.json()

    media.value.unshift(data)
}

onMounted(load)
</script>

<template>
    <AdminLayout>
        <div class="space-y-6">

            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold">Media Library</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Upload and reuse images across articles
                    </p>
                </div>

                <label class="cursor-pointer bg-black text-white px-4 py-2 rounded dark:bg-white dark:text-black">
                    Upload
                    <input type="file" class="hidden" @change="upload" />
                </label>
            </div>

            <div v-if="loading" class="text-sm text-zinc-500">
                Loading...
            </div>

            <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">

                <div v-for="m in media" :key="m.id"
                    class="group border rounded-lg overflow-hidden bg-white dark:bg-zinc-900 dark:border-zinc-800">
                    <img :src="m.url" class="w-full h-32 object-cover" />

                    <div class="p-2 text-xs text-zinc-500 truncate">
                        {{ m.url.split('/').pop() }}
                    </div>

                </div>

                <div v-if="media.length === 0" class="col-span-full text-center text-zinc-500">
                    No media yet
                </div>

            </div>

        </div>
    </AdminLayout>
</template>

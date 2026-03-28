<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import AdminLayout from '@/Layouts/AdminLayout.vue'


const json = ref("");

function submit() {
    router.post(route("admin.import"), {
        json: json.value,
    });
}
</script>

<template>
    <AdminLayout>
        <div class="p-6 max-w-4xl">
            <h1 class="text-2xl font-bold mb-4">
                Import Categories & Articles
            </h1>

            <textarea v-model="json" class="w-full h-80 p-3 border rounded-lg font-mono text-sm"
                placeholder="Paste JSON here..."></textarea>

            <div class="mt-4">
                <button @click="submit" class="bg-black text-white px-5 py-2 rounded-lg">
                    Import
                </button>
            </div>
        </div>
    </AdminLayout>
</template>

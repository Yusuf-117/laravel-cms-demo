<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
</script>

<template>
    <AdminLayout>
        <div class="space-y-6">
            <div
                class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-950 w-full max-w-5xl mx-auto"
            >
                <h1 class="text-2xl font-semibold">
                    Welcome to the Admin Dashboard
                </h1>

                <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">
                    This is a demo CMS backend for managing a knowledge base.
                    You can browse categories, articles, and media to see how
                    content is structured and managed.
                </p>
                <br />
                <h2 class="text-lg font-semibold">Roles</h2>

                <div
                    class="mt-3 space-y-2 text-sm text-zinc-600 dark:text-zinc-400"
                >
                    <p>
                        <span
                            class="font-medium text-zinc-900 dark:text-zinc-100"
                            >Viewer:</span
                        >
                        (You're most likley logged in as this one) Read-only
                        access. You can explore the admin interface but cannot
                        create, edit, or delete anything.
                    </p>

                    <p>
                        <span
                            class="font-medium text-zinc-900 dark:text-zinc-100"
                            >Admin:</span
                        >
                        Full access to manage categories, articles, and media.
                    </p>
                </div>
                <br />
                <h2 class="text-lg font-semibold">Demo Notes</h2>
                <br />
                <b
                    >As this is just a demo, there hasn't been too much thought
                    put into design or UX flaws. It is simply a POC</b
                >

                <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">
                    Feel free to click around and explore. The interface
                    reflects a real working CMS, and if you were logged in as an
                    admin, you would be able to create, edit, and manage all
                    content from here.
                </p>
            </div>
        </div>
    </AdminLayout>
</template>

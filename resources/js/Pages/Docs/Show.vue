<script setup>
import DocsLayout from "@/Layouts/DocsLayout.vue";

defineProps({
    article: Object,
    categories: Array,
});
</script>

<template>
    <DocsLayout :categories="categories">
        <div
            class="rounded-2xl border border-[var(--docs-border)] bg-[var(--docs-panel)] p-8 shadow-[0_0_0_1px_rgba(255,255,255,0.02)_inset]"
        >
            <div
                class="prose max-w-none dark:prose-invert prose-headings:text-[var(--docs-text)] prose-p:text-[var(--docs-text)] prose-li:text-[var(--docs-text)] prose-strong:text-[var(--docs-text)] prose-em:text-[var(--docs-text)] prose-a:text-[var(--docs-primary)] prose-code:text-[var(--docs-secondary)] prose-blockquote:text-[var(--docs-muted)] prose-blockquote:border-[var(--docs-primary)]"
                v-html="article.content"
            />
        </div>
    </DocsLayout>
</template>

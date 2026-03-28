<script setup>
import { onMounted, nextTick, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import DocsLayout from "@/Layouts/DocsLayout.vue";

import hljs from "highlight.js";
import "highlight.js/styles/github-dark.css";

defineProps({
    article: Object,
    categories: Array,
});

const page = usePage();

function highlight() {
    document.querySelectorAll("pre code").forEach((block) => {
        hljs.highlightElement(block);
    });
}

onMounted(async () => {
    await nextTick();
    highlight();
});

watch(
    () => page.props.article,
    async () => {
        await nextTick();
        highlight();
    }
);
</script>

<template>
    <DocsLayout :categories="categories">
        <div
            class="rounded-2xl border border-[var(--docs-border)] bg-[var(--docs-panel)] p-8 shadow-[0_0_0_1px_rgba(255,255,255,0.02)_inset]">
            <div class="prose max-w-none dark:prose-invert prose-headings:text-[var(--docs-text)] prose-p:text-[var(--docs-text)] prose-li:text-[var(--docs-text)] prose-strong:text-[var(--docs-text)] prose-em:text-[var(--docs-text)] prose-a:text-[var(--docs-primary)] prose-code:text-[var(--docs-secondary)] prose-blockquote:text-[var(--docs-muted)] prose-blockquote:border-[var(--docs-primary)]"
                v-html="article.content" />

            <a v-for="a in article.attachments" :key="a.id" :href="a.media.url" target="_blank"
                class="group flex items-center gap-3 rounded-lg border border-[var(--docs-border)] bg-[var(--docs-panel-2)] px-4 py-3 cursor-pointer transition hover:bg-[var(--docs-hover)]">
                <span class="text-xs px-2 py-1 rounded bg-[var(--docs-border)]">
                    {{
                        a.media.original_name
                            ?.split(".")
                            .pop()
                            ?.toUpperCase() || "FILE"
                    }}
                </span>
                <span class="text-sm truncate flex-1">
                    {{ a.label || a.media.original_name }}
                </span>
                <svg class="h-4 w-4 text-[var(--docs-muted)] transition group-hover:text-[var(--docs-text)]"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M3 14.75A2.75 2.75 0 005.75 17.5h8.5A2.75 2.75 0 0017 14.75v-.5a.75.75 0 00-1.5 0v.5c0 .69-.56 1.25-1.25 1.25h-8.5c-.69 0-1.25-.56-1.25-1.25v-.5a.75.75 0 00-1.5 0v.5z" />
                    <path
                        d="M10.75 3.75a.75.75 0 00-1.5 0v6.69L7.53 8.72a.75.75 0 10-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V3.75z" />
                </svg>
            </a>
        </div>
    </DocsLayout>
</template>

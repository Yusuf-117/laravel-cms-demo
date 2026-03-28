<script setup>
import { onMounted, nextTick, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import DocsLayout from "@/Layouts/DocsLayout.vue";
import { ArrowDownTrayIcon } from '@heroicons/vue/20/solid'

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
                <ArrowDownTrayIcon class="h-4 w-4 text-[var(--docs-muted)] transition group-hover:text-[var(--docs-text)]"/>
            </a>
        </div>
    </DocsLayout>
</template>

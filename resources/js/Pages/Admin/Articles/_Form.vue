<script setup>
import { ref, watch, computed } from "vue";
import Editor from "@/Components/Editor.vue";

const props = defineProps({
    form: Object,
    categories: Array,
    tags: {
        type: Array,
        default: () => [],
    },
    submit: Function,
    isEdit: Boolean,
});

const tagInput = ref("");

const selectedTags = ref(
    (props.tags || []).filter(t =>
        (props.form.tags || []).includes(t.id)
    )
);

const suggestions = computed(() => {
    if (!tagInput.value) return [];

    return (props.tags || [])
        .filter(t =>
            t.name.toLowerCase().includes(tagInput.value.toLowerCase())
        )
        .slice(0, 5);
});

function addTag(tag) {
    const value = typeof tag === "string" ? tag : tag.name;

    const existing = (props.tags || []).find(
        (t) => t.name.toLowerCase() === value.toLowerCase()
    );

    const finalTag = existing || {
        id: value.toLowerCase(),
        name: value,
    };

    if (!selectedTags.value.find(t => t.name === finalTag.name)) {
        selectedTags.value.push(finalTag);
    }

    tagInput.value = "";
}

function removeTag(id) {
    selectedTags.value = selectedTags.value.filter(t => t.id !== id);
}

watch(selectedTags, () => {
    props.form.tags = selectedTags.value.map(t => t.id);
}, { deep: true });

const content = ref(props.form.content || "<p></p>");

watch(content, (val) => {
    props.form.content = val;
});

watch(
    () => props.form.content,
    (val) => {
        if (!val) return;
        if (val === content.value) return;
        content.value = val;
    }
);
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input v-model="form.title" class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Slug</label>
            <input v-model="form.slug" class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Category</label>
            <select v-model="form.category_id" class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900">
                <option value="">Select</option>
                <option v-for="c in categories" :key="c.id" :value="c.id">
                    {{ c.name }}
                </option>
            </select>
        </div>

        <div class="relative">
            <label class="block text-sm font-medium mb-1">Tags</label>

            <div class="flex flex-wrap gap-2 mb-2">
                <span
                    v-for="t in selectedTags"
                    :key="t.id"
                    class="px-2 py-1 bg-zinc-200 dark:bg-zinc-700 rounded text-xs flex items-center gap-1"
                >
                    {{ t.name }}
                    <button type="button" @click="removeTag(t.id)">×</button>
                </span>
            </div>

            <input
                v-model="tagInput"
                @keydown.enter.prevent="addTag(tagInput)"
                placeholder="Type to search or create..."
                class="w-full border px-3 py-2 rounded dark:bg-zinc-900"
            />

            <div v-if="suggestions.length"
                class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-900 border rounded shadow">

                <div
                    v-for="s in suggestions"
                    :key="s.id"
                    @click="addTag(s)"
                    class="px-3 py-2 text-sm cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800"
                >
                    {{ s.name }}
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select v-model="form.status" class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Content</label>
            <Editor v-model="content" />
        </div>

        <div>
            <button class="bg-black text-white px-5 py-2 rounded-lg dark:bg-white dark:text-black">
                {{ isEdit ? "Update" : "Create" }}
            </button>
        </div>

    </form>
</template>
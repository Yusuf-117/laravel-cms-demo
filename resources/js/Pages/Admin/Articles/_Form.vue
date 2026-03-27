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

if (!props.form.attachments) {
    props.form.attachments = [];
}
/* ---------------- TAGS ---------------- */

const tagInput = ref("");

const selectedTags = ref(
    (props.tags || []).filter((t) => (props.form.tags || []).includes(t.id))
);

const suggestions = computed(() => {
    if (!tagInput.value) return [];

    return (props.tags || [])
        .filter((t) =>
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

    if (!selectedTags.value.find((t) => t.name === finalTag.name)) {
        selectedTags.value.push(finalTag);
    }

    tagInput.value = "";
}

function removeTag(id) {
    selectedTags.value = selectedTags.value.filter((t) => t.id !== id);
}

watch(
    selectedTags,
    () => {
        props.form.tags = selectedTags.value.map((t) => t.id);
    },
    { deep: true }
);

/* ---------------- CONTENT ---------------- */

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

/* ---------------- ATTACHMENTS ---------------- */

const attachments = ref(props.form.attachments || []);
const showAttachmentPicker = ref(false);
const mediaLibrary = ref([]);

watch(
    attachments,
    () => {
        props.form.attachments = attachments.value.map((a, i) => ({
            media_id: a.media_id,
            label: a.label,
            sort_order: i,
        }));
    },
    { deep: true, immediate: true }
);

async function openAttachments() {
    showAttachmentPicker.value = true;

    const res = await fetch(route("media.list"));
    const data = await res.json();

    mediaLibrary.value = data.media;
}

function addAttachment(m) {
    attachments.value.push({
        media_id: m.id,
        url: m.url,
        name: m.name,
        label: "",
    });
}

function removeAttachment(index) {
    attachments.value.splice(index, 1);
}

async function uploadAttachmentFile(e) {
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
    mediaLibrary.value.unshift(data)
    addAttachment(data)
}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <!-- Title -->
        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input
                v-model="form.title"
                class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900"
            />
        </div>

        <!-- Slug -->
        <div>
            <label class="block text-sm font-medium mb-1">Slug</label>
            <input
                v-model="form.slug"
                class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900"
            />
        </div>

        <!-- Category -->
        <div>
            <label class="block text-sm font-medium mb-1">Category</label>
            <select
                v-model="form.category_id"
                class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900"
            >
                <option value="">Select</option>
                <option v-for="c in categories" :key="c.id" :value="c.id">
                    {{ c.name }}
                </option>
            </select>
        </div>

        <!-- Tags -->
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

            <div
                v-if="suggestions.length"
                class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-900 border rounded shadow"
            >
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

        <!-- Status -->
        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select
                v-model="form.status"
                class="w-full rounded-lg border px-4 py-2 dark:bg-zinc-900"
            >
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </div>

        <!-- Content -->
        <div>
            <label class="block text-sm font-medium mb-2">Content</label>
            <Editor v-model="content" />
        </div>

        <!-- Attachment -->
        <div>
            <label class="block text-sm font-medium mb-2">Attachments</label>

            <div class="flex flex-wrap gap-3 mb-3">
                <div
                    v-for="(a, i) in attachments"
                    :key="i"
                    class="flex items-center gap-2 px-3 py-2 border rounded bg-zinc-100 dark:bg-zinc-800"
                >
                    <span
                        class="text-xs px-2 py-1 rounded bg-zinc-300 dark:bg-zinc-700"
                    >
                        {{ a.name?.split(".").pop()?.toUpperCase() || "FILE" }}
                    </span>

                    <input
                        v-model="a.label"
                        placeholder="Label"
                        class="text-sm bg-transparent outline-none w-28"
                    />

                    <button type="button" @click="removeAttachment(i)">
                        ✕
                    </button>
                </div>
            </div>

            <button
                type="button"
                @click="openAttachments"
                class="px-3 py-2 rounded bg-black text-white dark:bg-white dark:text-black"
            >
                Add Attachment
            </button>
        </div>

        <!-- modal for attachments -->
        <div
            v-if="showAttachmentPicker"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div
                class="bg-white dark:bg-zinc-900 rounded-xl p-6 w-full max-w-3xl max-h-[80vh] overflow-auto"
            >
                <div class="flex justify-between mb-4">
                    <h2 class="text-lg font-semibold">Select Attachment</h2>
                    <button @click="showAttachmentPicker = false">✕</button>
                </div>
                <div class="space-y-2 mb-5">
                    <label class="flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 text-white rounded-xl cursor-pointer hover:bg-indigo-700 transition shadow-md">
                        <span>Upload File</span>
                        <input type="file" class="hidden" @change="uploadAttachmentFile">
                    </label>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div
                        v-for="m in mediaLibrary"
                        :key="m.id"
                        class="cursor-pointer border rounded p-3 hover:opacity-80 flex items-center gap-3"
                        @click="addAttachment(m)"
                    >
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded bg-zinc-200 dark:bg-zinc-800 text-xs"
                        >
                            <template v-if="m.mime?.startsWith('image/')">
                                <img
                                    :src="m.url"
                                    class="w-full h-full object-cover rounded"
                                />
                            </template>

                            <template v-else-if="m.mime?.includes('pdf')">
                                <span class="px-4">PDF</span>
                            </template>

                            <template v-else-if="m.mime?.includes('zip')">
                                 <span class="px-4">ZIP</span>
                            </template>

                            <template v-else-if="m.mime?.includes('word')">
                                 <span class="px-4">DOC</span>
                            </template>

                            <template v-else>  <span class="px-4">FILE</span> </template>
                        </div>

                        <div class="text-sm truncate">
                            {{ m.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <button
                class="bg-black text-white px-5 py-2 rounded-lg dark:bg-white dark:text-black"
            >
                {{ isEdit ? "Update" : "Create" }}
            </button>
        </div>
    </form>
</template>

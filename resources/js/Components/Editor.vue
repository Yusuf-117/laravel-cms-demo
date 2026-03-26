<script setup>
import { computed, watch, ref } from 'vue'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['update:modelValue'])

const showMedia = ref(false)
const media = ref([])

const initialContent = computed(() => {
  return props.modelValue?.trim()
    ? props.modelValue
    : '<p></p>'
})

const editor = useEditor({
  extensions: [
    StarterKit,
    Image,
  ],
  content: initialContent.value,
  editorProps: {
    attributes: {
      class: 'tiptap-editor prose max-w-none min-h-[350px] p-4 focus:outline-none dark:prose-invert',
    },
  },
  onUpdate: ({ editor }) => {
    const html = editor.getHTML()

    if (html !== props.modelValue) {
      emit('update:modelValue', html)
    }
  },
})

watch(
  () => props.modelValue,
  (newValue) => {
    if (!editor.value) return

    const currentValue = editor.value.getHTML()
    const incomingValue = newValue?.trim() ? newValue : '<p></p>'

    if (incomingValue === currentValue) return

    editor.value.commands.setContent(incomingValue, {
      emitUpdate: false,
    })
  }
)

function openMedia() {
  showMedia.value = true

  fetch(route('media.list'))
  .then(res => res.json())
  .then(data => {
    media.value = data.media
  })
}

function insertImage(url) {
  editor.value.chain().focus().setImage({ src: url }).run()
  showMedia.value = false
}

async function upload(e) {
    console.log("ran");
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
</script>

<template>
  <div class="border rounded-xl overflow-hidden bg-white dark:bg-zinc-900 dark:border-zinc-700">

    <!-- HEADER -->
    <div class="flex justify-between items-center px-3 py-2 border-b dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
      <span class="text-xs text-zinc-500">Rich editor</span>

      <button
        type="button"
        @click="openMedia"
        class="text-sm px-3 py-1 rounded bg-black text-white dark:bg-white dark:text-black"
      >
        Insert Image
      </button>
    </div>

    <!-- EDITOR -->
    <EditorContent v-if="editor" :editor="editor" />

    <!-- MEDIA MODAL -->
    <div v-if="showMedia" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

      <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 w-full max-w-3xl max-h-[80vh] overflow-auto">

        <div class="flex justify-between mb-4">
          <h2 class="text-lg font-semibold">Select Image</h2>
          <button @click="showMedia = false">✕</button>
        </div>

        <div class="space-y-2 mb-5">
            <label class="flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 text-white rounded-xl cursor-pointer hover:bg-indigo-700 transition shadow-md">
                <span>Select File</span>
                <input type="file" class="hidden" @change="upload">
            </label>

            <p class="text-sm text-gray-500" v-if="fileName">
                {{ fileName }}
            </p>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div
            v-for="m in media"
            :key="m.id"
            class="cursor-pointer border rounded overflow-hidden hover:opacity-80"
            @click="insertImage(m.url)"
          >
            <img :src="m.url" class="w-full h-32 object-cover" />
          </div>
        </div>

      </div>
    </div>

  </div>
</template>
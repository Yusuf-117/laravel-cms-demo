<script setup>
import { computed, watch } from 'vue'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['update:modelValue'])

const initialContent = computed(() => {
  return props.modelValue?.trim()
    ? props.modelValue
    : '<p></p>'
})

const editor = useEditor({
  extensions: [StarterKit],
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
</script>

<template>
  <div class="border rounded-xl overflow-hidden bg-white dark:bg-zinc-900 dark:border-zinc-700">
    <EditorContent v-if="editor" :editor="editor" />
  </div>
</template>
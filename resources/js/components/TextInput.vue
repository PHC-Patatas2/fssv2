<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const props = defineProps({
    id: String,
    ariaLabel: String,
    ariaDescribedby: String,
    type: {
        type: String,
        default: 'text',
    },
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        :id="id"
        :type="type"
        :aria-label="ariaLabel"
        :aria-describedby="ariaDescribedby"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200 hover:border-indigo-400 hover:ring-2 hover:ring-indigo-100"
        v-model="model"
        ref="input"
    />
</template>

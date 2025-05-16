<script setup>
defineProps({
    value: {
        type: String,
    },
    forId: {
        type: String,
        default: undefined,
    },
});
</script>

<template>
    <label :for="forId" class="block text-sm font-medium text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

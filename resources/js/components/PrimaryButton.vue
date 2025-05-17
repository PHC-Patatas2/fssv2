<script setup>
const props = defineProps({
  type: { type: String, default: 'submit' },
  disabled: { type: Boolean, default: false },
});
</script>

<template>
  <button
    :type="props.type"
    :disabled="props.disabled"
    class="inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
  >
    <slot />
  </button>
</template>

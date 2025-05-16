<template>
  <transition name="fade">
    <div v-if="show" class="fixed top-6 left-1/2 z-50 -translate-x-1/2 bg-green-100 border border-green-400 text-green-800 px-6 py-3 rounded shadow-lg flex items-center gap-2 min-w-[250px] max-w-[90vw]">
      <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
      <span>{{ message }}</span>
      <button @click="$emit('close')" class="ml-auto text-green-700 hover:text-green-900 focus:outline-none">&times;</button>
    </div>
  </transition>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
const props = defineProps({
  message: String,
  duration: { type: Number, default: 4000 },
  show: Boolean
});
const emit = defineEmits(['close']);
let timer = null;

watch(() => props.show, (val) => {
  if (val && props.duration > 0) {
    clearTimeout(timer);
    timer = setTimeout(() => emit('close'), props.duration);
  }
});

onMounted(() => {
  if (props.show && props.duration > 0) {
    timer = setTimeout(() => emit('close'), props.duration);
  }
});
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

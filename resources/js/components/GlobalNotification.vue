<template>
  <transition name="fade">
    <div v-if="show" :class="['fixed z-50 top-6 left-1/2 -translate-x-1/2 px-6 py-3 rounded shadow-lg flex items-center gap-2 min-w-[250px] max-w-[90vw]', colorClass]">
      <i :class="iconClass"></i>
      <span>{{ message }}</span>
      <button @click="$emit('close')" class="ml-auto font-bold focus:outline-none">&times;</button>
    </div>
  </transition>
</template>

<script setup>
const props = defineProps({
  message: String,
  type: { type: String, default: 'success' }, // success, error, info, warning
  show: Boolean
});
const emit = defineEmits(['close']);

const colorClass = {
  success: 'bg-green-100 border border-green-400 text-green-800',
  error: 'bg-red-100 border border-red-400 text-red-800',
  info: 'bg-blue-100 border border-blue-400 text-blue-800',
  warning: 'bg-yellow-100 border border-yellow-400 text-yellow-800',
}[props.type] || 'bg-green-100 border border-green-400 text-green-800';

const iconClass = {
  success: 'fas fa-check-circle text-green-500',
  error: 'fas fa-times-circle text-red-500',
  info: 'fas fa-info-circle text-blue-500',
  warning: 'fas fa-exclamation-triangle text-yellow-500',
}[props.type] || 'fas fa-check-circle text-green-500';
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

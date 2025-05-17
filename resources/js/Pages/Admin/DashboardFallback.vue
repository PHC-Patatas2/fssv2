<template>
  <AdminLayout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
      <!-- Removed welcome, coming soon, and logout -->
    </div>
  </AdminLayout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
const csrfToken = usePage().props.csrf_token;
</script>

<style scoped>
/* Add any component-specific styles here */
</style>

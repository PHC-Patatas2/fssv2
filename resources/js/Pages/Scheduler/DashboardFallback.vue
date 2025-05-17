<template>
  <SchedulerLayout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
      <!-- Removed welcome, coming soon, and logout -->
    </div>
  </SchedulerLayout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import SchedulerLayout from '@/Layouts/SchedulerLayout.vue';
const csrfToken = usePage().props.csrf_token;
</script>

<template>
  <AdminLayout>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-clipboard-list text-blue-400" aria-hidden="true"></i> System Logs
      </h1>
      <div class="bg-white rounded shadow p-4">
        <p>
          <i class="fas fa-info-circle text-gray-400 mr-2" aria-hidden="true"></i>View system logs here.
        </p>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>

<style scoped>
h1:focus {
  outline: none;
}
</style>

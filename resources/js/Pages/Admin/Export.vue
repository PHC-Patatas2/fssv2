<template>
  <AdminLayout>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-file-export text-blue-400" aria-hidden="true"></i> Export Data
      </h1>
      <div class="bg-white rounded shadow p-4 flex flex-col gap-4">
        <a href="/admin/schedules/export/csv" class="bg-green-500 text-white px-4 py-2 rounded">Export Schedules (CSV)</a>
        <a href="/admin/schedules/export/pdf" class="bg-green-500 text-white px-4 py-2 rounded">Export Schedules (PDF)</a>
        <a href="/admin/system-report/export/pdf" class="bg-purple-600 text-white px-4 py-2 rounded">Export System Report (PDF)</a>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>

<template>
  <AdminLayout>
    <div class="px-2 sm:px-0">
      <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Quick Stats -->
        <div class="bg-white rounded shadow p-6 flex flex-col items-center w-full min-w-0">
          <span class="text-4xl font-bold text-blue-600">42</span>
          <span class="text-gray-600 mt-2">Active Schedules</span>
        </div>
        <div class="bg-white rounded shadow p-6 flex flex-col items-center w-full min-w-0">
          <span class="text-4xl font-bold text-green-600">15</span>
          <span class="text-gray-600 mt-2">Pending User Approvals</span>
        </div>
        <div class="bg-white rounded shadow p-6 flex flex-col items-center w-full min-w-0">
          <span class="text-4xl font-bold text-yellow-600">3</span>
          <span class="text-gray-600 mt-2">System Alerts</span>
        </div>
        <!-- Quick Actions -->
        <div class="bg-white rounded shadow p-6 col-span-1 md:col-span-2 flex flex-col w-full min-w-0">
          <h2 class="font-semibold mb-2">Quick Actions</h2>
          <div class="flex flex-wrap gap-2 w-full">
            <NavLink :href="route('admin.create-schedule')" :class="navActive('/admin/create-schedule') + ' flex-1 min-w-[140px] text-center'">Create Schedule</NavLink>
            <NavLink :href="route('admin.manage-schedules')" :class="navActive('/admin/manage-schedules') + ' flex-1 min-w-[140px] text-center'">Manage Schedules</NavLink>
            <NavLink :href="route('admin.records')" :class="navActive('/admin/records') + ' flex-1 min-w-[140px] text-center'">Records & Data</NavLink>
            <NavLink :href="route('admin.system-logs')" :class="navActive('/admin/system-logs') + ' flex-1 min-w-[140px] text-center'">System Logs</NavLink>
          </div>
        </div>
        <!-- System Logs Preview -->
        <div class="bg-white rounded shadow p-6 col-span-1 xl:col-span-3 overflow-x-auto w-full min-w-0">
          <h2 class="font-semibold mb-2">Recent System Logs</h2>
          <ul class="text-sm text-gray-700 space-y-1 min-w-[300px]">
            <li>2025-05-16 09:00:01 - User JohnDoe created a new schedule.</li>
            <li>2025-05-16 08:45:12 - Exam schedule updated by Admin.</li>
            <li>2025-05-16 08:30:00 - User JaneSmith approved.</li>
          </ul>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import NavLink from '@/components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
function navActive(path) {
  return page.url.startsWith(path)
    ? 'font-bold text-blue-700 underline bg-blue-50'
    : 'text-gray-700';
}
</script>

<style scoped>
.bg-white {
  word-break: break-word;
}
@media (max-width: 640px) {
  .grid {
    gap: 1rem;
  }
  .flex.flex-wrap.gap-2.w-full {
    flex-direction: column;
    gap: 0.5rem;
  }
  .bg-white.rounded.shadow.p-6 {
    padding: 1rem;
  }
}
</style>

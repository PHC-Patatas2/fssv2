<template>
  <AdminLayout>
    <div>
      <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Example Tool: Quick Stats -->
        <div class="bg-white rounded shadow p-6 flex flex-col items-center">
          <span class="text-4xl font-bold text-blue-600">42</span>
          <span class="text-gray-600 mt-2">Active Schedules</span>
        </div>
        <div class="bg-white rounded shadow p-6 flex flex-col items-center">
          <span class="text-4xl font-bold text-green-600">15</span>
          <span class="text-gray-600 mt-2">Pending User Approvals</span>
        </div>
        <div class="bg-white rounded shadow p-6 flex flex-col items-center">
          <span class="text-4xl font-bold text-yellow-600">3</span>
          <span class="text-gray-600 mt-2">System Alerts</span>
        </div>
        <!-- Example Tool: Quick Links -->
        <div class="bg-white rounded shadow p-6 col-span-1 md:col-span-2 flex flex-col">
          <h2 class="font-semibold mb-2">Quick Actions</h2>
          <div class="flex flex-wrap gap-2">
            <NavLink :href="route('admin.create-schedule')">Create Schedule</NavLink>
            <NavLink :href="route('admin.manage-schedules')">Manage Schedules</NavLink>
            <NavLink :href="route('admin.records')">Records & Data</NavLink>
            <NavLink :href="route('admin.system-logs')">System Logs</NavLink>
          </div>
        </div>
        <!-- Example Tool: System Logs Preview -->
        <div class="bg-white rounded shadow p-6 col-span-1 xl:col-span-3">
          <h2 class="font-semibold mb-2">Recent System Logs</h2>
          <ul class="text-sm text-gray-700 space-y-1">
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
</script>

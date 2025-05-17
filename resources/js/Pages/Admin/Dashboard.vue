<template>
  <AdminLayout>
    <div class="px-2 sm:px-0">
      <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fas fa-tools text-blue-500" aria-hidden="true"></i> Admin Dashboard
      </h1>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Quick Stats -->
        <div class="bg-white rounded shadow p-6 flex flex-col items-center w-full min-w-0 transition-transform hover:shadow-lg hover:scale-[1.02] focus-within:ring-2 focus-within:ring-blue-200" tabindex="0" aria-label="Active Schedules">
          <i class="fas fa-calendar-alt text-blue-400 text-3xl mb-2" aria-hidden="true"></i>
          <span class="text-4xl font-bold text-blue-600">{{ stats.activeSchedules }}</span>
          <span class="text-gray-600 mt-2">Active Schedules</span>
        </div>
        <div class="bg-white rounded shadow p-6 flex flex-col items-center w-full min-w-0 transition-transform hover:shadow-lg hover:scale-[1.02] focus-within:ring-2 focus-within:ring-green-200" tabindex="0" aria-label="Pending User Approvals">
          <i class="fas fa-user-check text-green-400 text-3xl mb-2" aria-hidden="true"></i>
          <span class="text-4xl font-bold text-green-600">{{ stats.pendingApprovals }}</span>
          <span class="text-gray-600 mt-2">Pending User Approvals</span>
        </div>
        <div class="bg-white rounded shadow p-6 flex flex-col items-center w-full min-w-0 transition-transform hover:shadow-lg hover:scale-[1.02] focus-within:ring-2 focus-within:ring-yellow-200" tabindex="0" aria-label="System Alerts">
          <i class="fas fa-exclamation-triangle text-yellow-400 text-3xl mb-2" aria-hidden="true"></i>
          <span class="text-4xl font-bold text-yellow-600">{{ stats.systemAlerts }}</span>
          <span class="text-gray-600 mt-2">System Alerts</span>
        </div>
        <!-- Quick Actions -->
        <div class="bg-white rounded shadow p-6 col-span-1 md:col-span-3 flex flex-col w-full min-w-0">
          <h2 class="font-semibold mb-2 flex items-center gap-2 border-l-4 border-blue-200 pl-2 bg-blue-50/40 py-1 rounded text-lg" id="quick-actions-header">
            <i class="fas fa-bolt text-blue-400" aria-hidden="true"></i> Quick Actions
          </h2>
          <div class="flex flex-wrap gap-2 w-full animate-fade-in" role="group" aria-labelledby="quick-actions-header">
            <NavLink :href="route('admin.create-schedule')" class="bg-blue-500 text-white px-4 py-2 rounded flex-1 min-w-[140px] text-center transition-transform hover:scale-105 focus:ring-2 focus:ring-blue-300" title="Create a new schedule" aria-label="Create Schedule">
              <i class="fas fa-calendar-plus mr-2" aria-hidden="true"></i> Create Schedule
            </NavLink>
            <NavLink :href="route('admin.manage-schedules')" class="bg-green-500 text-white px-4 py-2 rounded flex-1 min-w-[140px] text-center transition-transform hover:scale-105 focus:ring-2 focus:ring-green-300" title="Manage schedules" aria-label="Manage Schedules">
              <i class="fas fa-tasks mr-2" aria-hidden="true"></i> Manage Schedules
            </NavLink>
            <NavLink :href="route('admin.records')" class="bg-yellow-500 text-white px-4 py-2 rounded flex-1 min-w-[140px] text-center transition-transform hover:scale-105 focus:ring-2 focus:ring-yellow-300" title="Export schedules" aria-label="Export Schedules">
              <i class="fas fa-file-export mr-2" aria-hidden="true"></i> Export Schedules
            </NavLink>
            <NavLink :href="route('admin.records')" class="bg-purple-500 text-white px-4 py-2 rounded flex-1 min-w-[140px] text-center transition-transform hover:scale-105 focus:ring-2 focus:ring-purple-300" title="Import schedules" aria-label="Import Schedules">
              <i class="fas fa-file-import mr-2" aria-hidden="true"></i> Import Schedules
            </NavLink>
            <NavLink :href="route('admin.system-logs')" class="bg-gray-700 text-white px-4 py-2 rounded flex-1 min-w-[140px] text-center transition-transform hover:scale-105 focus:ring-2 focus:ring-gray-400" title="View system logs" aria-label="System Logs">
              <i class="fas fa-clipboard-list mr-2" aria-hidden="true"></i> System Logs
            </NavLink>
          </div>
        </div>
        <!-- Recent Activity -->
        <div class="bg-white rounded shadow p-6 col-span-1 xl:col-span-3 overflow-x-auto w-full min-w-0">
          <h2 class="font-semibold mb-2 flex items-center gap-2 border-l-4 border-blue-200 pl-2 bg-blue-50/40 py-1 rounded text-lg" id="recent-activity-header">
            <i class="fas fa-history text-blue-400" aria-hidden="true"></i> Recent Activity
          </h2>
          <ul class="text-sm text-gray-700 space-y-1 min-w-[300px]" aria-labelledby="recent-activity-header">
            <li v-for="log in recentActivity" :key="log.id" class="flex items-center gap-2">
              <i class="fas fa-user text-blue-400" aria-hidden="true"></i>
              <span>{{ log.created_at }} - {{ log.username }}: {{ log.description }}</span>
            </li>
          </ul>
        </div>
        <!-- Pending Approvals -->
        <div class="bg-white rounded shadow p-6 col-span-1 md:col-span-2 flex flex-col w-full min-w-0">
          <h2 class="font-semibold mb-2 flex items-center gap-2 border-l-4 border-blue-200 pl-2 bg-blue-50/40 py-1 rounded text-lg" id="pending-approvals-header">
            <i class="fas fa-user-clock text-blue-400" aria-hidden="true"></i> Pending User Approvals
          </h2>
          <ul class="text-sm text-gray-700 space-y-1 min-w-[300px]" aria-labelledby="pending-approvals-header">
            <li v-for="user in pendingApprovals" :key="user.email" class="flex items-center gap-2">
              <i class="fas fa-user text-gray-400" aria-hidden="true"></i>
              <span>{{ user.name }} ({{ user.email }}) - Awaiting approval</span>
            </li>
          </ul>
        </div>
        <!-- System Health -->
        <div class="bg-white rounded shadow p-6 flex flex-col items-center w-full min-w-0" tabindex="0" aria-label="System Health">
          <h2 class="font-semibold mb-2 flex items-center gap-2 border-l-4 border-blue-200 pl-2 bg-blue-50/40 py-1 rounded text-lg">
            <i class="fas fa-heartbeat text-blue-400" aria-hidden="true"></i> System Health
          </h2>
          <span class="flex items-center gap-2 text-green-600 font-bold">
            <i class="fas fa-check-circle text-green-500" aria-hidden="true"></i> {{ systemHealth }}
          </span>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { defineProps } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import NavLink from '@/components/NavLink.vue';

const props = defineProps({
  stats: Object,
  recentActivity: Array,
  pendingApprovals: Array,
  systemHealth: String,
});

// Demo: Show a notification when the dashboard loads
if (typeof window !== 'undefined' && window.$notify) {
  window.$notify('Welcome to the Admin Dashboard! 🎉', 'info');
}
</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: none; }
}
.animate-fade-in {
  animation: fade-in 0.7s cubic-bezier(0.4,0,0.2,1);
}
:focus {
  outline: none;
}
</style>

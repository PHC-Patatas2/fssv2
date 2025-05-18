<!-- All future edits will be made with full responsiveness in mind, using best practices for adaptive layouts, text, and components across all screen sizes. This includes:
// - Using responsive utility classes (e.g., Tailwind's sm:, md:, lg:, xl:)
// - Ensuring containers, cards, modals, and text adapt to small and large screens
// - Preventing overflow, overlap, and horizontal scroll
// - Using break-words, flex-wrap, and max-widths where needed
// - Testing all UI changes for mobile, tablet, and desktop
// This note serves as a persistent reminder for all future code changes. -->

<template>
  <AdminLayout>
    <div class="min-h-screen bg-gray-100 w-full">
      <div class="w-full max-w-4xl mx-auto px-2 sm:px-4 md:px-6 min-w-0">
        <!-- Responsive Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mt-8">
          <!-- Total Users Card -->
          <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center w-full min-w-0 overflow-hidden">
            <div class="text-2xl sm:text-3xl font-bold text-blue-600 break-words">{{ totalUsers ?? 0 }}</div>
            <div class="text-gray-700 mt-1 sm:mt-2 text-base sm:text-lg break-words">Total Users</div>
            <div class="flex flex-wrap gap-2 mt-2 text-xs sm:text-sm text-gray-500 justify-center w-full">
              <span>Admins: {{ adminCount ?? 0 }}</span>
              <span>Schedulers: {{ schedulerCount ?? 0 }}</span>
              <span>Teachers: {{ teacherCount ?? 0 }}</span>
              <span>Students: {{ studentCount ?? 0 }}</span>
            </div>
          </div>
          <!-- Pending Approvals Card -->
          <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center w-full min-w-0 overflow-hidden">
            <div class="text-2xl sm:text-3xl font-bold text-yellow-500 break-words">{{ pendingApprovals?.length ?? 0 }}</div>
            <div class="text-gray-700 mt-1 sm:mt-2 text-base sm:text-lg break-words">Pending User Approvals</div>
            <div class="flex flex-wrap gap-2 mt-2 text-xs sm:text-sm text-gray-500 justify-center w-full">
              <span v-if="(pendingApprovals?.length ?? 0) > 0" class="mt-3 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm sm:text-base transition cursor-pointer" @click="showApprovalsModal = true">Review</span>
            </div>
          </div>
          <!-- Active Schedules Card -->
          <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center w-full min-w-0 overflow-hidden">
            <div class="text-2xl sm:text-3xl font-bold text-green-600 break-words">{{ activeSchedules ?? 0 }}</div>
            <div class="text-gray-700 mt-1 sm:mt-2 text-base sm:text-lg break-words">Active Schedules</div>
            <div class="flex flex-wrap gap-2 mt-2 text-xs sm:text-sm text-gray-500 justify-center w-full">
              <span class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm sm:text-base transition cursor-pointer" @click="showSchedulesModal = true">View</span>
            </div>
          </div>
        </div>
        <!-- System Logs/Recent Activity (last 5 actions) -->
        <div class="w-full mt-8 min-w-0">
          <div class="bg-white rounded-xl shadow p-4 w-full min-w-0 overflow-x-auto">
            <h2 class="text-lg sm:text-xl font-bold mb-4 flex items-center gap-2 break-words text-center sm:text-left">
              <i class="fas fa-history text-blue-400" aria-hidden="true"></i>
              <span class="break-words">System Logs / Recent Activity</span>
            </h2>
            <ul class="break-words">
              <li v-for="log in recentActivity" :key="log.id" class="py-2 border-b last:border-b-0 hover:bg-gray-50 cursor-pointer text-xs sm:text-sm flex flex-wrap gap-x-2 gap-y-1">
                <span class="font-semibold break-words">{{ log.username }}</span>
                <span class="mx-1 text-gray-400">•</span>
                <span class="text-blue-600 break-words">{{ log.action }}</span>
                <span class="mx-1 text-gray-400">•</span>
                <span class="text-gray-700 break-words">{{ log.description }}</span>
                <span class="mx-1 text-gray-400">•</span>
                <span class="text-xs text-gray-500 break-words">{{ new Date(log.created_at).toLocaleString() }}</span>
              </li>
            </ul>
            <div v-if="recentActivity.length === 0" class="text-gray-500 text-center break-words">No recent activity.</div>
          </div>
        </div>
      </div>
      <!-- Modals -->
      <Modal :show="showApprovalsModal" @close="showApprovalsModal = false">
        <template #default>
          <div class="p-4 sm:p-6 w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl mx-auto bg-white rounded-xl shadow-lg overflow-x-auto">
            <h2 class="text-lg sm:text-xl font-bold mb-4 break-words text-center">Pending User Approvals</h2>
            <div v-if="pendingApprovals?.length === 0" class="text-gray-500 text-center break-words">No pending users.</div>
            <table v-else class="min-w-full divide-y divide-gray-200 mt-2 text-xs sm:text-sm">
              <thead>
                <tr>
                  <th class="px-2 sm:px-4 py-2 text-left break-words">Name</th>
                  <th class="px-2 sm:px-4 py-2 text-left break-words">Email</th>
                  <th class="px-2 sm:px-4 py-2 text-left break-words">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in pendingApprovals" :key="user.id">
                  <td class="px-2 sm:px-4 py-2 break-words">{{ user.name }}</td>
                  <td class="px-2 sm:px-4 py-2 break-words">{{ user.email }}</td>
                  <td class="px-2 sm:px-4 py-2 flex flex-wrap gap-2 break-words">
                    <form :action="route('admin.user-approvals.approve', user.id)" method="post">
                      <input type="hidden" name="_token" :value="csrfToken">
                      <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs sm:text-sm break-words">Approve</button>
                    </form>
                    <form :action="route('admin.user-approvals.decline', user.id)" method="post">
                      <input type="hidden" name="_token" :value="csrfToken">
                      <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs sm:text-sm break-words">Decline</button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </template>
      </Modal>
      <Modal :show="showSchedulesModal" @close="showSchedulesModal = false">
        <template #default>
          <div class="p-4 sm:p-6 w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl mx-auto bg-white rounded-xl shadow-lg overflow-x-auto">
            <h2 class="text-lg sm:text-xl font-bold mb-4 break-words text-center">Active Schedules</h2>
            <p class="text-gray-700 text-sm sm:text-base break-words text-center">Schedules management coming soon.</p>
          </div>
        </template>
      </Modal>
      <Modal :show="showLogModal" @close="showLogModal = false">
        <template #default>
          <div class="p-4 sm:p-6 w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl mx-auto bg-white rounded-xl shadow-lg overflow-x-auto">
            <h2 class="text-lg sm:text-xl font-bold mb-4 break-words text-center">Activity Log Details</h2>
            <div v-if="selectedLog">
              <div class="mb-2 break-words text-center"><b>User:</b> {{ selectedLog.username }}</div>
              <div class="mb-2 break-words text-center"><b>Action:</b> {{ selectedLog.action }}</div>
              <div class="mb-2 break-words text-center"><b>Description:</b> {{ selectedLog.description }}</div>
              <div class="mb-2 break-words text-center"><b>Entity Type:</b> {{ selectedLog.entity_type ?? '-' }}</div>
              <div class="mb-2 break-words text-center"><b>Entity ID:</b> {{ selectedLog.entity_id ?? '-' }}</div>
              <div class="mb-2 break-words text-center"><b>Date:</b> {{ new Date(selectedLog.created_at).toLocaleString() }}</div>
            </div>
          </div>
        </template>
      </Modal>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/components/Modal.vue';
const props = defineProps({
  totalUsers: Number,
  adminCount: Number,
  schedulerCount: Number,
  teacherCount: Number,
  studentCount: Number,
  pendingApprovals: Array,
  activeSchedules: Number,
  csrf_token: String,
  recentActivity: Array,
});
const csrfToken = props.csrf_token || usePage().props.csrf_token;
const showApprovalsModal = ref(false);
const showSchedulesModal = ref(false);
const showLogModal = ref(false);
const selectedLog = ref(null);
const scheduleForm = ref({
  title: '',
  date: '',
  time: '',
  room: '',
});
const userForm = ref({
  name: '',
  email: '',
  role: 'admin',
  password: '',
});
const roomForm = ref({
  name: '',
  description: '',
});
const exportForm = ref({
  type: 'schedules',
  format: 'csv',
});
function showLogDetails(log) {
  selectedLog.value = log;
  showLogModal.value = true;
}
function goToSettings() {
  router.visit('/admin/settings');
}
function submitCreateSchedule() {
  // TODO: Implement actual submission logic
  alert('Schedule created! (demo)');
  showCreateScheduleModal.value = false;
  scheduleForm.value = { title: '', date: '', time: '', room: '' };
}
function submitAddUser() {
  // TODO: Implement actual submission logic
  alert('User added! (demo)');
  showAddUserModal.value = false;
  userForm.value = { name: '', email: '', role: 'admin', password: '' };
}
function submitAddRoom() {
  // TODO: Implement actual submission logic
  alert('Room/resource added! (demo)');
  showAddRoomModal.value = false;
  roomForm.value = { name: '', description: '' };
}
function submitExport() {
  // TODO: Implement actual export logic
  alert('Export started! (demo)');
  showExportModal.value = false;
  exportForm.value = { type: 'schedules', format: 'csv' };
}
</script>

<style scoped>
/* Add any component-specific styles here */
</style>

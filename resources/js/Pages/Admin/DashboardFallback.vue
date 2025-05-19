<template>
  <AdminLayout>
    <div class="min-h-screen bg-gray-100 w-full">
      <div class="w-full max-w-4xl mx-auto px-2 sm:px-4 md:px-6 min-w-0">
        <!-- Responsive Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mt-8">
          <!-- Total Users Card -->
          <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-center items-center w-full min-w-0 overflow-hidden transition-transform duration-200 hover:shadow-2xl hover:-translate-y-1 hover:border-blue-200 border border-transparent cursor-pointer">
            <div class="flex flex-col items-center w-full">
              <div class="text-2xl sm:text-3xl font-bold text-blue-600 break-words">{{ totalUsers ?? 0 }}</div>
              <div class="text-gray-700 mt-1 sm:mt-2 text-base sm:text-lg break-words">Total Users</div>
              <button :class="modalButtonClass + ' bg-blue-600 text-white hover:bg-blue-700 w-full sm:w-auto text-center justify-center flex mt-6 disabled:opacity-60 disabled:cursor-not-allowed'" @click="showUsersModal = true" :disabled="!totalUsers">View</button>
            </div>
          </div>
          <!-- Pending Approvals Card -->
          <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-center items-center w-full min-w-0 overflow-hidden transition-transform duration-200 hover:shadow-2xl hover:-translate-y-1 hover:border-yellow-200 border border-transparent cursor-pointer">
            <div class="flex flex-col items-center w-full">
              <div class="text-2xl sm:text-3xl font-bold text-yellow-500 break-words">{{ pendingApprovals?.length ?? 0 }}</div>
              <div class="text-gray-700 mt-1 sm:mt-2 text-base sm:text-lg break-words">Pending User Approvals</div>
              <button :class="modalButtonClass + ' bg-yellow-500 text-white hover:bg-yellow-600 w-full sm:w-auto text-center justify-center flex mt-6 disabled:opacity-60 disabled:cursor-not-allowed'" @click="showApprovalsModal = true" :disabled="!pendingApprovals?.length">Review</button>
            </div>
          </div>
          <!-- Active Schedules Card -->
          <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-center items-center w-full min-w-0 overflow-hidden transition-transform duration-200 hover:shadow-2xl hover:-translate-y-1 hover:border-green-200 border border-transparent cursor-pointer">
            <div class="flex flex-col items-center w-full">
              <div class="text-2xl sm:text-3xl font-bold text-green-600 break-words">{{ activeSchedules ?? 0 }}</div>
              <div class="text-gray-700 mt-1 sm:mt-2 text-base sm:text-lg break-words">Active Schedules</div>
              <button :class="modalButtonClass + ' bg-green-600 text-white hover:bg-green-700 w-full sm:w-auto text-center justify-center flex mt-6 disabled:opacity-60 disabled:cursor-not-allowed'" @click="showSchedulesModal = true" :disabled="!activeSchedules">View</button>
            </div>
          </div>
        </div>
        <div class="w-full mt-8 min-w-0">
          <div class="bg-white rounded-xl shadow p-4 w-full min-w-0 overflow-x-auto">
            <h2 class="text-lg sm:text-xl font-bold mb-4 flex items-center gap-2 break-words text-center sm:text-left">
              <i class="fas fa-history text-blue-400" aria-hidden="true"></i>
              <span class="break-words">System Logs / Recent Activity</span>
            </h2>
            <ul class="break-words">
              <li class="grid grid-cols-6 gap-2 py-2 border-b font-semibold text-gray-600 text-xs sm:text-sm">
                <span class="col-span-1 text-gray-500">Time</span>
                <span class="col-span-1 text-gray-500">Date</span>
                <span class="col-span-1 text-blue-700">Name</span>
                <span class="col-span-1 text-green-700">Action</span>
                <span class="col-span-2 text-gray-700">Description</span>
              </li>
              <li v-for="log in recentActivity" :key="log.id" class="grid grid-cols-6 gap-2 py-2 border-b last:border-b-0 hover:bg-gray-50 cursor-pointer text-xs sm:text-sm items-center">
                <span class="col-span-1 text-xs text-gray-500 truncate">{{ new Date(log.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}</span>
                <span class="col-span-1 text-xs text-gray-500 truncate">{{ new Date(log.created_at).toLocaleDateString() }}</span>
                <span class="col-span-1 text-blue-700 font-semibold truncate">{{ log.username }}</span>
                <span class="col-span-1 text-green-700 font-semibold truncate">{{ log.action }}</span>
                <span class="col-span-2 text-gray-700 truncate">{{ log.description }}</span>
              </li>
            </ul>
            <div v-if="recentActivity.length === 0" class="text-gray-500 text-center break-words">No recent activity.</div>
          </div>
        </div>
      </div>
      <!-- Modals -->
      <Modal :show="showApprovalsModal" @close="showApprovalsModal = false">
        <template #default>
          <div class="p-6 sm:p-8 rounded-xl bg-white shadow-xl max-w-3xl mx-auto border border-yellow-100 min-w-[400px]">
            <h2 class="text-xl sm:text-2xl font-bold mb-6 text-center text-yellow-600">Pending User Approvals</h2>
            <div v-if="pendingApprovals?.length === 0" class="text-gray-500 text-center break-words">No pending users.</div>
            <div v-else class="max-h-80 overflow-y-auto" style="overflow-x: hidden;">
              <table class="min-w-full divide-y divide-gray-200 mt-2 text-xs sm:text-sm whitespace-nowrap">
                <thead>
                  <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in pendingApprovals" :key="user.id">
                    <td class="px-4 py-2">{{ user.name }}</td>
                    <td class="px-4 py-2">{{ user.email }}</td>
                    <td class="px-4 py-2 flex flex-row gap-2 items-center">
                      <form :action="route('admin.user-approvals.approve', user.id)" method="post">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <button :class="modalButtonClass + ' bg-green-500 text-white hover:bg-green-600 w-28'" type="submit">Approve</button>
                      </form>
                      <form :action="route('admin.user-approvals.decline', user.id)" method="post">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <button :class="modalButtonClass + ' bg-red-500 text-white hover:bg-red-600 w-28'" type="submit">Decline</button>
                      </form>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </Modal>
      <Modal :show="showSchedulesModal" @close="showSchedulesModal = false">
        <template #default>
          <div class="p-6 sm:p-8 rounded-xl bg-white shadow-xl max-w-3xl mx-auto border border-green-100 min-w-[400px] overflow-x-auto whitespace-nowrap">
            <h2 class="text-xl sm:text-2xl font-bold mb-6 text-center text-green-700">Active Schedules</h2>
            <p class="text-gray-700 text-base break-words text-center">Schedules management coming soon.</p>
          </div>
        </template>
      </Modal>
      <Modal :show="showLogModal" @close="showLogModal = false">
        <template #default>
          <div class="p-4 sm:p-6 w-full max-w-3xl min-w-[400px] mx-auto bg-white rounded-xl shadow-lg overflow-x-auto whitespace-nowrap">
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
      <Modal :show="showUsersModal" @close="showUsersModal = false">
        <template #default>
          <div class="p-6 sm:p-8 rounded-xl bg-white shadow-xl max-w-3xl mx-auto border border-blue-100 min-w-[400px]">
            <h2 class="text-xl sm:text-2xl font-bold mb-6 text-center text-blue-700">User Accounts <span class="text-gray-500 text-lg">(Categorized)</span></h2>
            <div class="max-h-80 overflow-y-auto">
              <div class="mb-6">
                <h3 class="font-semibold text-blue-600 text-base mb-3 uppercase tracking-wide">Admins</h3>
                <ul class="list-disc ml-6">
                  <li v-for="admin in admins" :key="'admin-' + admin.id" class="mb-2 text-gray-800">
                    <span class="font-medium">{{ admin.name }}</span> <span class="text-xs text-gray-500">({{ admin.email }})</span>
                  </li>
                </ul>
              </div>
              <div>
                <h3 class="font-semibold text-blue-600 text-base mb-3 uppercase tracking-wide">Schedulers</h3>
                <ul class="list-disc ml-6">
                  <li v-for="scheduler in schedulers" :key="'scheduler-' + scheduler.id" class="mb-2 text-gray-800">
                    <span class="font-medium">{{ scheduler.name }}</span> <span class="text-xs text-gray-500">({{ scheduler.email }})</span>
                  </li>
                </ul>
              </div>
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
  admins: Array,
  schedulers: Array,
});
const csrfToken = props.csrf_token || usePage().props.csrf_token;
const showApprovalsModal = ref(false);
const showSchedulesModal = ref(false);
const showLogModal = ref(false);
const showUsersModal = ref(false);
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
// Responsive button classes for modals
const modalButtonClass =
  'w-full sm:w-auto px-4 py-2 rounded-lg font-semibold transition text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 disabled:opacity-60';
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

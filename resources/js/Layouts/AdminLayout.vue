<template>
  <div class="flex min-h-screen bg-gray-100">
    <div class="flex-1 flex flex-col w-full">
      <header class="bg-gradient-to-r from-blue-50/80 via-white to-blue-100/80 shadow-md sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 h-16 w-full border-b border-blue-100">
        <!-- Hamburger for mobile -->
        <button
          class="sm:hidden flex items-center justify-center p-2 rounded-md text-gray-500 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-200"
          @click="showMobileNav = !showMobileNav"
          aria-label="Open main menu"
        >
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path v-if="!showMobileNav" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <!-- Navigation Links -->
        <nav :class="['flex flex-wrap items-center gap-2 sm:gap-4', showMobileNav ? 'flex' : 'hidden', 'sm:flex']" aria-label="Main navigation">
          <!-- Group 1: Dashboard -->
          <NavLink :href="route('admin.dashboard')" :class="navActive('/admin/dashboard')" aria-label="Dashboard">
            <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
          </NavLink>
          <!-- Group 2: Schedules -->
          <span class="hidden sm:inline-block border-l border-blue-200 h-6 mx-2"></span>
          <NavLink :href="route('admin.create-schedule')" :class="navActive('/admin/create-schedule')" aria-label="Create Schedule">
            <i class="fas fa-calendar-plus mr-1"></i>Create Schedule
          </NavLink>
          <NavLink :href="route('admin.manage-schedules')" :class="navActive('/admin/manage-schedules')" aria-label="Manage Schedules">
            <i class="fas fa-tasks mr-1"></i>Manage Schedules
          </NavLink>
          <!-- Group 3: Data -->
          <span class="hidden sm:inline-block border-l border-blue-200 h-6 mx-2"></span>
          <NavLink :href="route('admin.records')" :class="navActive('/admin/records')" aria-label="Records & Data">
            <i class="fas fa-database mr-1"></i>Records & Data
          </NavLink>
          <NavLink :href="route('admin.system-logs')" :class="navActive('/admin/system-logs')" aria-label="System Logs">
            <i class="fas fa-bell mr-1"></i>System Logs
          </NavLink>
          <NavLink :href="route('admin.user-approvals')" :class="navActive('/admin/user-approvals')" aria-label="Registration Requests">
            <i class="fas fa-user-check mr-1"></i>Registration Requests
          </NavLink>
          <!-- User Info & Profile Dropdown -->
          <Dropdown align="right" width="48">
            <template #trigger>
              <button type="button" class="flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-200 transition">
                <i class="fas fa-user-circle text-xl"></i>
                <span class="font-medium text-gray-700">{{ page.props.auth?.user?.name || 'Admin' }}</span>
                <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
              </button>
            </template>
            <template #content>
              <DropdownLink :href="route('profile.edit')">
                <i class="fas fa-user mr-2"></i> Profile
              </DropdownLink>
              <button type="button" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none" @click="confirmLogout">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </button>
            </template>
          </Dropdown>
        </nav>
      </header>
      <main class="flex-1 p-2 sm:p-6 w-full max-w-full overflow-x-auto">
        <slot />
      </main>
    </div>
    <!-- Logout Confirmation Modal -->
    <Modal :show="logoutDialogVisible" @close="logoutDialogVisible = false">
      <div class="p-6 text-center">
        <div class="mb-4 text-lg">Are you sure you want to logout?</div>
        <div class="flex justify-center gap-4">
          <button class="bg-gray-300 text-gray-800 px-4 py-2 rounded" @click="logoutDialogVisible = false">Cancel</button>
          <button class="bg-red-600 text-white px-4 py-2 rounded" @click="proceedLogout">Logout</button>
        </div>
      </div>
    </Modal>
    <!-- Global Notification -->
    <GlobalNotification :show="notification.show" :message="notification.message" :type="notification.type" @close="notification.show = false" />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import NavLink from '@/components/NavLink.vue';
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import Modal from '@/components/Modal.vue';
import GlobalNotification from '@/components/GlobalNotification.vue';
import { usePage, router } from '@inertiajs/vue3';

const page = usePage();
const showMobileNav = ref(false);
const logoutDialogVisible = ref(false);
const logoutDialogTarget = ref(null);
const notification = ref({ show: false, message: '', type: 'success' });

function navActive(path) {
  return page.url.startsWith(path)
    ? 'font-bold text-blue-700 underline bg-blue-50'
    : 'text-gray-700';
}

function confirmLogout(e) {
  e.preventDefault();
  logoutDialogVisible.value = true;
  // Store the event target for later use
  logoutDialogTarget.value = e.target.closest('a,button');
}

function proceedLogout() {
  logoutDialogVisible.value = false;
  // Use Inertia to POST to the logout route
  router.post(route('logout'));
}

function notify(message, type = 'success') {
  notification.value = { show: true, message, type };
  setTimeout(() => notification.value.show = false, 4000);
}

// Make notify globally available if needed
window.$notify = notify;
</script>

<style scoped>
nav a {
  font-size: 1rem;
  font-family: inherit;
  color: #374151;
  padding: 0.5rem 1rem; /* px-4 */
  border-radius: 9999px; /* rounded-full for pill style */
  transition: background 0.2s, color 0.2s, transform 0.15s;
  text-decoration: none;
  display: flex;
  align-items: center;
  line-height: 1.5;
  font-weight: 500;
}
nav a:hover, nav a:focus {
  background: #dbeafe;
  color: #1d4ed8;
  outline: none;
  transform: scale(1.04);
  box-shadow: 0 2px 8px 0 #60a5fa22;
}
nav a.font-bold {
  background: linear-gradient(90deg, #3b82f6 0%, #60a5fa 100%);
  color: #fff !important;
  box-shadow: 0 2px 8px 0 #60a5fa33;
  font-weight: 700;
  border-radius: 9999px;
}
nav a .fas {
  font-size: 1.1em;
  opacity: 0.85;
}
span.border-l {
  border-color: #bfdbfe !important;
}
@media (max-width: 640px) {
  nav {
    flex-direction: column;
    align-items: stretch;
    gap: 0.5rem;
  }
  nav a, .sm\:inline-block {
    display: block !important;
    width: 100%;
    margin: 0.25rem 0;
  }
  .flex-1 {
    display: none;
  }
}
</style>

<template>
  <div class="flex min-h-screen bg-gray-100">
    <div class="flex-1 flex flex-col w-full">
      <header class="bg-white shadow sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 h-16 w-full">
        <!-- Hamburger for mobile -->
        <button
          class="sm:hidden flex items-center justify-center p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-200"
          @click="showMobileNav = !showMobileNav"
          aria-label="Open main menu"
        >
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path v-if="!showMobileNav" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <!-- Navigation Links -->
        <nav :class="['flex flex-wrap items-center gap-2 sm:gap-4 w-full', showMobileNav ? 'flex' : 'hidden', 'sm:flex']" aria-label="Main navigation">
          <!-- Group 1: Dashboard -->
          <NavLink :href="route('admin.dashboard')" :class="navActive('/admin/dashboard')" aria-label="Dashboard">
            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
          </NavLink>
          <!-- Group 2: Schedules -->
          <span class="hidden sm:inline-block border-l border-gray-300 h-6 mx-2"></span>
          <NavLink :href="route('admin.create-schedule')" :class="navActive('/admin/create-schedule')" aria-label="Create Schedule">
            <i class="fas fa-calendar-plus mr-1"></i> Create Schedule
          </NavLink>
          <NavLink :href="route('admin.manage-schedules')" :class="navActive('/admin/manage-schedules')" aria-label="Manage Schedules">
            <i class="fas fa-tasks mr-1"></i> Manage Schedules
          </NavLink>
          <!-- Group 3: Data -->
          <span class="hidden sm:inline-block border-l border-gray-300 h-6 mx-2"></span>
          <NavLink :href="route('admin.records')" :class="navActive('/admin/records')" aria-label="Records & Data">
            <i class="fas fa-database mr-1"></i> Records & Data
          </NavLink>
          <NavLink :href="route('admin.system-logs')" :class="navActive('/admin/system-logs')" aria-label="System Logs">
            <i class="fas fa-bell mr-1"></i> System Logs
          </NavLink>
          <NavLink :href="route('admin.user-approvals')" :class="navActive('/admin/user-approvals')" aria-label="Registration Requests">
            <i class="fas fa-user-check mr-1"></i> Registration Requests
          </NavLink>
          <!-- Spacer -->
          <div class="flex-1"></div>
          <!-- User Info & Profile Dropdown -->
          <Dropdown align="right" width="48">
            <template #trigger>
              <button type="button" class="flex items-center gap-2 px-2 py-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-200">
                <i class="fas fa-user-circle text-xl"></i>
                <span class="font-medium text-gray-700">{{ page.props.auth?.user?.name || 'Admin' }}</span>
                <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
              </button>
            </template>
            <template #content>
              <DropdownLink :href="route('profile.edit')">
                <i class="fas fa-user mr-2"></i> Profile
              </DropdownLink>
              <DropdownLink as="button" :href="route('logout')" method="post" @click.prevent="confirmLogout">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </DropdownLink>
            </template>
          </Dropdown>
        </nav>
      </header>
      <main class="flex-1 p-2 sm:p-6 w-full max-w-full overflow-x-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import NavLink from '@/components/NavLink.vue';
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const showMobileNav = ref(false);

function navActive(path) {
  return page.url.startsWith(path)
    ? 'font-bold text-blue-700 underline bg-blue-50'
    : 'text-gray-700';
}

function confirmLogout(e) {
  if (confirm('Are you sure you want to logout?')) {
    e.target.closest('a,button').click();
  }
}
</script>

<style scoped>
nav a {
  font-size: 1rem;
  font-family: inherit;
  color: #374151;
  padding: 0.5rem 0.75rem;
  border-radius: 0.375rem;
  transition: background 0.2s, color 0.2s;
  text-decoration: none;
  display: flex;
  align-items: center;
}
nav a:hover, nav a:focus {
  background: #f3f4f6;
  color: #1d4ed8;
  outline: none;
}
nav a.font-bold {
  background: #e0e7ff;
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

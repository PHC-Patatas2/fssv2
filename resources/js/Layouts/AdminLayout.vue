<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Main Content Only, Side Panel Removed -->
    <div class="flex-1 flex flex-col w-full">
      <!-- Navbar -->
      <header class="bg-white shadow flex items-center justify-between px-6 h-16">
        <div class="flex items-center">
          <span class="font-bold text-lg">Admin Panel</span>
        </div>
        <nav class="flex items-center gap-4">
          <NavLink :href="route('admin.dashboard')">Dashboard</NavLink>
          <div class="relative group">
            <button class="px-2 py-1">Quick Actions</button>
            <div class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity z-10">
              <NavLink :href="route('admin.create-schedule')" class="block px-4 py-2">Create Schedule</NavLink>
              <NavLink :href="route('admin.manage-schedules')" class="block px-4 py-2">Manage Schedules</NavLink>
              <NavLink :href="route('admin.records')" class="block px-4 py-2">Records & Data</NavLink>
              <NavLink :href="route('admin.system-logs')" class="block px-4 py-2">System Logs</NavLink>
            </div>
          </div>
          <div class="relative group">
            <button class="px-2 py-1">Profile</button>
            <div class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity z-10">
              <NavLink :href="route('profile.edit')" class="block px-4 py-2">Manage Profile</NavLink>
              <NavLink :href="route('logout')" method="post" as="button" class="block px-4 py-2 text-red-500">Logout</NavLink>
            </div>
          </div>
        </nav>
      </header>
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<style scoped>
@media (max-width: 640px) {
  /* No side panel, so no aside width override needed */
}
</style>

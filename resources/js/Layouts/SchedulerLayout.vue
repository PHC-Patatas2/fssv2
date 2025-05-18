<template>
  <div class="flex min-h-screen bg-gray-100">
    <div class="flex-1 flex flex-col w-full">
      <header class="bg-gradient-to-r from-green-50/80 via-white to-green-100/80 shadow-md sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 h-16 w-full border-b border-green-100">
        <nav class="flex flex-wrap items-center gap-2 sm:gap-4" aria-label="Main navigation">
          <a href="#" class="font-bold text-green-700 underline bg-green-50 px-3 py-2 rounded">Dashboard</a>
          <a href="#" class="text-gray-700 px-3 py-2 rounded hover:bg-green-100">My Schedules</a>
        </nav>
        <div class="flex items-center gap-2 relative">
          <!-- User icon and name (right side) -->
          <button class="flex items-center gap-1 p-2 rounded-full hover:bg-green-200 focus:outline-none" title="User Profile" @click="showModal = true">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor" class="h-6 w-6 text-green-600">
              <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
            <span class="ml-1 text-green-700 font-medium">{{ userName }}</span>
          </button>
          <!-- Modal -->
          <div v-if="showModal" class="fixed inset-0 z-50 flex items-start justify-end" @mousedown.self="showModal = false" style="pointer-events: auto;">
            <div class="bg-white rounded-lg shadow-lg p-6 w-80 mt-6 mr-4 flex flex-col items-center relative" :style="modalStyle">
              <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-3xl font-bold leading-none" style="width: 2rem; height: 2rem;" @click="showModal = false">&times;</button>
              <p class="text-gray-500 text-sm text-center">{{ userEmail }}</p>
              <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 0 24 24" width="48" fill="currentColor" class="text-green-600 mt-2 mb-2">
                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
              </svg>
              <h2 class="text-lg font-semibold mt-2 text-center">Hi {{ userName }}</h2>
              <div class="mt-4 space-y-2 w-full flex flex-col items-center">
                <button class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600" @click="manageProfile">Manage Profile</button>
                <form :action="route('logout')" method="POST" class="m-0 w-full">
                  <input type="hidden" name="_token" :value="csrfToken" />
                  <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600">Logout</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </header>
      <main class="flex-1 p-2 sm:p-6 w-full max-w-full overflow-x-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
const csrfToken = usePage().props.csrf_token;
const userName = usePage().props.auth?.user?.name || 'User';
const userEmail = usePage().props.auth?.user?.email || 'user@example.com';
const showModal = ref(false);
const manageProfile = () => {
  // Add logic to navigate to the profile management page
};
const modalStyle = computed(() => {
  const screenWidth = window.innerWidth;
  const modalWidth = 320; // px
  const margin = 16; // px
  let right = margin;
  let top = 32; // move modal a bit higher (was 64)
  if (screenWidth < modalWidth + margin * 2) {
    return {
      top: top + 'px',
      right: 0,
      left: 0,
      margin: '0 auto',
      maxWidth: 'calc(100vw - 2 * 8px)',
      width: '100%',
      position: 'fixed',
    };
  }
  return {
    top: top + 'px',
    right: right + 'px',
    position: 'fixed',
    width: modalWidth + 'px',
    maxWidth: 'calc(100vw - 2 * 16px)',
  };
});
</script>

<style scoped>
header {
  font-family: 'Inter', sans-serif;
}
</style>

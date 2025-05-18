<template>
  <div class="flex min-h-screen bg-gray-100">
    <div class="flex-1 flex flex-col w-full">
      <!-- Responsive Navbar -->
      <header class="bg-white/90 shadow-md sticky top-0 z-30 w-full border-b border-blue-100">
        <div class="flex items-center justify-between w-full h-16 px-2 sm:px-4 lg:px-8">
          <!-- Hamburger for small/medium screens -->
          <button class="flex lg:hidden items-center px-2 py-2 text-blue-700 focus:outline-none" @click="showMobileNav = true">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <!-- Main nav for large screens -->
          <nav ref="navRef" class="hidden lg:flex flex-nowrap whitespace-nowrap items-center gap-2 sm:gap-4 flex-1 justify-center" aria-label="Main navigation">
            <a href="/admin/dashboard" class="font-bold text-blue-700 underline bg-blue-50 px-3 py-2 rounded transition">Dashboard</a>
            <a href="/admin/schedules" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition">Schedules</a>
            <a href="/admin/users" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition">Users</a>
            <a href="/admin/rooms" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition">Rooms/Resources</a>
            <a href="/admin/export" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition">Export Data</a>
            <a href="/admin/settings" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition">System Settings</a>
          </nav>
          <!-- User profile always right on large screens -->
          <div ref="containerRef" class="hidden lg:flex items-center gap-2 ml-4 px-3 py-2 rounded bg-white/80 hover:bg-blue-100 transition whitespace-nowrap shadow border border-blue-100 user-profile-navbar">
            <button class="flex items-center gap-1 focus:outline-none" title="User Profile" @click="showModal = true">
              <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor" class="h-6 w-6 text-blue-600">
                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
              </svg>
              <span class="ml-1 text-blue-700 font-medium">{{ userName }}</span>
            </button>
            <!-- Modal -->
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-start justify-end" @mousedown.self="showModal = false" style="pointer-events: auto;">
              <div class="bg-white rounded-lg shadow-lg p-6 w-80 mt-6 mr-4 flex flex-col items-center relative" :style="modalStyle">
                <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-3xl font-bold leading-none" style="width: 2rem; height: 2rem;" @click="showModal = false">&times;</button>
                <p class="text-gray-500 text-sm text-center break-words">{{ userEmail }}</p>
                <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 0 24 24" width="48" fill="currentColor" class="text-blue-600 mt-2 mb-2">
                  <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
                <h2 class="text-lg font-semibold mt-2 text-center break-words">Hi {{ userName }}</h2>
                <div class="mt-4 space-y-2 w-full flex flex-col items-center">
                  <button class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition" @click="manageProfile">Manage Profile</button>
                  <form :action="route('logout')" method="POST" class="m-0 w-full">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition">Logout</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Side panel for small/medium screens -->
        <transition name="fade">
          <div v-if="showMobileNav" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex">
            <div class="bg-white w-72 max-w-full h-full shadow-lg p-6 flex flex-col gap-4 animate-slide-in-left">
              <button class="self-end text-2xl text-gray-500 hover:text-gray-700 mb-4" @click="showMobileNav = false">&times;</button>
              <a href="/admin/dashboard" class="font-bold text-blue-700 underline bg-blue-50 px-3 py-2 rounded transition" @click="showMobileNav = false">Dashboard</a>
              <a href="/admin/schedules" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition" @click="showMobileNav = false">Schedules</a>
              <a href="/admin/users" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition" @click="showMobileNav = false">Users</a>
              <a href="/admin/rooms" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition" @click="showMobileNav = false">Rooms/Resources</a>
              <a href="/admin/export" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition" @click="showMobileNav = false">Export Data</a>
              <a href="/admin/settings" class="text-gray-700 px-3 py-2 rounded hover:bg-blue-100 transition" @click="showMobileNav = false">System Settings</a>
              <div class="mt-6 border-t pt-4">
                <div class="flex items-center gap-2 px-3 py-2 rounded bg-white/80 hover:bg-blue-100 transition whitespace-nowrap shadow border border-blue-100">
                  <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor" class="h-6 w-6 text-blue-600">
                    <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
                  </svg>
                  <span class="ml-1 text-blue-700 font-medium break-words">{{ userName }}</span>
                </div>
                <div class="flex flex-col gap-2 mt-2">
                  <button class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition" @click="manageProfile">Manage Profile</button>
                  <form :action="route('logout')" method="POST" class="m-0 w-full">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition">Logout</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="flex-1" @click="showMobileNav = false"></div>
          </div>
        </transition>
      </header>
      <main class="flex-1 p-2 sm:p-6 w-full max-w-full overflow-x-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from 'vue';
const csrfToken = usePage().props.csrf_token;
const userName = usePage().props.auth?.user?.name || 'User';
const userEmail = usePage().props.auth?.user?.email || 'user@example.com';
const showModal = ref(false);
const showMobileNav = ref(false);
const navRef = ref(null);
const containerRef = ref(null);
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

function checkNavGap() {
  nextTick(() => {
    if (!navRef.value || !containerRef.value) return;
    const nav = navRef.value;
    const container = containerRef.value;
    // Get the right edge of the nav and left edge of the user profile
    const navRect = nav.getBoundingClientRect();
    const userProfile = container.querySelector('.user-profile-navbar');
    if (!userProfile) return;
    const userProfileRect = userProfile.getBoundingClientRect();
    // Calculate the gap in pixels
    const gap = userProfileRect.left - navRect.right;
    // If the gap is less than 24px (smaller threshold for more aggressive responsiveness), hide nav and user profile, show hamburger
    if (gap < 24 || window.innerWidth < 900) {
      nav.classList.add('hidden');
      userProfile.classList.add('hidden');
    } else {
      nav.classList.remove('hidden');
      userProfile.classList.remove('hidden');
    }
  });
}

onMounted(() => {
  window.addEventListener('resize', checkNavGap);
  checkNavGap();
});
onBeforeUnmount(() => {
  window.removeEventListener('resize', checkNavGap);
});
</script>

<style scoped>
header {
  font-family: 'Inter', sans-serif;
}
nav[aria-label="Main navigation"] {
  overflow: visible !important;
  white-space: nowrap;
  max-width: 100vw;
}
.flex-nowrap {
  flex-wrap: nowrap !important;
}
body, html, .min-h-screen, .w-full, .max-w-full {
  overflow-x: hidden !important;
}
@media (max-width: 767px) {
  nav[aria-label="Main navigation"] {
    display: none !important;
  }
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
.animate-slide-in-left {
  animation: slide-in-left 0.2s cubic-bezier(0.4,0,0.2,1);
}
@keyframes slide-in-left {
  from { transform: translateX(-100%); }
  to { transform: translateX(0); }
}
</style>

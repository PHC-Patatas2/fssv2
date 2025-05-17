<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md text-center">
      <h1 class="text-2xl font-bold mb-4 text-gray-800">
        Welcome, Scheduler!
      </h1>
      <p class="mb-6 text-gray-600">The scheduler dashboard is coming soon.</p>
      <form :action="route('logout')" method="POST">
        <input type="hidden" name="_token" :value="csrfToken" />
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Logout</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
const csrfToken = usePage().props.csrf_token;
</script>

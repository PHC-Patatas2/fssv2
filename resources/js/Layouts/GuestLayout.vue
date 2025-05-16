<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <!-- System title or school name (optional, uncomment to use) -->
        <div class="text-2xl font-semibold mb-4 text-gray-700 text-center w-full">ACLC College of Apalit Scheduling System</div>
        <div style="height: 16px;"></div>
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>

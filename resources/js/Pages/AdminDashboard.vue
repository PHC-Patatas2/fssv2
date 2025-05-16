<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4 text-gray-800">Admin Dashboard</h1>
            <p class="text-gray-600 mb-4">Welcome, admin! This is your dashboard. All privileges will be implemented soon.</p>
            <div class="mt-6">
                <Link :href="route('admin.user-approvals')" class="text-blue-600 hover:underline mr-4">
                    Review Pending Users
                </Link>
                <Link :href="route('logout')" method="post" as="button" class="text-blue-600 hover:underline">
                    Logout
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
// Add logic here as needed in the future
</script>

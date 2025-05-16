<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-2xl">
            <h1 class="text-2xl font-bold mb-4 text-gray-800">Pending User Approvals</h1>
            <div v-if="pendingUsers.length === 0" class="text-gray-600">No pending users.</div>
            <table v-else class="min-w-full divide-y divide-gray-200 mt-4">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in pendingUsers" :key="user.id">
                        <td class="px-4 py-2">{{ user.name }}</td>
                        <td class="px-4 py-2">{{ user.email }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <form :action="route('admin.user-approvals.approve', user.id)" method="post">
                                <input type="hidden" name="_token" :value="csrfToken">
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                            </form>
                            <form :action="route('admin.user-approvals.decline', user.id)" method="post">
                                <input type="hidden" name="_token" :value="csrfToken">
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Decline</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
const props = defineProps({
    pendingUsers: Array,
    csrf_token: String,
});
const csrfToken = props.csrf_token || document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>

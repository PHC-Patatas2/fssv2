<template>
  <AdminLayout>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-users text-blue-400" aria-hidden="true"></i> Manage Users
      </h1>
      <div class="bg-white rounded shadow p-4">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left">Name</th>
              <th class="px-4 py-2 text-left">Email</th>
              <th class="px-4 py-2 text-left">Role</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td class="px-4 py-2">{{ user.name }}</td>
              <td class="px-4 py-2">{{ user.email }}</td>
              <td class="px-4 py-2">{{ user.role }}</td>
              <td class="px-4 py-2">{{ user.status }}</td>
              <td class="px-4 py-2">
                <button @click="approveUser(user.id)" v-if="user.status === 'pending'" class="bg-green-500 text-white px-2 py-1 rounded mr-2">Approve</button>
                <button @click="declineUser(user.id)" v-if="user.status === 'pending'" class="bg-red-500 text-white px-2 py-1 rounded">Decline</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
const users = usePage().props.users || [];
function approveUser(id) {
  router.post(`/admin/user-approvals/${id}/approve`);
}
function declineUser(id) {
  router.post(`/admin/user-approvals/${id}/decline`);
}
</script>

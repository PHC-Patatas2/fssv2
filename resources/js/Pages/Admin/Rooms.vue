<template>
  <AdminLayout>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-door-open text-blue-400" aria-hidden="true"></i> Manage Rooms
      </h1>
      <div class="bg-white rounded shadow p-4 mb-4">
        <form @submit.prevent="submitRoom">
          <input v-model="roomForm.name" placeholder="Room Name" class="border p-2 mr-2" required />
          <input v-model.number="roomForm.capacity" placeholder="Capacity" type="number" class="border p-2 mr-2" />
          <select v-model="roomForm.status" class="border p-2 mr-2">
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
          </select>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Room</button>
        </form>
      </div>
      <div class="bg-white rounded shadow p-4">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left">Name</th>
              <th class="px-4 py-2 text-left">Capacity</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="room in rooms" :key="room.id">
              <td class="px-4 py-2">{{ room.name }}</td>
              <td class="px-4 py-2">{{ room.capacity }}</td>
              <td class="px-4 py-2">{{ room.status }}</td>
              <td class="px-4 py-2">
                <button @click="editRoom(room)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
                <button @click="deleteRoom(room.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
const rooms = usePage().props.rooms || [];
const roomForm = ref({ name: '', capacity: '', status: 'available' });
function submitRoom() {
  router.post('/admin/rooms', roomForm.value);
  roomForm.value = { name: '', capacity: '', status: 'available' };
}
function editRoom(room) {
  roomForm.value = { ...room };
}
function deleteRoom(id) {
  if (confirm('Delete this room?')) {
    router.delete(`/admin/rooms/${id}`);
  }
}
</script>

<template>
  <AdminLayout>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-chalkboard-teacher text-blue-400" aria-hidden="true"></i> Manage Teachers
      </h1>
      <div class="bg-white rounded shadow p-4 mb-4">
        <form @submit.prevent="submitTeacher">
          <input v-model="teacherForm.name" placeholder="Name" class="border p-2 mr-2" required />
          <input v-model="teacherForm.email" placeholder="Email" class="border p-2 mr-2" required />
          <input v-model="teacherForm.contact" placeholder="Contact" class="border p-2 mr-2" />
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Teacher</button>
        </form>
      </div>
      <div class="bg-white rounded shadow p-4">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left">Name</th>
              <th class="px-4 py-2 text-left">Email</th>
              <th class="px-4 py-2 text-left">Contact</th>
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="teacher in teachers" :key="teacher.id">
              <td class="px-4 py-2">{{ teacher.name }}</td>
              <td class="px-4 py-2">{{ teacher.email }}</td>
              <td class="px-4 py-2">{{ teacher.contact }}</td>
              <td class="px-4 py-2">
                <button @click="editTeacher(teacher)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
                <button @click="deleteTeacher(teacher.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
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
const teachers = usePage().props.teachers || [];
const teacherForm = ref({ name: '', email: '', contact: '' });
function submitTeacher() {
  router.post('/admin/teachers', teacherForm.value);
  teacherForm.value = { name: '', email: '', contact: '' };
}
function editTeacher(teacher) {
  teacherForm.value = { ...teacher };
}
function deleteTeacher(id) {
  if (confirm('Delete this teacher?')) {
    router.delete(`/admin/teachers/${id}`);
  }
}
</script>

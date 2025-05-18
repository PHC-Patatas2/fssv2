<template>
  <AdminLayout>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-book text-blue-400" aria-hidden="true"></i> Manage Subjects
      </h1>
      <div class="bg-white rounded shadow p-4 mb-4">
        <form @submit.prevent="submitSubject">
          <input v-model="subjectForm.name" placeholder="Subject Name" class="border p-2 mr-2" required />
          <input v-model="subjectForm.code" placeholder="Code" class="border p-2 mr-2" required />
          <input v-model="subjectForm.description" placeholder="Description" class="border p-2 mr-2" />
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Subject</button>
        </form>
      </div>
      <div class="bg-white rounded shadow p-4">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left">Name</th>
              <th class="px-4 py-2 text-left">Code</th>
              <th class="px-4 py-2 text-left">Description</th>
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="subject in subjects" :key="subject.id">
              <td class="px-4 py-2">{{ subject.name }}</td>
              <td class="px-4 py-2">{{ subject.code }}</td>
              <td class="px-4 py-2">{{ subject.description }}</td>
              <td class="px-4 py-2">
                <button @click="editSubject(subject)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
                <button @click="deleteSubject(subject.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
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
const subjects = usePage().props.subjects || [];
const subjectForm = ref({ name: '', code: '', description: '' });
function submitSubject() {
  router.post('/admin/subjects', subjectForm.value);
  subjectForm.value = { name: '', code: '', description: '' };
}
function editSubject(subject) {
  subjectForm.value = { ...subject };
}
function deleteSubject(id) {
  if (confirm('Delete this subject?')) {
    router.delete(`/admin/subjects/${id}`);
  }
}
</script>

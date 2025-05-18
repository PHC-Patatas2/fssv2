<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Teacher Qualifications</h1>
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Description</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="qualification in qualifications" :key="qualification.id">
          <td class="border px-4 py-2">{{ qualification.id }}</td>
          <td class="border px-4 py-2">{{ qualification.name }}</td>
          <td class="border px-4 py-2">{{ qualification.description }}</td>
          <td class="border px-4 py-2">
            <button @click="editQualification(qualification)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
            <button @click="deleteQualification(qualification.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">{{ form.id ? 'Edit' : 'Add' }} Qualification</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-2">
          <label class="block">Name</label>
          <input v-model="form.name" class="border px-2 py-1 w-full" required />
        </div>
        <div class="mb-2">
          <label class="block">Description</label>
          <input v-model="form.description" class="border px-2 py-1 w-full" />
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">{{ form.id ? 'Update' : 'Add' }}</button>
        <button v-if="form.id" type="button" @click="resetForm" class="ml-2 px-4 py-2 rounded border">Cancel</button>
      </form>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
const qualifications = ref([]);
const form = ref({ id: null, name: '', description: '' });
onMounted(() => {
  fetchQualifications();
});
function fetchQualifications() {
  window.axios.get('/admin/teacher-qualifications').then(res => {
    qualifications.value = res.data.teacher_qualifications || res.data;
  });
}
function submitForm() {
  if (form.value.id) {
    router.put(`/admin/teacher-qualifications/${form.value.id}`, form.value, {
      onSuccess: () => { fetchQualifications(); resetForm(); }
    });
  } else {
    router.post('/admin/teacher-qualifications', form.value, {
      onSuccess: () => { fetchQualifications(); resetForm(); }
    });
  }
}
function editQualification(qualification) {
  form.value = { ...qualification };
}
function deleteQualification(id) {
  if (confirm('Delete this qualification?')) {
    router.delete(`/admin/teacher-qualifications/${id}`, {
      onSuccess: () => fetchQualifications()
    });
  }
}
function resetForm() {
  form.value = { id: null, name: '', description: '' };
}
</script>

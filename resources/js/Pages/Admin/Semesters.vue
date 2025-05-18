<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Semesters</h1>
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="semester in semesters" :key="semester.id">
          <td class="border px-4 py-2">{{ semester.id }}</td>
          <td class="border px-4 py-2">{{ semester.name }}</td>
          <td class="border px-4 py-2">
            <button @click="editSemester(semester)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
            <button @click="deleteSemester(semester.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">{{ form.id ? 'Edit' : 'Add' }} Semester</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-2">
          <label class="block">Name</label>
          <input v-model="form.name" class="border px-2 py-1 w-full" required />
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
const semesters = ref([]);
const form = ref({ id: null, name: '' });
onMounted(() => {
  fetchSemesters();
});
function fetchSemesters() {
  window.axios.get('/admin/semesters').then(res => {
    semesters.value = res.data.semesters || res.data;
  });
}
function submitForm() {
  if (form.value.id) {
    router.put(`/admin/semesters/${form.value.id}`, form.value, {
      onSuccess: () => { fetchSemesters(); resetForm(); }
    });
  } else {
    router.post('/admin/semesters', form.value, {
      onSuccess: () => { fetchSemesters(); resetForm(); }
    });
  }
}
function editSemester(semester) {
  form.value = { ...semester };
}
function deleteSemester(id) {
  if (confirm('Delete this semester?')) {
    router.delete(`/admin/semesters/${id}`, {
      onSuccess: () => fetchSemesters()
    });
  }
}
function resetForm() {
  form.value = { id: null, name: '' };
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Years</h1>
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="year in years" :key="year.id">
          <td class="border px-4 py-2">{{ year.id }}</td>
          <td class="border px-4 py-2">{{ year.name }}</td>
          <td class="border px-4 py-2">
            <button @click="editYear(year)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
            <button @click="deleteYear(year.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">{{ form.id ? 'Edit' : 'Add' }} Year</h2>
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
const years = ref([]);
const form = ref({ id: null, name: '' });
onMounted(() => {
  fetchYears();
});
function fetchYears() {
  window.axios.get('/admin/years').then(res => {
    years.value = res.data.years || res.data;
  });
}
function submitForm() {
  if (form.value.id) {
    router.put(`/admin/years/${form.value.id}`, form.value, {
      onSuccess: () => { fetchYears(); resetForm(); }
    });
  } else {
    router.post('/admin/years', form.value, {
      onSuccess: () => { fetchYears(); resetForm(); }
    });
  }
}
function editYear(year) {
  form.value = { ...year };
}
function deleteYear(id) {
  if (confirm('Delete this year?')) {
    router.delete(`/admin/years/${id}`, {
      onSuccess: () => fetchYears()
    });
  }
}
function resetForm() {
  form.value = { id: null, name: '' };
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Sections</h1>
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Year</th>
          <th class="border px-4 py-2">Major</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="section in sections" :key="section.id">
          <td class="border px-4 py-2">{{ section.id }}</td>
          <td class="border px-4 py-2">{{ section.name }}</td>
          <td class="border px-4 py-2">{{ section.year?.name || section.year_id }}</td>
          <td class="border px-4 py-2">{{ section.major?.name || section.major_id }}</td>
          <td class="border px-4 py-2">
            <button @click="editSection(section)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
            <button @click="deleteSection(section.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">{{ form.id ? 'Edit' : 'Add' }} Section</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-2">
          <label class="block">Name</label>
          <input v-model="form.name" class="border px-2 py-1 w-full" required />
        </div>
        <div class="mb-2">
          <label class="block">Year</label>
          <select v-model="form.year_id" class="border px-2 py-1 w-full" required>
            <option v-for="year in years" :key="year.id" :value="year.id">{{ year.name }}</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="block">Major</label>
          <select v-model="form.major_id" class="border px-2 py-1 w-full">
            <option value="">None</option>
            <option v-for="major in majors" :key="major.id" :value="major.id">{{ major.name }}</option>
          </select>
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
const sections = ref([]);
const years = ref([]);
const majors = ref([]);
const form = ref({ id: null, name: '', year_id: '', major_id: '' });
onMounted(() => {
  fetchSections();
  fetchYears();
  fetchMajors();
});
function fetchSections() {
  window.axios.get('/admin/sections').then(res => {
    sections.value = res.data.sections || res.data;
  });
}
function fetchYears() {
  window.axios.get('/admin/years').then(res => {
    years.value = res.data.years || res.data;
  });
}
function fetchMajors() {
  window.axios.get('/admin/majors').then(res => {
    majors.value = res.data.majors || res.data;
  });
}
function submitForm() {
  if (form.value.id) {
    router.put(`/admin/sections/${form.value.id}`, form.value, {
      onSuccess: () => { fetchSections(); resetForm(); }
    });
  } else {
    router.post('/admin/sections', form.value, {
      onSuccess: () => { fetchSections(); resetForm(); }
    });
  }
}
function editSection(section) {
  form.value = { ...section };
}
function deleteSection(id) {
  if (confirm('Delete this section?')) {
    router.delete(`/admin/sections/${id}`, {
      onSuccess: () => fetchSections()
    });
  }
}
function resetForm() {
  form.value = { id: null, name: '', year_id: '', major_id: '' };
}
</script>

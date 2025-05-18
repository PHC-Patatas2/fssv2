<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Majors</h1>
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Course</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="major in majors" :key="major.id">
          <td class="border px-4 py-2">{{ major.id }}</td>
          <td class="border px-4 py-2">{{ major.name }}</td>
          <td class="border px-4 py-2">{{ major.course?.acronym || major.course_id }}</td>
          <td class="border px-4 py-2">
            <button @click="editMajor(major)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
            <button @click="deleteMajor(major.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">{{ form.id ? 'Edit' : 'Add' }} Major</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-2">
          <label class="block">Name</label>
          <input v-model="form.name" class="border px-2 py-1 w-full" required />
        </div>
        <div class="mb-2">
          <label class="block">Course</label>
          <select v-model="form.course_id" class="border px-2 py-1 w-full" required>
            <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.acronym }}</option>
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
const majors = ref([]);
const courses = ref([]);
const form = ref({ id: null, name: '', course_id: '' });
onMounted(() => {
  fetchMajors();
  fetchCourses();
});
function fetchMajors() {
  window.axios.get('/admin/majors').then(res => {
    majors.value = res.data.majors || res.data;
  });
}
function fetchCourses() {
  window.axios.get('/admin/courses').then(res => {
    courses.value = res.data.courses || res.data;
  });
}
function submitForm() {
  if (form.value.id) {
    router.put(`/admin/majors/${form.value.id}`, form.value, {
      onSuccess: () => { fetchMajors(); resetForm(); }
    });
  } else {
    router.post('/admin/majors', form.value, {
      onSuccess: () => { fetchMajors(); resetForm(); }
    });
  }
}
function editMajor(major) {
  form.value = { ...major };
}
function deleteMajor(id) {
  if (confirm('Delete this major?')) {
    router.delete(`/admin/majors/${id}`, {
      onSuccess: () => fetchMajors()
    });
  }
}
function resetForm() {
  form.value = { id: null, name: '', course_id: '' };
}
</script>

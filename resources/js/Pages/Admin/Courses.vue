<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Courses</h1>
    <!-- Course List -->
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Acronym</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="course in courses" :key="course.id">
          <td class="border px-4 py-2">{{ course.id }}</td>
          <td class="border px-4 py-2">{{ course.name }}</td>
          <td class="border px-4 py-2">{{ course.acronym }}</td>
          <td class="border px-4 py-2">
            <button @click="editCourse(course)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
            <button @click="deleteCourse(course.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Add/Edit Form -->
    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">{{ form.id ? 'Edit' : 'Add' }} Course</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-2">
          <label class="block">Name</label>
          <input v-model="form.name" class="border px-2 py-1 w-full" required />
        </div>
        <div class="mb-2">
          <label class="block">Acronym</label>
          <input v-model="form.acronym" class="border px-2 py-1 w-full" required />
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
const courses = ref([]);
const form = ref({ id: null, name: '', acronym: '' });
// Fetch courses on mount
onMounted(() => {
  fetchCourses();
});
function fetchCourses() {
  window.axios.get('/admin/courses').then(res => {
    courses.value = res.data.courses || res.data;
  });
}
function submitForm() {
  if (form.value.id) {
    router.put(`/admin/courses/${form.value.id}`, form.value, {
      onSuccess: () => { fetchCourses(); resetForm(); }
    });
  } else {
    router.post('/admin/courses', form.value, {
      onSuccess: () => { fetchCourses(); resetForm(); }
    });
  }
}
function editCourse(course) {
  form.value = { ...course };
}
function deleteCourse(id) {
  if (confirm('Delete this course?')) {
    router.delete(`/admin/courses/${id}`, {
      onSuccess: () => fetchCourses()
    });
  }
}
function resetForm() {
  form.value = { id: null, name: '', acronym: '' };
}
</script>

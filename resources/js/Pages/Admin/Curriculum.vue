<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Curriculum Management</h1>
    <div class="flex gap-4 mb-4">
      <div>
        <label class="block">Course</label>
        <select v-model="selected.course_id" @change="fetchMajors" class="border px-2 py-1 w-full">
          <option value="">Select Course</option>
          <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.acronym }}</option>
        </select>
      </div>
      <div>
        <label class="block">Year</label>
        <select v-model="selected.year_id" class="border px-2 py-1 w-full">
          <option value="">Select Year</option>
          <option v-for="year in years" :key="year.id" :value="year.id">{{ year.name }}</option>
        </select>
      </div>
      <div>
        <label class="block">Semester</label>
        <select v-model="selected.semester_id" class="border px-2 py-1 w-full">
          <option value="">Select Semester</option>
          <option v-for="semester in semesters" :key="semester.id" :value="semester.id">{{ semester.name }}</option>
        </select>
      </div>
      <div>
        <label class="block">Major (optional)</label>
        <select v-model="selected.major_id" class="border px-2 py-1 w-full">
          <option value="">None</option>
          <option v-for="major in majors" :key="major.id" :value="major.id">{{ major.name }}</option>
        </select>
      </div>
      <button @click="fetchCurriculum" class="bg-blue-600 text-white px-4 py-2 rounded self-end">Load</button>
    </div>
    <div v-if="subjects.length > 0" class="mb-4">
      <h2 class="text-lg font-semibold mb-2">Assigned Subjects</h2>
      <ul class="mb-2">
        <li v-for="subject in subjects" :key="subject.id" class="flex items-center gap-2 mb-1">
          <span>{{ subject.code }} - {{ subject.name }}</span>
          <button @click="removeSubject(subject.id)" class="bg-red-500 text-white px-2 py-1 rounded">Remove</button>
        </li>
      </ul>
    </div>
    <div v-if="availableSubjects.length > 0">
      <h2 class="text-lg font-semibold mb-2">Add Subject</h2>
      <select v-model="selectedSubjectId" class="border px-2 py-1 w-full mb-2">
        <option value="">Select Subject</option>
        <option v-for="subject in availableSubjects" :key="subject.id" :value="subject.id">{{ subject.code }} - {{ subject.name }}</option>
      </select>
      <button @click="addSubject" class="bg-green-600 text-white px-4 py-2 rounded">Add</button>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
const courses = ref([]);
const years = ref([]);
const semesters = ref([]);
const majors = ref([]);
const subjects = ref([]);
const availableSubjects = ref([]);
const selected = ref({ course_id: '', year_id: '', semester_id: '', major_id: '' });
const selectedSubjectId = ref('');

onMounted(() => {
  fetchCourses();
  fetchYears();
  fetchSemesters();
});
function fetchCourses() {
  window.axios.get('/admin/courses').then(res => { courses.value = res.data.courses || res.data; });
}
function fetchYears() {
  window.axios.get('/admin/years').then(res => { years.value = res.data.years || res.data; });
}
function fetchSemesters() {
  window.axios.get('/admin/semesters').then(res => { semesters.value = res.data.semesters || res.data; });
}
function fetchMajors() {
  if (!selected.value.course_id) { majors.value = []; return; }
  window.axios.get(`/admin/majors?course_id=${selected.value.course_id}`).then(res => { majors.value = res.data.majors || res.data; });
}
function fetchCurriculum() {
  if (!selected.value.course_id || !selected.value.year_id || !selected.value.semester_id) return;
  window.axios.get('/admin/curriculum', { params: selected.value }).then(res => {
    subjects.value = res.data.subjects || [];
    availableSubjects.value = res.data.availableSubjects || [];
  });
}
function addSubject() {
  if (!selectedSubjectId.value) return;
  window.axios.post('/admin/curriculum/assign', { ...selected.value, subject_id: selectedSubjectId.value }).then(() => {
    fetchCurriculum();
    selectedSubjectId.value = '';
  });
}
function removeSubject(subjectId) {
  window.axios.post('/admin/curriculum/remove', { ...selected.value, subject_id: subjectId }).then(() => {
    fetchCurriculum();
  });
}
</script>
// ...existing code...

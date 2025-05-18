<template>
  <AdminLayout>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-calendar-alt text-blue-400" aria-hidden="true"></i> Manage Schedules
      </h1>
      <div class="bg-white rounded shadow p-4 mb-4">
        <form @submit.prevent="submitSchedule">
          <select v-model="scheduleForm.subject_id" class="border p-2 mr-2" required>
            <option value="" disabled>Select Subject</option>
            <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{ subject.name }}</option>
          </select>
          <select v-model="scheduleForm.teacher_id" class="border p-2 mr-2" required>
            <option value="" disabled>Select Teacher</option>
            <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">{{ teacher.name }}</option>
          </select>
          <select v-model="scheduleForm.room_id" class="border p-2 mr-2" required>
            <option value="" disabled>Select Room</option>
            <option v-for="room in rooms" :key="room.id" :value="room.id">{{ room.name }}</option>
          </select>
          <select v-model="scheduleForm.day" class="border p-2 mr-2" required>
            <option value="" disabled>Select Day</option>
            <option v-for="day in days" :key="day" :value="day">{{ day }}</option>
          </select>
          <input v-model="scheduleForm.start_time" type="time" class="border p-2 mr-2" required />
          <input v-model="scheduleForm.end_time" type="time" class="border p-2 mr-2" required />
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Schedule</button>
        </form>
        <div v-if="conflictError" class="text-red-500 mt-2">{{ conflictError }}</div>
      </div>
      <div class="flex gap-2 mb-4">
        <a href="/admin/schedules/export/csv" class="bg-green-500 text-white px-4 py-2 rounded">Export CSV</a>
        <a href="/admin/schedules/export/pdf" class="bg-green-500 text-white px-4 py-2 rounded">Export PDF</a>
      </div>
      <div class="bg-white rounded shadow p-4">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left">Subject</th>
              <th class="px-4 py-2 text-left">Teacher</th>
              <th class="px-4 py-2 text-left">Room</th>
              <th class="px-4 py-2 text-left">Day</th>
              <th class="px-4 py-2 text-left">Time</th>
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="schedule in schedules" :key="schedule.id">
              <td class="px-4 py-2">{{ schedule.subject?.name }}</td>
              <td class="px-4 py-2">{{ schedule.teacher?.name }}</td>
              <td class="px-4 py-2">{{ schedule.room?.name }}</td>
              <td class="px-4 py-2">{{ schedule.day }}</td>
              <td class="px-4 py-2">{{ schedule.start_time }} - {{ schedule.end_time }}</td>
              <td class="px-4 py-2">
                <button @click="editSchedule(schedule)" class="bg-yellow-400 text-white px-2 py-1 rounded mr-2">Edit</button>
                <button @click="deleteSchedule(schedule.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-8">
        <h2 class="text-lg font-bold mb-2">Schedule Preview</h2>
        <ScheduleGridPreview :schedules="schedules" :subjects="subjects" :teachers="teachers" :rooms="rooms" />
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ScheduleGridPreview from '@/components/ScheduleGridPreview.vue';
const schedules = usePage().props.schedules || [];
const subjects = usePage().props.subjects || [];
const teachers = usePage().props.teachers || [];
const rooms = usePage().props.rooms || [];
const days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
const scheduleForm = ref({ subject_id: '', teacher_id: '', room_id: '', day: '', start_time: '', end_time: '' });
const conflictError = ref('');
function submitSchedule() {
  router.post('/admin/schedules', scheduleForm.value, {
    onError: (errors) => {
      if (errors.conflict) conflictError.value = errors.conflict;
    },
    onSuccess: () => {
      conflictError.value = '';
      scheduleForm.value = { subject_id: '', teacher_id: '', room_id: '', day: '', start_time: '', end_time: '' };
    }
  });
}
function editSchedule(schedule) {
  scheduleForm.value = { ...schedule };
}
function deleteSchedule(id) {
  if (confirm('Delete this schedule?')) {
    router.delete(`/admin/schedules/${id}`);
  }
}
</script>

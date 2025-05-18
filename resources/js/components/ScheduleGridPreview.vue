<template>
  <div class="overflow-x-auto">
    <table class="border-collapse w-full min-w-max text-xs sm:text-sm">
      <thead>
        <tr>
          <th class="border px-2 py-1 bg-gray-100">Time</th>
          <th v-for="day in days" :key="day" class="border px-2 py-1 bg-gray-100">{{ day }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="time in timeSlots" :key="time">
          <td class="border px-2 py-1 font-bold bg-gray-50">{{ time }}</td>
          <td v-for="day in days" :key="day" class="border px-2 py-1 min-w-[100px] h-12 text-center">
            <span v-if="cellContent(day, time)" class="text-xl font-extrabold text-green-600">X</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
const props = defineProps({
  schedules: { type: Array, required: true },
  subjects: { type: Array, required: true },
  teachers: { type: Array, required: true },
  rooms: { type: Array, required: true },
});
const days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
const timeSlots = Array.from({length: 12}, (_, i) => {
  const hour = 7 + i;
  return `${hour.toString().padStart(2,'0')}:00`;
});
function cellContent(day, time) {
  // Find a schedule that matches this day and time slot
  const sched = props.schedules.find(s => s.day === day && s.start_time.startsWith(time));
  if (!sched) return null;
  const subject = props.subjects.find(sub => sub.id === sched.subject_id)?.name || '';
  const teacher = props.teachers.find(t => t.id === sched.teacher_id)?.name || '';
  const room = props.rooms.find(r => r.id === sched.room_id)?.name || '';
  return { subject, teacher, room };
}
</script>

<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Create Schedule</h1>
    <div class="mb-4">
      <label class="block mb-2 font-semibold">Schedule Type</label>
      <select v-model="scheduleType" class="border rounded px-3 py-2 w-full">
        <option value="normal">Normal Scheduler</option>
        <option value="exam">Exam Schedule</option>
      </select>
    </div>
    <div v-if="scheduleType === 'normal'">
      <!-- Normal Scheduler Form -->
      <div class="bg-white p-4 rounded shadow mb-4">Normal schedule form fields here...</div>
    </div>
    <div v-else-if="scheduleType === 'exam'">
      <!-- Exam Scheduler Form -->
      <div class="bg-white p-4 rounded shadow mb-4">Exam schedule form fields here...</div>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
  </div>
</template>
<script setup>
import { ref } from 'vue';
const scheduleType = ref('normal');
</script>

<script setup>
import Modal from '@/components/Modal.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, watch, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  show: Boolean
});
const emit = defineEmits(['close']);

const form = useForm({
  email: '',
});

const status = computed(() => form.recentlySuccessful ? form.status : null);
const statusMessage = ref('');

async function submit() {
  statusMessage.value = '';
  form.clearErrors();
  try {
    const response = await axios.post(route('password.email'), { email: form.email });
    statusMessage.value = response.data.status;
    if (statusMessage.value.includes('success')) form.reset();
  } catch (error) {
    if (error.response && error.response.data && error.response.data.status) {
      statusMessage.value = error.response.data.status;
    } else if (error.response && error.response.data && error.response.data.errors) {
      // Show validation error
      form.setError('email', error.response.data.errors.email?.[0] || 'An error occurred.');
    } else {
      statusMessage.value = 'An unexpected error occurred.';
    }
  }
}

watch(() => props.show, (val) => {
  if (!val) {
    form.reset();
    form.clearErrors();
  }
});
</script>

<template>
  <Modal :show="props.show" @close="emit('close')" maxWidth="sm">
    <div class="p-6 w-full max-w-sm">
      <h2 class="text-lg font-medium text-gray-900 mb-2">Forgot Password</h2>
      <p class="mb-4 text-sm text-gray-600">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
      </p>
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <InputLabel forId="email" value="Email" />
          <TextInput id="email" type="email" v-model="form.email" required autofocus autocomplete="username" class="mt-1 block w-full" aria-label="Email address" placeholder="Enter your email" />
          <InputError :message="form.errors.email" class="mt-2" />
        </div>
        <div v-if="statusMessage" class="mt-2 text-sm text-center" :class="{
          'text-green-600': statusMessage.includes('success'),
          'text-red-600': statusMessage.includes('not registered') || statusMessage.includes('Failed'),
          'text-gray-600': !statusMessage.includes('success') && !statusMessage.includes('not registered') && !statusMessage.includes('Failed')
        }">
          {{ statusMessage }}
        </div>
        <div class="flex flex-col items-center justify-center mt-4 gap-2">
          <PrimaryButton :disabled="form.processing" class="!text-xs">Email Password Reset Link</PrimaryButton>
          <button type="button" class="text-xs text-gray-400 hover:text-gray-600 mt-2" @click="emit('close')" aria-label="Cancel password reset modal">Cancel</button>
        </div>
      </form>
    </div>
  </Modal>
</template>

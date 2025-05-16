<script setup>
import Modal from '@/components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

const props = defineProps({
  show: Boolean
});
const emit = defineEmits(['close']);

const form = useForm({
  email: '',
});

function submit() {
  form.post(route('password.email'), {
    onSuccess: () => form.reset(),
  });
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
          <TextInput id="email" type="email" v-model="form.email" required autofocus autocomplete="username" class="mt-1 block w-full" aria-label="Email address" />
          <InputError :message="form.errors.email" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4 gap-2">
          <PrimaryButton :disabled="form.processing" class="!text-xs">Email Password Reset Link</PrimaryButton>
          <button type="button" class="text-xs text-gray-400 hover:text-gray-600 ml-2" @click="emit('close')" aria-label="Cancel password reset modal">Cancel</button>
        </div>
      </form>
    </div>
  </Modal>
</template>

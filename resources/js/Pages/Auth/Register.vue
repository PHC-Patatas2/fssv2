<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showPasswordConfirm = ref(false);

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel forId="name" value="Name" />
                <TextInput id="name" type="text" v-model="form.name" required autofocus autocomplete="name" class="mt-1 block w-full" aria-label="Full name" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="mt-4">
                <InputLabel forId="email" value="Email" />
                <TextInput id="email" type="email" v-model="form.email" required autocomplete="email" class="mt-1 block w-full" aria-label="Email address" />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="mt-4">
                <InputLabel forId="password" value="Password" />
                <div class="relative flex items-center">
                    <TextInput :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password" required autocomplete="new-password" class="mt-1 block w-full pr-12" aria-label="Password" />
                    <button type="button"
                        @click="showPassword = !showPassword"
                        class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center justify-center h-8 w-8 text-gray-400 hover:text-gray-600 focus:outline-none z-10 transition"
                        tabindex="-1"
                        :aria-label="showPassword ? 'Hide password' : 'Show password'"
                        style="background: none; box-shadow: none; border: none; transform: translateY(-45%); pointer-events: auto;">
                        <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592m3.31-2.252A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.21 5.442M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6 0l6 6m0-6l-6 6" /></svg>
                    </button>
                </div>
                <InputError :message="form.errors.password" class="mt-2" />
            </div>
            <div class="mt-4">
                <InputLabel forId="password_confirmation" value="Confirm Password" />
                <div class="relative flex items-center">
                    <TextInput :type="showPasswordConfirm ? 'text' : 'password'" id="password_confirmation" v-model="form.password_confirmation" required autocomplete="new-password" class="mt-1 block w-full pr-12" aria-label="Confirm password" />
                    <button type="button"
                        @click="showPasswordConfirm = !showPasswordConfirm"
                        class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center justify-center h-8 w-8 text-gray-400 hover:text-gray-600 focus:outline-none z-10 transition"
                        tabindex="-1"
                        :aria-label="showPasswordConfirm ? 'Hide password confirmation' : 'Show password confirmation'"
                        style="background: none; box-shadow: none; border: none; transform: translateY(-45%); pointer-events: auto;">
                        <svg v-if="!showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592m3.31-2.252A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.21 5.442M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6 0l6 6m0-6l-6 6" /></svg>
                    </button>
                </div>
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <PrimaryButton :disabled="form.processing">Register</PrimaryButton>
            </div>
        </form>
        <div class="mt-4 text-center">
            <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">Back to Login</Link>
        </div>
    </GuestLayout>
</template>

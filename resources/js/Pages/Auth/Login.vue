<template>
    <GuestLayout>
        <Head title="Log in" />
        <form @submit.prevent="submit" class="space-y-6 w-full max-w-xl">
            <div v-if="status" class="mb-4 text-sm text-gray-600">
                {{ status }}
            </div>
            <div>
                <span class="block text-xs text-gray-400 mb-1 ml-1">Email</span>
                <TextInput id="email" type="email" v-model="form.email" required autofocus autocomplete="email" class="mt-1 block w-full" placeholder="Enter your Email" />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="mt-4 relative">
                <span class="block text-xs text-gray-400 mb-1 ml-1">Password</span>
                <TextInput :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password" required autocomplete="current-password" class="mt-1 block w-full pr-10" placeholder="Enter your Password" />
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 focus:outline-none" tabindex="-1">
                    <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592m3.31-2.252A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.21 5.442M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6 0l6 6m0-6l-6 6" /></svg>
                </button>
                <InputError :message="form.errors.password" class="mt-2" />
            </div>
            <div class="mt-2 mb-6">
                <button type="button" @click="showForgot = true" class="text-xs text-gray-400 hover:text-gray-600 focus:outline-none">Forgot your password?</button>
            </div>
            <div class="flex flex-col gap-1">
                <PrimaryButton class="w-full h-10 text-base flex items-center justify-center mt-1" :disabled="form.processing">Log in</PrimaryButton>
            </div>
        </form>
        <div class="mt-4 text-center">
            <span class="text-xs text-gray-400">Don't have an account? </span>
            <Link :href="route('register')" class="underline text-xs text-gray-400 hover:text-gray-600">Sign up for the waitlist</Link>
        </div>
        <ForgotPasswordModal :show="showForgot" @close="showForgot = false" />
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ForgotPasswordModal from '@/Components/ForgotPasswordModal.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);
const showForgot = ref(false);

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>

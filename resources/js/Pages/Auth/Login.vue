<template>
    <GuestLayout>
        <Head title="Log in" />
        <Notification v-if="status && showNotification" :message="status" :show="showNotification" :duration="3000" @close="showNotification = false" />
        <form @submit.prevent="submit" class="w-full max-w-xl space-y-6">
            <div class="mt-4">
                <span class="block text-xs text-gray-400 mb-1 ml-1">Email</span>
                <TextInput id="email" type="email" v-model="form.email" required autofocus autocomplete="email" class="mt-1 block w-full" placeholder="Enter your Email" aria-label="Email address" />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="mt-4 relative pb-0 flex flex-col">
                <span class="block text-xs text-gray-400 mb-1 ml-1">Password</span>
                <div class="relative flex items-center">
                    <TextInput :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password" required autocomplete="current-password" class="mt-1 block w-full pr-12" placeholder="Enter your Password" aria-label="Password" />
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
            <button type="button" @click="showForgot = true" class="block ml-auto text-xs text-gray-400 hover:text-gray-600 focus:outline-none px-2 py-1" style="margin-top:2px;margin-bottom:10px;" aria-label="Forgot your password?">Forgot your password?</button>
            <div class="flex flex-col gap-1">
                <PrimaryButton class="w-full h-10 text-base flex items-center justify-center mt-1" :disabled="form.processing">
                    Log in
                </PrimaryButton>
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
import ForgotPasswordModal from '@/components/ForgotPasswordModal.vue';
import Notification from '@/components/Notification.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showForgot = ref(false);
const showNotification = ref(!!props.status);
const showPassword = ref(false);

let errorTimeout = null;
let emailErrorTimer = null;
let passwordErrorTimer = null;

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        onSuccess: () => {
            showNotification.value = false;
        },
        onError: () => {
            showNotification.value = true;
        },
    });
}

watch(() => props.status, (newStatus) => {
    if (newStatus) {
        showNotification.value = true;
    }
});

watch(() => form.errors.email, (val) => {
    if (emailErrorTimer) clearTimeout(emailErrorTimer);
    if (val) {
        emailErrorTimer = setTimeout(() => {
            form.clearErrors('email');
        }, 3000);
    } else {
        emailErrorTimer = null;
    }
});

watch(() => form.errors.password, (val) => {
    if (passwordErrorTimer) clearTimeout(passwordErrorTimer);
    if (val) {
        passwordErrorTimer = setTimeout(() => {
            form.clearErrors('password');
        }, 3000);
    } else {
        passwordErrorTimer = null;
    }
});

// Clear error immediately when user edits the field
watch(() => form.email, () => {
    if (form.errors.email) form.clearErrors('email');
});
watch(() => form.password, () => {
    if (form.errors.password) form.clearErrors('password');
});
</script>

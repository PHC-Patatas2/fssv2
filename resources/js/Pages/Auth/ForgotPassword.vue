<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />
        <div class="forgot-container">
            <div class="forgot-card">
                <div class="forgot-header">
                    <button @click="$inertia.visit(route('login'))" class="forgot-back">&#8592; Back</button>
                    <h2 class="forgot-title">Forgot Password</h2>
                </div>
                <div class="forgot-desc">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </div>
                <div v-if="status" class="forgot-status">
                    {{ status }}
                </div>
                <form @submit.prevent="submit" class="forgot-form">
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" v-model="form.email" required autofocus autocomplete="username" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <PrimaryButton :disabled="form.processing" class="forgot-btn">Email Password Reset Link</PrimaryButton>
                </form>
                <div class="forgot-footer">
                    <Link :href="route('login')" class="forgot-link">Back to Login</Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

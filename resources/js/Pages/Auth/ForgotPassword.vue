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

<style scoped>
.forgot-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    justify-content: center;
    background: #f3f3f3;
}
.forgot-card {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 2rem;
    margin-top: 1rem;
}
.forgot-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}
.forgot-back {
    background: none;
    border: none;
    color: #2563eb;
    font-size: 1.1rem;
    cursor: pointer;
    margin-right: 0.5rem;
}
.forgot-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    flex: 1;
    color: #222;
}
.forgot-desc {
    margin-bottom: 1rem;
    color: #555;
    font-size: 0.98rem;
}
.forgot-status {
    margin-bottom: 1rem;
    color: #059669;
    font-size: 0.98rem;
}
.forgot-form > div {
    margin-bottom: 1rem;
}
.forgot-btn {
    width: 100%;
    margin-top: 0.5rem;
}
.forgot-footer {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 1.5rem;
    gap: 0.5rem;
}
.forgot-link {
    color: #2563eb;
    text-decoration: underline;
    cursor: pointer;
    font-size: 0.95rem;
}
</style>

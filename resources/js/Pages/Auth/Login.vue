<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <div class="login-container">
            <div class="login-card">
                <h2 class="login-title">Login</h2>
                <form @submit.prevent="submit" class="login-form">
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div>
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
                        <InputError :message="form.errors.password" />
                    </div>
                    <div class="login-row">
                        <label>
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span>Remember me</span>
                        </label>
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="login-link"
                        >
                            Forgot password?
                        </Link>
                    </div>
                    <PrimaryButton
                        :disabled="form.processing"
                        class="login-btn"
                    >
                        Log in
                    </PrimaryButton>
                </form>
                <div class="login-footer">
                    <Link
                        :href="route('register')"
                        class="login-link"
                    >
                        Register as Scheduler
                    </Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.login-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    justify-content: center;
    background: #f3f3f3;
}
.login-card {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 2rem;
    margin-top: 1rem;
}
.login-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 1.5rem;
    color: #222;
}
.login-form > div {
    margin-bottom: 1rem;
}
.login-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}
.login-link {
    color: #2563eb;
    text-decoration: underline;
    cursor: pointer;
    font-size: 0.95rem;
}
.login-btn {
    width: 100%;
    margin-top: 0.5rem;
}
.login-footer {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 1.5rem;
    gap: 0.5rem;
}
</style>

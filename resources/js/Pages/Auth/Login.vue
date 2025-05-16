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

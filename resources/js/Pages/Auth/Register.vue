<template>
    <GuestLayout>
        <Head title="Register" />
        <div class="register-container">
            <div class="register-card">
                <div class="register-header">
                    <button @click="$inertia.visit(route('login'))" class="register-back">&#8592; Back</button>
                    <h2 class="register-title">Register</h2>
                </div>
                <form @submit.prevent="submit" class="register-form">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autocomplete="email"
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
                            autocomplete="new-password"
                        />
                        <InputError :message="form.errors.password" />
                    </div>
                    <div>
                        <InputLabel
                            for="password_confirmation"
                            value="Confirm Password"
                        />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        <InputError :message="form.errors.password_confirmation" />
                    </div>
                    <PrimaryButton
                        :disabled="form.processing"
                        class="register-btn"
                    >
                        Register
                    </PrimaryButton>
                </form>
                <div class="register-footer">
                    <Link
                        :href="route('login')"
                        class="register-link"
                    >
                        Back to Login
                    </Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<style scoped>
.register-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    justify-content: center;
    background: #f3f3f3;
}
.register-card {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 2rem;
    margin-top: 1rem;
}
.register-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}
.register-back {
    background: none;
    border: none;
    color: #2563eb;
    font-size: 1.1rem;
    cursor: pointer;
    margin-right: 0.5rem;
}
.register-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    flex: 1;
    color: #222;
}
.register-form > div {
    margin-bottom: 1rem;
}
.register-btn {
    width: 100%;
    margin-top: 0.5rem;
}
.register-footer {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 1.5rem;
    gap: 0.5rem;
}
.register-link {
    color: #2563eb;
    text-decoration: underline;
    cursor: pointer;
    font-size: 0.95rem;
}
</style>

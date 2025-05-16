<template>
    <GuestLayout>
        <Head title="Register" />
        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="name" value="Name" />
                <TextInput id="name" type="text" v-model="form.name" required autofocus autocomplete="name" class="mt-1 block w-full" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" v-model="form.email" required autocomplete="email" class="mt-1 block w-full" />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" v-model="form.password" required autocomplete="new-password" class="mt-1 block w-full" />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>
            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" class="mt-1 block w-full" />
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

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

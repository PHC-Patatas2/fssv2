<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

let emailErrorTimer = null;
let passwordErrorTimer = null;
let passwordConfirmErrorTimer = null;

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

watch(() => form.errors.password_confirmation, (val) => {
    if (passwordConfirmErrorTimer) clearTimeout(passwordConfirmErrorTimer);
    if (val) {
        passwordConfirmErrorTimer = setTimeout(() => {
            form.clearErrors('password_confirmation');
        }, 3000);
    } else {
        passwordConfirmErrorTimer = null;
    }
});

watch(() => form.email, () => {
    if (form.errors.email) form.clearErrors('email');
});
watch(() => form.password, () => {
    if (form.errors.password) form.clearErrors('password');
});
watch(() => form.password_confirmation, () => {
    if (form.errors.password_confirmation) form.clearErrors('password_confirmation');
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

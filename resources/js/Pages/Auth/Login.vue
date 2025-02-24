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

        <div class="flex min-h-screen items-center justify-center bg-gray-100">
            <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-center text-gray-700">Welcome Back</h2>
                <p class="text-sm text-center text-gray-500 mb-6">Sign in to continue</p>

                <div v-if="status" class="mb-4 text-sm font-medium text-green-600 text-center">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Email -->
                    <div>
                        <InputLabel for="email" value="Email Address" />
                        <TextInput id="email" type="email" class="w-full" v-model="form.email" required autofocus autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Password -->
                    <div>
                        <InputLabel for="password" value="Password" />
                        <TextInput id="password" type="password" class="w-full" v-model="form.password" required autocomplete="current-password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600">Remember me</span>
                        </label>

                        <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-indigo-600 hover:underline">
                            Forgot password?
                        </Link>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col items-center space-y-2">
                        <PrimaryButton :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>

                        <Link :href="route('register')" class="text-sm text-gray-600 hover:underline">
                            Don't have an account? Register
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

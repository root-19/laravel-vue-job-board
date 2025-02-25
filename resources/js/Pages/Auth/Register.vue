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
    role: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="flex min-h-screen items-center justify-center bg-gray-100 dark:bg-gray-900">
            <div class="w-full max-w-md  shadow-lg p-8">
                <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">
                    Create Your Account
                </h2>
                <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                    Join as a Job Seeker or an Employer.
                </p>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="name" value="Full Name" class="font-medium text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-md"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email Address" class="font-medium text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-md"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password" class="font-medium text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-md"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirm Password" class="font-medium text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-md"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="role" value="Register As" class="font-medium text-gray-700 dark:text-gray-300" />
                        <select
                            id="role"
                            v-model="form.role"
                            class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-md"
                            required
                            placeholder="select role"
                        >
                            <option value="job_seeker">Job Seeker</option>
                            <option value="employer">Employer</option>
                        </select>   
                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <Link
                            :href="route('login')"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:underline"
                        >
                            Already registered?
                        </Link>

                        <PrimaryButton
                            class="px-6 py-3 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-500 focus:ring-2 focus:ring-green-400 transition"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
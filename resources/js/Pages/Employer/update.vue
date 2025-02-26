<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

// Form data
const form = useForm({
    name: user.name,
    email: user.email,
    profile_image: null, // New profile image field
});

// Image preview
const previewImage = ref(user.profile_image ? `/storage/${user.profile_image}` : null);

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.profile_image = file;
        previewImage.value = URL.createObjectURL(file); // Preview the image
    }
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
            <p class="mt-1 text-sm text-gray-600">Update your profile information and email address.</p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6" enctype="multipart/form-data">



            <!-- Name -->
            <div>
                <InputLabel for="name" value="Name" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Profile Image Upload -->
            <div>
                <InputLabel for="profile_image" value="Profile Image" />
                <input type="file" id="profile_image" class="mt-2 block w-full" @change="handleImageUpload" accept="image/*">
                <InputError class="mt-2" :message="form.errors.profile_image" />

                <!-- Image Preview -->
                <div v-if="previewImage" class="mt-4">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Profile Preview:</p>
                    <img :src="previewImage" alt="Profile Preview" class="w-32 h-32 rounded-full object-cover">
                </div>
            </div>

            <!-- Email Verification Notice -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

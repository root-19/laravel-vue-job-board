<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    user: Object
});

// 🔹 Define `useForm`
const form = useForm({
    profile_image: null,
    cover_image: null
});

// 🔹 Image preview handlers
const profilePreview = ref(null);
const coverPreview = ref(null);
const showModal = ref(false);

// 🔹 Watch for updates and reset form after successful upload
watch(() => form.recentlySuccessful, (success) => {
    if (success) {
        showModal.value = true;
        form.reset();
    }
});

// 🔹 Handle profile image selection
const handleProfileImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        profilePreview.value = URL.createObjectURL(file);
        form.profile_image = file;
    }
};

// 🔹 Handle cover image selection
const handleCoverImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        coverPreview.value = URL.createObjectURL(file);
        form.cover_image = file;
    }
};

// 🔹 Fix PATCH method issue by using `transform` before `.post()`
const updateProfile = () => {
    form.transform((data) => ({
        _method: 'PATCH',  // Force PATCH method for Laravel
        ...data
    })).post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = true;
            profilePreview.value = null;
            coverPreview.value = null;
        },
        onError: () => {
            alert('Failed to update profile. Please try again.');
        }
    });
};
</script>


<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Profile</h2>
        </template>

        <!-- Profile Header Section -->
        <div class="relative w-full bg-gray-200">
            <!-- Cover Image -->
            <div class="h-60 w-full bg-cover bg-center relative flex justify-center items-center"
                :style="{ backgroundImage: `url(${coverPreview || user.cover_image || '/default-cover.jpg'})` }">
                <label class="absolute top-3 right-3 bg-white p-2 rounded-full cursor-pointer shadow-md">
                    <input type="file" class="hidden" @change="handleCoverImage">
                    <span class="text-sm font-semibold text-gray-600">Edit Cover</span>
                </label>
            </div>

            <!-- Profile Picture and Info -->
            <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-12 flex flex-col items-center">
                <label class="relative">
                    <img 
                        :src="profilePreview || user.profile_image || '/default-profile.jpg'" 
                        alt="Profile Image" 
                        class="w-24 h-24 rounded-full border-4 border-white shadow-lg" 
                    />
                    <input type="file" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer" @change="handleProfileImage">
                </label>
                
                <h1 class="mt-2 text-xl font-bold text-gray-800">{{ user.name }}</h1>
                <p class="text-gray-600">{{ user.role }}</p>
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-16 text-center">
            <button @click="updateProfile" 
                :disabled="form.processing"
                class="px-4 py-2 bg-green-600 text-white rounded shadow-md hover:bg-green-700 disabled:opacity-50">
                {{ form.processing ? 'Saving...' : 'Save Changes' }}
            </button>
        </div>

        <!-- Success Modal -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-lg font-bold">Profile Updated!</h2>
                <p class="text-gray-600 mt-2">Your profile image and cover have been updated successfully.</p>
                <button @click="showModal = false" class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    OK
                </button>
            </div>
        </div>

    </AuthenticatedLayout>
</template>


  <!-- Profile Sections -->
        <!-- <div class="py-20">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdateProfileInformationForm 
                        :must-verify-email="mustVerifyEmail" 
                        :status="status" 
                        class="max-w-xl" 
                    />
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div> -->
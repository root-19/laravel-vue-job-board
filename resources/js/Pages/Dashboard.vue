<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
    jobs: Array
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="max-w-5xl mx-auto p-8 bg-gray-100 min-h-screen">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Available Job Postings</h1>
            <!-- Job List (One Job per Row) -->
        <div class="space-y-8">
            <div v-for="job in jobs" :key="job.id" class="p-6 border rounded-lg shadow-md bg-gray-50 hover:shadow-lg transition">
                <p><strong>Employer:</strong> {{ job.employer_name }}</p>

                <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ job.title }}</h3>
                <p class="text-lg font-medium text-gray-600">{{ job.role }}</p>
                <p class="mt-2 text-gray-700 leading-relaxed">{{ job.description }}</p>

                <!-- Skills Section -->
                <div class="mt-4 bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-800 mb-1">🔹 <span class="underline">Skills Required:</span></p>
                    <p class="text-gray-600">{{ job.skills }}</p>
                </div>

                <!-- Qualifications Section -->
                <div class="mt-2 bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-800 mb-1">📌 <span class="underline">Qualifications:</span></p>
                    <p class="text-gray-600">{{ job.qualifications }}</p>
                </div>

                <!-- Job Image (Always Below) -->
                <div v-if="job.image" class="mt-5 flex justify-center">
    <div class="text-center">
        <p class="text-sm font-semibold text-gray-800 mb-2">🖼️ Job Image:</p>
        <img 
            :src="'/storage/' + job.image" 
            alt="Job Image" 
            class="rounded-lg max-w-full md:max-w-lg mx-auto"
        >
    </div>
</div>

            </div>
        </div>

            
        </div>
    </AuthenticatedLayout>
</template>


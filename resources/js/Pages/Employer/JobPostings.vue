<script setup>
import { useForm } from '@inertiajs/vue3';
import EmployerAuthenticatedLayout from '@/Layouts/EmployerAuthenticatedLayout.vue';
defineProps({ jobs: Array });
</script>
<template>
       <EmployerAuthenticatedLayout> 
    <div class="p-6 bg-white shadow-lg rounded-lg max-w-5xl mx-auto mt-10">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">
            {{ jobs && jobs.length > 0 ? 'Your Job Postings' : 'No Job Postings Yet' }}
        </h2>

        <!-- "Create a Job Posting" button (Always Visible) -->
        <div class="text-center mb-6">
            <a href="/employer/job-postings/create" 
               class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                Create a Job Posting
            </a>
        </div>

        <!-- Job List (One Job per Row) -->
        <div class="space-y-8">
            <div v-for="job in jobs" :key="job.id" class="p-6 border rounded-lg shadow-md bg-gray-50 hover:shadow-lg transition">
                <!-- <p><strong>Employer:</strong> {{ job.employer.name }}</p> -->
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
                <div v-if="job.image" class="mt-5">
                    <p class="text-sm font-semibold text-gray-800 mb-2">🖼️ Job Image:</p>
                    <img :src="'/storage/' + job.image" 
                         alt="Job Image" 
                         class="rounded-lg max-w-full md:max-w-lg">
                </div>
            </div>
        </div>
    </div>
</EmployerAuthenticatedLayout>
</template>


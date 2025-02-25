<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import EmployerAuthenticatedLayout from '@/Layouts/EmployerAuthenticatedLayout.vue';

const form = useForm({
    title: '',
    description: '',
    role: '',
    skills: '',
    qualifications: '',
    image: null
});

const imagePreview = ref(null);

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    form.image = file;

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submitForm = () => {
    form.post(route('employer.job_postings.store'));
};
</script>

<template>
    <EmployerAuthenticatedLayout>
        <div class="p-8 bg-white rounded-xl shadow-lg max-w-3xl mx-auto mt-10">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">🚀 Post a New Job</h2>

            <form @submit.prevent="submitForm" class="space-y-5">
                <!-- Job Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">📌 Job Title</label>
                    <input v-model="form.title" type="text" 
                           class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                           placeholder="Enter job title" required />
                </div>

                <!-- Job Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">📝 Job Description</label>
                    <textarea v-model="form.description" 
                              class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                              rows="4" placeholder="Describe the job" required></textarea>
                </div>

                <!-- Job Role -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">🎭 Job Role</label>
                    <input v-model="form.role" type="text" 
                           class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                           placeholder="Enter job role" required />
                </div>

                <!-- Skills Required -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">💡 Skills Required</label>
                    <textarea v-model="form.skills" 
                              class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                              rows="2" placeholder="List the skills needed" required></textarea>
                </div>

                <!-- Qualifications -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">🎓 Qualifications</label>
                    <textarea v-model="form.qualifications" 
                              class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                              rows="2" placeholder="Enter qualifications" required></textarea>
                </div>

                <!-- Image Upload with Preview -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">🖼️ Upload Job Image</label>
                    <input type="file" @change="handleImageUpload" 
                           class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    
                    <!-- Image Preview -->
                    <div v-if="imagePreview" class="mt-3">
                        <p class="text-xs text-gray-500">Preview:</p>
                        <img :src="imagePreview" alt="Selected Image" 
                             class="w-full h-40 object-cover rounded-lg shadow-md border">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 text-white font-semibold p-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                    ✅ Submit Job Posting
                </button>
            </form>
        </div>
    </EmployerAuthenticatedLayout>
</template>

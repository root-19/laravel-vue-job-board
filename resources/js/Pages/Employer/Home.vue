<script setup>
import EmployerAuthenticatedLayout from '@/Layouts/EmployerAuthenticatedLayout.vue';
// import EmployerAuthenticatedLayout from '../../Layouts/EmployerAuthenticatedLayout.vue';
import { defineProps } from 'vue';

defineProps({
    jobs: Array
});
import { Head } from '@inertiajs/vue3';


</script>

<template>
    <Head title="Employer Dashboard" />

    <EmployerAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Employer Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Welcome to the Employer Dashboard!</div>
                </div>
            </div>
        </div>
        
        
    </EmployerAuthenticatedLayout>
    
</template>
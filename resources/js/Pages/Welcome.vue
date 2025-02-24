<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>
<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:text-white/50 min-h-screen flex flex-col">
        <div class="flex flex-1 items-center justify-center selection:bg-[#FF2D20] selection:text-white px-6">
            <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 items-center gap-8">
                
                <!-- Image Section -->
                <div class="flex justify-center">
                    <img 
                        src="../../image/coding.png" 
                        alt="Coding Sticker" 
                        class="w-74 h-auto md:w-80 rounded-lg"
                    />
                </div>

                <!-- Text Content -->
                <main class="text-center md:text-left">
                    <h1 class="text-4xl font-extrabold text-black">
                        Welcome to <span class="text-green-500">Job Board</span>
                    </h1>
                    <p class="mt-6 text-lg leading-relaxed text-black">
                        Job Board is a next-generation job seeker system designed to connect talented professionals with top employers.  
                        Whether you're searching for your dream job or looking for the perfect candidate,  
                        our platform provides a seamless experience to explore job listings, submit applications, and connect with recruiters.
                    </p>
                    <p class="mt-4 text-black/60">
                        Sign up today and take the next step in your career with Job Board.
                    </p>

                    <!-- Let's Start Button -->
                    <div class="mt-8">
                        <Link
                            :href="route('register')"
                            class="bg-green-700 text-white px-6 py-3 rounded-md text-lg font-semibold shadow-md transition hover:bg-green-600 focus:ring-2 focus:ring-green-500 focus:outline-none"
                        >
                            Let's Start
                        </Link>
                    </div>
                </main>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-black py-6 text-center text-sm">
            <p>NextGen Solution - Powering Careers with <span class="font-bold text-[#FF2D20]">Job Board</span></p>
        </footer>
    </div>
</template>

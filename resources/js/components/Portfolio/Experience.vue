<script setup lang="ts">
const experiences = [
    {
        company: 'Provincial Government of Camarines Sur',
        position: 'Computer Programmer',
        period: 'January 2024 - Present',
        description: 'Develop and maintain web systems for different departments, address user feedback, and assist users with system navigation. Focus on creating efficient and user-friendly software solutions.'
    }
];
</script>

<template>
    <section id="experience" class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Experience</h2>
            <div class="space-y-8">
                <div v-for="exp in experiences" :key="exp.company"
                     class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ exp.position }}</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 mb-2">{{ exp.company }}</p>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ exp.period }}</p>
                    <p class="text-gray-600 dark:text-gray-300">{{ exp.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

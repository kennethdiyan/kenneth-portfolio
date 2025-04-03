<script setup lang="ts">
const education = [
    {
        school: 'Bicol University – Polangui',
        degree: 'Bachelor of Science in Information Technology',
        period: 'August 2019 – July 2023',
        details: 'Cum laude'
    },
    {
        school: 'Central Bicol State University of Agriculture',
        degree: 'Science, Technology, Engineering, and Mathematics',
        period: 'June 2012 – April 2019',
        details: ''
    }
];

const certifications = [
    {
        name: 'Civil Service Eligibility (Professional)',
        issuer: 'CSPC, Nabua, Camarines Sur',
        date: 'March 26, 2023',
        details: 'Rating: 81.33'
    }
];
</script>

<template>
    <section id="education" class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Education</h2>
            <div class="space-y-8">
                <div v-for="edu in education" :key="edu.school"
                     class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ edu.degree }}</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 mb-2">{{ edu.school }}</p>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ edu.period }}</p>
                    <p v-if="edu.details" class="text-gray-600 dark:text-gray-300">{{ edu.details }}</p>
                </div>
            </div>

            <!-- Certifications -->
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-12 mb-8">Certifications</h2>
            <div class="space-y-8">
                <div v-for="cert in certifications" :key="cert.name"
                     class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ cert.name }}</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 mb-2">{{ cert.issuer }}</p>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ cert.date }}</p>
                    <p v-if="cert.details" class="text-gray-600 dark:text-gray-300">{{ cert.details }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
const projects = [
    {
        title: 'POS System',
        description: 'Point of Sale system with inventory management capabilities',
        technologies: ['Laravel', 'Vue.js', 'MySQL'],
        image: '/images/project1.jpg',
        link: '#'
    },
    {
        title: 'Assessment Tools',
        description: 'Web-based assessment and evaluation system',
        technologies: ['Laravel', 'Vue.js', 'Tailwind CSS'],
        image: '/images/project2.jpg',
        link: '#'
    },
    {
        title: 'Department Management Systems',
        description: 'Various web systems for different government departments',
        technologies: ['Laravel', 'Livewire', 'Bootstrap'],
        image: '/images/project3.jpg',
        link: '#'
    }
];
</script>

<template>
    <section id="projects" class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="project in projects" :key="project.title"
                     class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden shadow-sm">
                    <div class="h-48 bg-gray-200 dark:bg-gray-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ project.title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ project.description }}</p>
                        <div class="flex flex-wrap gap-2">
                            <span v-for="tech in project.technologies" :key="tech"
                                  class="px-3 py-1 text-sm bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 rounded-full">
                                {{ tech }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

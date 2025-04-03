<script setup lang="ts">
import { ref, computed } from 'vue';

interface Skill {
    name: string;
    level: string;
    icon: string;
    color: string;
    category: string;
    description: string;
}

const selectedCategory = ref('all');

const skills: Skill[] = [
    {
        name: 'Laravel Framework',
        level: 'Advanced',
        icon: 'https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg',
        color: 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300',
        category: 'Backend',
        description: 'Expert in Laravel framework with extensive experience in building robust web applications'
    },
    {
        name: 'Vue.js 2',
        level: 'Advanced',
        icon: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg',
        color: 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300',
        category: 'Frontend',
        description: 'Proficient in Vue.js 2 development and state management'
    },
    {
        name: 'Vue.js 3',
        level: 'Advanced',
        icon: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg',
        color: 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300',
        category: 'Frontend',
        description: 'Experienced with Vue.js 3 Composition API and modern features'
    },
    {
        name: 'Livewire',
        level: 'Advanced',
        icon: 'https://laravel-livewire.com/img/twitter.png',
        color: 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300',
        category: 'Frontend',
        description: 'Skilled in building dynamic interfaces with Laravel Livewire'
    },
    {
        name: 'Tailwind CSS',
        level: 'Advanced',
        icon: 'https://www.vectorlogo.zone/logos/tailwindcss/tailwindcss-icon.svg',
        color: 'bg-cyan-100 dark:bg-cyan-900 text-cyan-600 dark:text-cyan-300',
        category: 'Frontend',
        description: 'Expert in utility-first CSS with Tailwind'
    },
    {
        name: 'Bootstrap',
        level: 'Advanced',
        icon: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg',
        color: 'bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300',
        category: 'Frontend',
        description: 'Proficient in Bootstrap framework and responsive design'
    },
    {
        name: 'Flutter',
        level: 'Intermediate',
        icon: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/flutter/flutter-original.svg',
        color: 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300',
        category: 'Mobile',
        description: 'Developing cross-platform mobile applications'
    },
    {
        name: 'HTML',
        level: 'Advanced',
        icon: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg',
        color: 'bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300',
        category: 'Frontend',
        description: 'Strong foundation in semantic HTML and accessibility'
    },
    {
        name: 'Database Design',
        level: 'Advanced',
        icon: 'https://www.vectorlogo.zone/logos/mysql/mysql-official.svg',
        color: 'bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300',
        category: 'Backend',
        description: 'Expert in database architecture and optimization'
    },
    {
        name: 'API Integration',
        level: 'Advanced',
        icon: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nodejs/nodejs-original.svg',
        color: 'bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300',
        category: 'Backend',
        description: 'Experienced in RESTful API design and integration'
    },
    {
        name: 'System Design',
        level: 'Advanced',
        icon: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg',
        color: 'bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300',
        category: 'Backend',
        description: 'Skilled in designing scalable system architectures'
    },
    {
        name: 'Version Control',
        level: 'Advanced',
        icon: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg',
        color: 'bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-300',
        category: 'Tools',
        description: 'Proficient in Git workflow and collaboration'
    }
];

const categories = computed(() => ['all', ...new Set(skills.map(skill => skill.category))]);

const filteredSkills = computed(() => {
    if (selectedCategory.value === 'all') return skills;
    return skills.filter(skill => skill.category === selectedCategory.value);
});

const getProgressColor = (level: string) => {
    switch (level) {
        case 'Advanced':
            return 'bg-green-500 dark:bg-green-400';
        case 'Intermediate':
            return 'bg-yellow-500 dark:bg-yellow-400';
        default:
            return 'bg-gray-500 dark:bg-gray-400';
    }
};

const getProgressWidth = (level: string) => {
    switch (level) {
        case 'Advanced':
            return '90%';
        case 'Intermediate':
            return '70%';
        default:
            return '50%';
    }
};
</script>

<template>
    <section id="skills" class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Skills & Technologies</h2>

            <!-- Category Filter -->
            <div class="flex flex-wrap gap-2 mb-8">
                <button v-for="category in categories"
                        :key="category"
                        @click="selectedCategory = category"
                        :class="[
                            'px-4 py-2 rounded-full text-sm font-medium transition-all duration-300',
                            selectedCategory === category
                                ? 'bg-indigo-600 text-white'
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'
                        ]">
                    {{ category.charAt(0).toUpperCase() + category.slice(1) }}
                </button>
            </div>

            <!-- Skills Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="skill in filteredSkills"
                     :key="skill.name"
                     class="group p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center mb-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-xl mr-4"
                             :class="skill.color">
                            <img :src="skill.icon"
                                 :alt="skill.name"
                                 :class="[
                                    skill.name === 'Laravel Framework' ? 'w-24 h-10' : 'w-10 h-10',
                                    'transition-transform duration-300 group-hover:scale-110'
                                 ]"
                                 onerror="this.src='https://cdn.jsdelivr.net/gh/devicons/devicon/icons/devicon/devicon-original.svg'">
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ skill.name }}</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ skill.category }}</span>
                        </div>
                    </div>

                    <!-- Skill Description -->
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">{{ skill.description }}</p>

                    <!-- Progress Bar -->
                    <div class="relative pt-1">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full"
                                      :class="skill.color">
                                    {{ skill.level }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all duration-500"
                                     :class="getProgressColor(skill.level)"
                                     :style="{ width: getProgressWidth(skill.level) }">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.group:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>

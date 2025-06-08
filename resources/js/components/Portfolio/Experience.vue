<script setup lang="ts">
import { useScrollAnimation } from '@/composables/useScrollAnimation';

interface Experience {
    company: string;
    position: string;
    period: string;
    description: string;
    achievements: string[];
    technologies: string[];
}

const experiences: Experience[] = [
    {
        company: 'Provincial Government of Camarines Sur',
        position: 'Computer Programmer',
        period: 'January 2024 - Present',
        description: 'Develop and maintain web systems for different departments, address user feedback, and assist users with system navigation. Focus on creating efficient and user-friendly software solutions.',
        achievements: [
            'Developed and maintained multiple web-based systems for various government departments',
            'Implemented user feedback to improve system functionality and user experience',
            'Provided technical support and training to system users',
            'Ensured system security and data integrity'
        ],
        technologies: ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS', 'REST API', 'Git']
    }
];

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.experience-header',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.experience-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6 },
        staggerDelay: 0.2
    }
]);
</script>

<template>
    <section id="experience" class="relative py-12 sm:py-16 lg:py-20 bg-slate-900/30">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)]"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="experience-header text-center mb-8 sm:mb-12 lg:mb-16 opacity-0 transform translate-y-[30px]">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-3 sm:mb-4">Experience</h2>
                <div class="w-16 sm:w-20 h-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded mx-auto"></div>
                <p class="text-gray-400 mt-4 sm:mt-6 max-w-2xl mx-auto text-sm sm:text-base">
                    My professional journey in web development and system programming.
                </p>
            </div>

            <div class="space-y-6 sm:space-y-8 lg:space-y-12">
                <div
                    v-for="(exp, index) in experiences"
                    :key="exp.company"
                    class="experience-card relative opacity-0 transform translate-y-[30px]"
                >
                    <div class="flex flex-col lg:flex-row gap-6 sm:gap-8">
                        <div class="lg:w-1/3">
                            <div class="sticky top-6 sm:top-8">
                                <div class="p-4 sm:p-6 bg-slate-900/60 backdrop-blur border border-slate-800 rounded-xl sm:rounded-2xl">
                                    <div class="flex flex-col sm:flex-row sm:items-center lg:flex-col lg:items-start justify-between mb-3 sm:mb-4">
                                        <span class="px-3 py-1 bg-cyan-500/20 border border-cyan-500/30 text-cyan-400 rounded-full text-xs sm:text-sm font-medium mb-2 sm:mb-0 lg:mb-2 self-start">
                                            Full-time
                                        </span>
                                        <span class="text-gray-400 text-xs sm:text-sm">{{ exp.period }}</span>
                                    </div>
                                    <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-1 sm:mb-2">{{ exp.position }}</h3>
                                    <p class="text-gray-300 font-medium text-sm sm:text-base">{{ exp.company }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-2/3 space-y-4 sm:space-y-6">
                            <div class="p-4 sm:p-6 lg:p-8 bg-slate-900/40 backdrop-blur border border-slate-800 rounded-xl sm:rounded-2xl">
                                <p class="text-gray-300 text-sm sm:text-base lg:text-lg leading-relaxed mb-4 sm:mb-6">{{ exp.description }}</p>

                                <div class="mb-4 sm:mb-6">
                                    <h4 class="text-base sm:text-lg font-semibold text-white mb-3 sm:mb-4">Key Achievements:</h4>
                                    <ul class="space-y-2 sm:space-y-3">
                                        <li v-for="achievement in exp.achievements" :key="achievement"
                                            class="flex items-start text-gray-300 text-sm sm:text-base">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-cyan-400 mr-2 sm:mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ achievement }}
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <h4 class="text-base sm:text-lg font-semibold text-white mb-3 sm:mb-4">Technologies Used:</h4>
                                    <div class="flex flex-wrap gap-2 sm:gap-3">
                                        <span v-for="tech in exp.technologies" :key="tech"
                                              class="px-2 sm:px-3 py-1 bg-slate-800/80 border border-slate-700 rounded-lg text-xs sm:text-sm text-cyan-400 font-medium">
                                            {{ tech }}
                                        </span>
                                    </div>
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
.animate-in {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

/* Hover effect for tech tags */
.rounded-full:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}
</style>

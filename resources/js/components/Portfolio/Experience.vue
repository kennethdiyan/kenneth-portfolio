<script setup lang="ts">
import { ref, onMounted } from 'vue';

interface Experience {
    company: string;
    position: string;
    period: string;
    description: string;
    logo: string;
    achievements: string[];
    technologies: string[];
}

const experiences: Experience[] = [
    {
        company: 'Provincial Government of Camarines Sur',
        position: 'Computer Programmer',
        period: 'January 2024 - Present',
        description: 'Develop and maintain web systems for different departments, address user feedback, and assist users with system navigation. Focus on creating efficient and user-friendly software solutions.',
        logo: '/images/pgcs-logo.png',
        achievements: [
            'Developed and maintained multiple web-based systems for various government departments',
            'Implemented user feedback to improve system functionality and user experience',
            'Provided technical support and training to system users',
            'Ensured system security and data integrity'
        ],
        technologies: [
            'Laravel',
            'Vue.js',
            'MySQL',
            'Tailwind CSS',
            'REST API',
            'Git'
        ]
    }
];

// Add refs for animation
const sectionRef = ref<HTMLElement | null>(null);
const experienceRefs = ref<HTMLElement[]>([]);

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    experienceRefs.value.forEach((ref) => {
        if (ref) {
            observer.observe(ref);
        }
    });
});
</script>

<template>
    <section id="experience" ref="sectionRef" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Work Experience
                </h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto text-lg">
                    My professional journey and key achievements
                </p>
            </div>

            <!-- Experience Cards -->
            <div class="space-y-12">
                <div v-for="(exp, index) in experiences"
                     :key="exp.company"
                     :ref="el => { if (el) experienceRefs[index] = el as HTMLElement }"
                     class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
                     :style="{ transitionDelay: `${index * 200}ms` }">
                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group">
                        <!-- Background Logo -->
                        <div class="absolute top-0 right-0 w-64 h-64 opacity-[0.4] dark:opacity-[0.04] transition-all duration-500 ease-out group-hover:w-96 group-hover:h-96 group-hover:opacity-[0.3] dark:group-hover:opacity-[0.06] transform translate-x-5 -translate-y-8">
                            <img :src="exp.logo" :alt="exp.company" class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-110">
                        </div>

                        <div class="relative p-8">
                            <!-- Header -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ exp.position }}
                                    </h3>
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ exp.period }}
                                    </span>
                                </div>
                                <p class="text-lg text-primary-600 dark:text-primary-400">
                                    {{ exp.company }}
                                </p>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 dark:text-gray-300 mb-8 relative z-10">
                                {{ exp.description }}
                            </p>

                            <!-- Two Column Layout for Achievements and Technologies -->
                            <div class="grid md:grid-cols-2 gap-8 relative z-10">
                                <!-- Achievements -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                        Key Achievements
                                    </h4>
                                    <ul class="space-y-3">
                                        <li v-for="achievement in exp.achievements"
                                            :key="achievement"
                                            class="flex items-start text-gray-600 dark:text-gray-300">
                                            <svg class="w-5 h-5 mr-2 text-primary-500 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ achievement }}
                                        </li>
                                    </ul>
                                </div>

                                <!-- Technologies -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                        Technologies Used
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        <span v-for="tech in exp.technologies"
                                              :key="tech"
                                              class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full transition-all duration-300 hover:bg-primary-50 dark:hover:bg-primary-900/20">
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

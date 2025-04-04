<script setup lang="ts">
import { ref, onMounted } from 'vue';

interface Education {
    school: string;
    degree: string;
    period: string;
    details: string;
    logo: string;
    color: string;
}

interface Certification {
    name: string;
    issuer: string;
    date: string;
    details: string;
    logo: string;
    color: string;
}

const education: Education[] = [
    {
        school: 'Bicol University – Polangui',
        degree: 'Bachelor of Science in Information Technology',
        period: 'August 2019 – July 2023',
        details: 'Cum laude',
        logo: '/images/bu-logo.png',
        color: 'blue'
    },
    {
        school: 'Central Bicol State University of Agriculture',
        degree: 'Science, Technology, Engineering, and Mathematics',
        period: 'June 2012 – April 2019',
        details: '',
        logo: '/images/cbsua-logo.png',
        color: 'green'
    }
];

const certifications: Certification[] = [
    {
        name: 'Civil Service Eligibility (Professional)',
        issuer: 'CSPC, Nabua, Camarines Sur',
        date: 'March 26, 2023',
        details: 'Rating: 81.33',
        logo: '/images/csc-logo.png',
        color: 'purple'
    }
];

// Add refs for animation
const sectionRef = ref<HTMLElement | null>(null);
const educationRefs = ref<HTMLElement[]>([]);
const certificationRefs = ref<HTMLElement[]>([]);

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

    // Observe education items
    educationRefs.value.forEach((ref) => {
        if (ref) {
            observer.observe(ref);
        }
    });

    // Observe certification items
    certificationRefs.value.forEach((ref) => {
        if (ref) {
            observer.observe(ref);
        }
    });
});

const getColorClasses = (color: string) => {
    const colors = {
        blue: 'from-blue-500 to-blue-600',
        green: 'from-green-500 to-green-600',
        purple: 'from-purple-500 to-purple-600'
    };
    return colors[color as keyof typeof colors] || 'from-primary-500 to-primary-600';
};
</script>

<template>
    <section id="education" ref="sectionRef" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto">
            <!-- Education Section -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text">
                        Education
                    </span>
                </h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto text-lg">
                    My academic journey and professional certifications
                </p>
            </div>

            <div class="space-y-12">
                <div v-for="(edu, index) in education"
                     :key="edu.school"
                     :ref="el => { if (el) educationRefs[index] = el as HTMLElement }"
                     class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
                     :style="{ transitionDelay: `${index * 200}ms` }">
                    <div class="relative bg-white dark:bg-gray-700 rounded-2xl shadow-lg overflow-hidden group">
                        <!-- Background Logo -->
                        <div class="absolute top-1/2 right-0 -translate-y-1/2 w-48 h-48 opacity-[0.35] dark:opacity-[0.15] transition-all duration-500 ease-out group-hover:w-56 group-hover:h-56 group-hover:opacity-[0.45] dark:group-hover:opacity-[0.25] transform translate-x-12">
                            <img :src="edu.logo" :alt="edu.school" class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-110">
                        </div>

                        <div class="relative p-8 z-10">
                            <div class="flex items-start space-x-6">
                                <!-- Institution Logo -->
                                <div class="flex-shrink-0">
                                    <div class="w-32 h-32 rounded-xl overflow-hidden bg-gradient-to-br shadow-lg"
                                         :class="getColorClasses(edu.color)">
                                        <img :src="edu.logo" :alt="edu.school" class="w-full h-full object-contain p-4">
                                    </div>
                                </div>

                                <!-- Education Details -->
                                <div class="flex-1 pt-2">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ edu.degree }}
                                    </h3>
                                    <p class="text-lg text-primary-600 dark:text-primary-400 mb-2">
                                        {{ edu.school }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ edu.period }}
                                    </p>
                                    <div v-if="edu.details"
                                         class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                                         :class="`bg-${edu.color}-100 dark:bg-${edu.color}-900/30 text-${edu.color}-700 dark:text-${edu.color}-300`">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ edu.details }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certifications Section -->
            <div class="mt-20">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                        Certifications
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto text-lg">
                        Professional certifications and achievements
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="(cert, index) in certifications"
                         :key="cert.name"
                         :ref="el => { if (el) certificationRefs[index] = el as HTMLElement }"
                         class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
                         :style="{ transitionDelay: `${index * 200}ms` }">
                        <div class="relative bg-white dark:bg-gray-700 rounded-2xl shadow-lg overflow-hidden group h-full">
                            <!-- Background Logo -->
                            <div class="absolute top-1/2 right-0 -translate-y-1/2 w-40 h-40 opacity-[0.35] dark:opacity-[0.15] transition-all duration-500 ease-out group-hover:w-48 group-hover:h-48 group-hover:opacity-[0.45] dark:group-hover:opacity-[0.25] transform translate-x-8">
                                <img :src="cert.logo" :alt="cert.name" class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-110">
                            </div>

                            <div class="relative p-8 z-10">
                                <!-- Certification Logo -->
                                <div class="flex items-center space-x-4 mb-6">
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-white shadow-md">
                                            <img :src="cert.logo" :alt="cert.name" class="w-full h-full object-contain p-2">
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                            {{ cert.name }}
                                        </h3>
                                        <p class="text-primary-600 dark:text-primary-400">
                                            {{ cert.issuer }}
                                        </p>
                                    </div>
                                </div>

                                <p class="text-gray-600 dark:text-gray-300 mb-4">
                                    {{ cert.date }}
                                </p>

                                <div v-if="cert.details"
                                     class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ cert.details }}
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
</style>

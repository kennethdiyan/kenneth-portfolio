<script setup lang="ts">
import { useScrollAnimation } from '@/composables/useScrollAnimation';

interface Education {
    school: string;
    degree: string;
    period: string;
    details: string;
    courses: string[];
}

interface Certification {
    name: string;
    issuer: string;
    date: string;
    details: string;
}

const education: Education[] = [
    {
        school: 'Bicol University – Polangui',
        degree: 'Bachelor of Science in Information Technology',
        period: 'August 2019 – July 2023',
        details: 'Cum laude',
        courses: [
            'Web Development',
            'Database Management Systems',
            'Software Engineering',
            'Computer Programming',
            'Systems Analysis and Design',
            'Information Security'
        ]
    },
    {
        school: 'Central Bicol State University of Agriculture',
        degree: 'Science, Technology, Engineering, and Mathematics',
        period: 'June 2012 – April 2019',
        details: '',
        courses: [
            'Advanced Mathematics',
            'Physics',
            'Chemistry',
            'Computer Science Fundamentals'
        ]
    }
];

const certifications: Certification[] = [
    {
        name: 'Civil Service Eligibility (Professional)',
        issuer: 'CSPC, Nabua, Camarines Sur',
        date: 'March 26, 2023',
        details: 'Rating: 81.33'
    }
];

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.education-header',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.education-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6 },
        staggerDelay: 0.2
    },
    {
        selector: '.certification-section',
        animation: { opacity: 1, x: 0 },
        options: { duration: 0.8, delay: 0.4 }
    }
]);
</script>

<template>
    <section id="education" class="relative py-12 sm:py-16 lg:py-20 bg-slate-950">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_20%,rgba(120,119,198,0.15),transparent_50%)]"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="education-header text-center mb-8 sm:mb-12 lg:mb-16 opacity-0 transform translate-y-[30px]">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-3 sm:mb-4">Education</h2>
                <div class="w-16 sm:w-20 h-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded mx-auto"></div>
                <p class="text-gray-400 mt-4 sm:mt-6 max-w-2xl mx-auto text-sm sm:text-base">
                    Academic foundation that shaped my development journey.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-12">
                <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                    <div
                        v-for="(edu, index) in education"
                        :key="edu.school"
                        class="education-card p-4 sm:p-6 lg:p-8 bg-slate-900/60 backdrop-blur border border-slate-800 rounded-xl sm:rounded-2xl hover:border-cyan-500/50 transition-all duration-300 opacity-0 transform translate-y-[50px]"
                    >
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between mb-4 sm:mb-6">
                            <div class="flex-1 mb-3 sm:mb-0">
                                <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-2">{{ edu.degree }}</h3>
                                <p class="text-cyan-400 font-semibold text-base sm:text-lg">{{ edu.school }}</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <span class="px-3 py-1 bg-cyan-500/20 border border-cyan-500/30 text-cyan-400 rounded-full text-xs sm:text-sm font-medium">
                                    {{ edu.period }}
                                </span>
                                <p v-if="edu.details" class="text-yellow-400 text-xs sm:text-sm mt-2 font-medium">{{ edu.details }}</p>
                            </div>
                        </div>

                        <div v-if="edu.courses.length > 0">
                            <h4 class="text-base sm:text-lg font-semibold text-white mb-3 sm:mb-4">Relevant Coursework:</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3">
                                <span v-for="course in edu.courses" :key="course"
                                      class="px-2 sm:px-3 py-2 bg-slate-800/80 border border-slate-700 rounded-lg text-xs sm:text-sm text-gray-300 text-center">
                                    {{ course }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="certification-section lg:col-span-1 opacity-0 transform translate-x-[50px]">
                    <div class="sticky top-6 sm:top-8 space-y-4 sm:space-y-6">
                        <div class="p-4 sm:p-6 bg-slate-900/40 backdrop-blur border border-slate-800 rounded-xl sm:rounded-2xl">
                            <h3 class="text-lg sm:text-xl font-bold text-white mb-4 sm:mb-6">Certifications</h3>
                            <div class="space-y-3 sm:space-y-4">
                                <div
                                    v-for="(cert, index) in certifications"
                                    :key="cert.name"
                                    class="p-3 sm:p-4 bg-slate-800/50 border border-slate-700 rounded-xl"
                                >
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between mb-2">
                                        <h4 class="font-semibold text-white text-sm sm:text-base mb-1 sm:mb-0">{{ cert.name }}</h4>
                                        <span class="text-xs text-gray-400">{{ cert.date }}</span>
                                    </div>
                                    <p class="text-gray-300 text-xs sm:text-sm mb-2">{{ cert.issuer }}</p>
                                    <p v-if="cert.details" class="text-yellow-400 text-xs font-medium">{{ cert.details }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 sm:p-6 bg-slate-900/40 backdrop-blur border border-slate-800 rounded-xl sm:rounded-2xl">
                            <h3 class="text-lg sm:text-xl font-bold text-white mb-3 sm:mb-4">Academic Focus</h3>
                            <p class="text-gray-300 text-xs sm:text-sm leading-relaxed">
                                Graduated Cum Laude with expertise in information technology,
                                demonstrating strong academic performance and dedication to excellence.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

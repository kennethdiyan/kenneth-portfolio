<script setup lang="ts">
import { useScrollAnimation } from '@/composables/useScrollAnimation';
import { computed } from 'vue';

interface PersonalInfo {
    id: number;
    label: string;
    value: string;
    is_active: boolean;
    sort_order: number;
}

interface ContactInfo {
    id: number;
    type: string;
    label: string;
    value: string;
    href: string;
    icon: string;
    is_active: boolean;
    sort_order: number;
}

const props = defineProps<{
    personalInfo: PersonalInfo[];
    contactInfo: ContactInfo[];
}>();

const highlights = [
    {
        title: 'Problem Solver',
        description: 'I love tackling complex challenges and finding elegant solutions that work.',
        icon: '🧩'
    },
    {
        title: 'Detail-Oriented',
        description: 'Every pixel, every line of code matters to create exceptional user experiences.',
        icon: '🎯'
    },
    {
        title: 'Continuous Learner',
        description: 'Technology evolves fast, and I make sure to stay ahead of the curve.',
        icon: '📚'
    }
];

// Get personal information from database
const personalInfoDisplay = computed(() => {
    const dbInfo = props.personalInfo.filter(info => info.is_active).sort((a, b) => a.sort_order - b.sort_order);

    if (dbInfo.length > 0) {
        return dbInfo.map(info => ({
            label: info.label,
            value: info.value
        }));
    }

    // Fallback to default
    return [
        { label: 'Name', value: 'Kenneth John C. Ribay' },
        { label: 'Age', value: '23 years old' },
        { label: 'Location', value: 'Philippines' },
        { label: 'Experience', value: '1+ Years' },
        { label: 'Languages', value: 'English, Filipino' },
        { label: 'Availability', value: 'Open to opportunities' }
    ];
});

const aboutDescription = computed(() => {
    return props.personalInfo.find(info =>
        info.label.toLowerCase() === 'about' ||
        info.label.toLowerCase() === 'description' ||
        info.label.toLowerCase() === 'bio'
    )?.value ||
    "I'm a passionate full-stack developer with expertise in Laravel and Vue.js. I enjoy creating clean, efficient solutions that solve real-world problems and enhance user experiences.";
});

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.about-header',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.about-personal',
        animation: { opacity: 1, x: 0 },
        options: { duration: 0.8, delay: 0.2 }
    },
    {
        selector: '.about-highlights',
        animation: { opacity: 1, x: 0 },
        options: { duration: 0.8, delay: 0.4 }
    },
    {
        selector: '.personal-info-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6 },
        staggerDelay: 0.1
    },
    {
        selector: '.about-connect-btn',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6, delay: 0.8 }
    },
    {
        selector: '.highlight-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6 },
        staggerDelay: 0.1
    },
    {
        selector: '.about-journey',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8, delay: 0.2 }
    },
    {
        selector: '.journey-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6 },
        staggerDelay: 0.1
    }
]);
</script>

<template>
    <section id="about" class="py-12 sm:py-16 lg:py-20 bg-slate-950 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="about-header text-center mb-12 sm:mb-16 lg:mb-20 opacity-0 transform translate-y-[30px]">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                    About <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Me</span>
                </h2>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-400 max-w-3xl mx-auto">
                    Get to know more about me, my background, and what drives my passion for development
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-16 xl:gap-20">
                <!-- Personal Information -->
                <div class="about-personal space-y-6 sm:space-y-8 lg:space-y-10 opacity-0 transform translate-x-[-50px]">
                    <div class="space-y-4 sm:space-y-6">
                        <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white">
                            Personal Information
                        </h3>
                        <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-400 leading-relaxed">
                            {{ aboutDescription }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 md:gap-6">
                        <div
                            v-for="(info, index) in personalInfoDisplay"
                            :key="info.label"
                            class="personal-info-card bg-slate-900/50 backdrop-blur border border-slate-800 rounded-lg sm:rounded-xl lg:rounded-2xl p-3 sm:p-4 md:p-6 hover:border-cyan-500/50 transition-all duration-300 group opacity-0 transform translate-y-[20px]"
                        >
                            <div class="text-xs sm:text-sm md:text-base text-gray-500 mb-1 sm:mb-2">{{ info.label }}</div>
                            <div class="text-sm sm:text-base md:text-lg lg:text-xl font-semibold text-white group-hover:text-cyan-400 transition-colors duration-300">{{ info.value }}</div>
                        </div>
                    </div>

                    <div class="about-connect-btn pt-4 sm:pt-6 lg:pt-8 opacity-0 transform translate-y-[20px]">
                        <a
                            href="#contact"
                            class="inline-flex items-center gap-2 sm:gap-3 px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full text-white font-semibold hover:from-cyan-400 hover:to-blue-500 transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-cyan-500/25 text-sm sm:text-base lg:text-lg"
                        >
                            <span>Let's Connect</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Highlights -->
                <div class="about-highlights space-y-6 sm:space-y-8 lg:space-y-10 opacity-0 transform translate-x-[50px]">
                    <div class="space-y-4 sm:space-y-6">
                        <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white">
                            What Makes Me Different
                        </h3>
                        <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-400 leading-relaxed">
                            Here are some key qualities that define my approach to development and problem-solving.
                        </p>
                    </div>

                    <div class="space-y-4 sm:space-y-6 lg:space-y-8">
                        <div
                            v-for="(highlight, index) in highlights"
                            :key="highlight.title"
                            class="highlight-card group relative bg-slate-900/30 backdrop-blur border border-slate-800/50 rounded-lg sm:rounded-xl lg:rounded-2xl p-4 sm:p-6 md:p-8 hover:bg-slate-900/50 hover:border-cyan-500/50 transition-all duration-300 opacity-0 transform translate-y-[30px]"
                        >
                            <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-blue-600/5 rounded-lg sm:rounded-xl lg:rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <div class="relative z-10 flex items-start gap-3 sm:gap-4 md:gap-6">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 bg-gradient-to-br from-cyan-500/20 to-blue-600/20 rounded-lg sm:rounded-xl flex items-center justify-center text-xl sm:text-2xl md:text-3xl group-hover:scale-110 transition-transform duration-300">
                                    {{ highlight.icon }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white group-hover:text-cyan-400 transition-colors duration-300 mb-2 sm:mb-3">
                                        {{ highlight.title }}
                                    </h4>
                                    <p class="text-xs sm:text-sm md:text-base lg:text-lg text-gray-400 leading-relaxed">
                                        {{ highlight.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Journey Section -->
            <div class="about-journey mt-12 sm:mt-16 lg:mt-20 text-center opacity-0 transform translate-y-[50px]">
                <div class="max-w-4xl mx-auto">
                    <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6 lg:mb-8">
                        My <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Journey</span>
                    </h3>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-400 leading-relaxed mb-6 sm:mb-8 lg:mb-10">
                        My journey in web development started with curiosity and has evolved into a passion for creating
                        meaningful digital experiences. Every project teaches me something new, and I believe that
                        continuous learning is the key to staying relevant in this ever-evolving field.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                        <div class="journey-card bg-slate-900/50 backdrop-blur border border-slate-800 rounded-lg sm:rounded-xl lg:rounded-2xl p-4 sm:p-6 md:p-8 hover:border-cyan-500/50 transition-all duration-300 group opacity-0 transform translate-y-[20px]">
                            <div class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-cyan-400 mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300">2019</div>
                            <div class="text-sm sm:text-base md:text-lg text-white font-semibold mb-1 sm:mb-2">Started Journey</div>
                            <div class="text-xs sm:text-sm md:text-base text-gray-400">Began learning web development</div>
                        </div>

                        <div class="journey-card bg-slate-900/50 backdrop-blur border border-slate-800 rounded-lg sm:rounded-xl lg:rounded-2xl p-4 sm:p-6 md:p-8 hover:border-cyan-500/50 transition-all duration-300 group opacity-0 transform translate-y-[20px]">
                            <div class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-cyan-400 mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300">2023</div>
                            <div class="text-sm sm:text-base md:text-lg text-white font-semibold mb-1 sm:mb-2">First Projects</div>
                            <div class="text-xs sm:text-sm md:text-base text-gray-400">Built initial web applications</div>
                        </div>

                        <div class="journey-card bg-slate-900/50 backdrop-blur border border-slate-800 rounded-lg sm:rounded-xl lg:rounded-2xl p-4 sm:p-6 md:p-8 hover:border-cyan-500/50 transition-all duration-300 group opacity-0 transform translate-y-[20px]">
                            <div class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-cyan-400 mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300">2024</div>
                            <div class="text-sm sm:text-base md:text-lg text-white font-semibold mb-1 sm:mb-2">Growing Expertise</div>
                            <div class="text-xs sm:text-sm md:text-base text-gray-400">Specializing in Laravel & Vue.js</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.bg-grid-gray-100 {
    background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px),
                     linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
    background-size: 24px 24px;
}

.bg-grid-gray-800 {
    background-image: linear-gradient(to right, #1f2937 1px, transparent 1px),
                     linear-gradient(to bottom, #1f2937 1px, transparent 1px);
    background-size: 24px 24px;
}

.bg-grid-purple {
    background-image: linear-gradient(to right, rgba(147, 51, 234, 0.1) 1px, transparent 1px),
                     linear-gradient(to bottom, rgba(147, 51, 234, 0.1) 1px, transparent 1px);
    background-size: 16px 16px;
}

/* New animation styles */
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.prose {
    max-width: none;
}
</style>

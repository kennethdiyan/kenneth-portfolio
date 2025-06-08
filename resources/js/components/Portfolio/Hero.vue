<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

interface PersonalInfo {
    id: number;
    label: string;
    value: string;
    is_active: boolean;
    sort_order: number;
}

const props = defineProps<{
    personalInfo: PersonalInfo[];
}>();

const currentRole = ref('');

// Get roles from database or fallback to default
const roles = computed(() => {
    const rolesFromDb = props.personalInfo.find(info => info.label.toLowerCase() === 'roles')?.value;
    if (rolesFromDb) {
        return rolesFromDb.split(',').map(role => role.trim());
    }
    return [
        'Full Stack Developer',
        'Laravel Specialist',
        'Vue.js Developer',
        'Web Developer'
    ];
});

// Get stats from database
const stats = computed(() => {
    const experience = props.personalInfo.find(info => info.label.toLowerCase() === 'experience')?.value || '1+';
    const projectsCount = props.personalInfo.find(info => info.label.toLowerCase() === 'projects')?.value || '10+';
    const technologies = props.personalInfo.find(info => info.label.toLowerCase() === 'technologies')?.value || '3+';

    return [
        { value: experience.includes('Year') ? experience.split(' ')[0] + '+' : experience, label: 'Years' },
        { value: projectsCount, label: 'Projects' },
        { value: technologies, label: 'Technologies' },
        { value: '100%', label: 'Dedication' }
    ];
});

// Get personal info for display
const fullName = computed(() => {
    const firstName = props.personalInfo.find(info => info.label.toLowerCase() === 'first name')?.value || 'Kenneth John';
    const lastName = props.personalInfo.find(info => info.label.toLowerCase() === 'last name')?.value || 'C. Ribay';
    return { firstName, lastName };
});

const description = computed(() => {
    return props.personalInfo.find(info => info.label.toLowerCase() === 'description' || info.label.toLowerCase() === 'bio')?.value ||
           'Passionate about creating efficient and user-friendly web applications. Specialized in Laravel, Vue.js, and modern web technologies.';
});

const socialLinks = [
    {
        name: 'GitHub',
        url: 'https://github.com/kennethjohnribay',
        icon: `<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
              </svg>`
    },
    {
        name: 'LinkedIn',
        url: 'https://linkedin.com/in/kennethjohnribay',
        icon: `<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>`
    },
    {
        name: 'Facebook',
        url: 'https://facebook.com/kennethjohn.ribay',
        icon: `<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>`
    }
];

const typeRole = (role: string) => {
    currentRole.value = '';
    let i = 0;
    const timer = setInterval(() => {
        currentRole.value += role[i];
        i++;
        if (i === role.length) {
            clearInterval(timer);
        }
    }, 100);
};

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.hero-content',
        animation: { opacity: 1, x: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.hero-terminal',
        animation: { opacity: 1, x: 0 },
        options: { duration: 1, delay: 0.2 }
    },
    {
        selector: '.hero-greeting',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6, delay: 0.1 }
    },
    {
        selector: '.hero-title',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8, delay: 0.2 }
    },
    {
        selector: '.hero-role',
        animation: { opacity: 1 },
        options: { duration: 1, delay: 0.4 }
    },
    {
        selector: '.hero-description',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6, delay: 0.5 }
    },
    {
        selector: '.hero-stats',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8, delay: 0.6 }
    },
    {
        selector: '.hero-buttons',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6, delay: 0.7 }
    },
    {
        selector: '.hero-social',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8, delay: 0.8 }
    },
    {
        selector: '.hero-scroll',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8, delay: 1 }
    }
]);

onMounted(() => {
    let currentIndex = 0;
    const rolesList = roles.value;
    typeRole(rolesList[currentIndex]);

    setInterval(() => {
        currentIndex = (currentIndex + 1) % rolesList.length;
        typeRole(rolesList[currentIndex]);
    }, 3000);
});
</script>

<template>
    <section class="min-h-screen relative flex items-center bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(120,119,198,0.3),transparent_50%),radial-gradient(circle_at_80%_80%,rgba(255,119,198,0.3),transparent_50%)]"></div>

        <div class="relative w-full max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12 lg:gap-16 items-center">
                <!-- Content Section -->
                <div class="hero-content lg:col-span-7 order-2 lg:order-1 opacity-0 transform translate-x-[-50px]">
                    <div class="space-y-6 sm:space-y-8 lg:space-y-10 text-center lg:text-left">
                        <div class="space-y-3 sm:space-y-4 lg:space-y-6">
                            <div class="hero-greeting text-cyan-400 text-xs sm:text-sm md:text-base lg:text-lg font-mono tracking-wider opacity-0 transform translate-y-[20px]">
                                {{ `< Hello World />` }}
                            </div>

                            <h1 class="hero-title text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight opacity-0 transform translate-y-[30px]">
                                <span class="block text-white">{{ fullName.firstName }}</span>
                                <span class="block bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent">{{ fullName.lastName }}</span>
                            </h1>

                            <div class="hero-role h-8 sm:h-10 md:h-12 lg:h-14 opacity-0">
                                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-300 font-mono">
                                    <span class="text-cyan-400">></span> {{ currentRole }}
                                    <span class="animate-pulse text-cyan-400">_</span>
                                </p>
                            </div>
                        </div>

                        <p class="hero-description text-sm sm:text-base md:text-lg lg:text-xl max-w-xl mx-auto lg:mx-0 leading-relaxed text-gray-400 opacity-0 transform translate-y-[20px]">
                            {{ description }}
                        </p>

                        <div class="hero-stats grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 opacity-0 transform translate-y-[30px]">
                            <div v-for="stat in stats" :key="stat.label"
                                 class="p-3 sm:p-4 md:p-5 lg:p-6 bg-slate-900/50 backdrop-blur border border-slate-800 rounded-xl sm:rounded-2xl hover:border-cyan-500/50 transition-all duration-300">
                                <div class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-cyan-400">{{ stat.value }}</div>
                                <div class="text-xs sm:text-sm md:text-base text-gray-400 mt-1">{{ stat.label }}</div>
                            </div>
                        </div>

                        <div class="hero-buttons flex flex-col sm:flex-row gap-4 sm:gap-6 justify-center lg:justify-start opacity-0 transform translate-y-[20px]">
                            <a href="#contact"
                               class="group px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full text-white font-semibold hover:from-cyan-400 hover:to-blue-500 transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-cyan-500/25 text-sm sm:text-base lg:text-lg">
                                <span class="flex items-center justify-center gap-2">
                                    Let's Talk
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </span>
                            </a>
                            <a href="#projects"
                               class="px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 border border-slate-700 rounded-full text-white font-semibold hover:border-cyan-500 hover:bg-slate-900/50 transition-all duration-300 text-sm sm:text-base lg:text-lg">
                                View Projects
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Terminal Section -->
                <div class="hero-terminal lg:col-span-5 order-1 lg:order-2 opacity-0 transform translate-x-[50px]">
                    <div class="relative max-w-sm sm:max-w-md lg:max-w-lg mx-auto">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/20 to-purple-600/20 rounded-2xl blur-2xl"></div>
                            <div class="relative bg-slate-900/90 backdrop-blur border border-slate-700 rounded-2xl p-4 sm:p-6 lg:p-8 font-mono text-sm sm:text-base">
                                <div class="flex items-center gap-2 mb-4 sm:mb-6">
                                    <div class="w-3 h-3 sm:w-4 sm:h-4 bg-red-500 rounded-full"></div>
                                    <div class="w-3 h-3 sm:w-4 sm:h-4 bg-yellow-500 rounded-full"></div>
                                    <div class="w-3 h-3 sm:w-4 sm:h-4 bg-green-500 rounded-full"></div>
                                    <span class="ml-auto text-gray-500 text-xs sm:text-sm">terminal</span>
                                </div>

                                <div class="space-y-2 sm:space-y-3 text-gray-300">
                                    <div class="flex items-center">
                                        <span class="text-green-400">kenneth@portfolio</span>
                                        <span class="text-white">:</span>
                                        <span class="text-blue-400">~</span>
                                        <span class="text-white">$ </span>
                                        <span class="ml-1">whoami</span>
                                    </div>
                                    <div class="text-cyan-400">Full Stack Developer</div>

                                    <div class="flex items-center">
                                        <span class="text-green-400">kenneth@portfolio</span>
                                        <span class="text-white">:</span>
                                        <span class="text-blue-400">~</span>
                                        <span class="text-white">$ </span>
                                        <span class="ml-1">ls skills/</span>
                                    </div>
                                    <div class="text-purple-400">laravel/ vue.js/ tailwind/ mysql/</div>

                                    <div class="flex items-center">
                                        <span class="text-green-400">kenneth@portfolio</span>
                                        <span class="text-white">:</span>
                                        <span class="text-blue-400">~</span>
                                        <span class="text-white">$ </span>
                                        <span class="ml-1">cat motivation.txt</span>
                                    </div>
                                    <div class="text-yellow-400">Building amazing web experiences</div>

                                    <div class="flex items-center mt-2 sm:mt-4">
                                        <span class="text-green-400">kenneth@portfolio</span>
                                        <span class="text-white">:</span>
                                        <span class="text-blue-400">~</span>
                                        <span class="text-white">$ </span>
                                        <span class="ml-1 animate-pulse">_</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hero-social flex justify-center mt-6 sm:mt-8 lg:mt-10 space-x-4 sm:space-x-6 opacity-0 transform translate-y-[20px]">
                            <a v-for="social in socialLinks"
                               :key="social.name"
                               :href="social.url"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 flex items-center justify-center bg-slate-800/50 border border-slate-700 rounded-xl sm:rounded-2xl text-gray-400 hover:text-cyan-400 hover:border-cyan-500/50 hover:bg-slate-700/50 transition-all duration-300"
                               v-html="social.icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="hero-scroll absolute bottom-6 sm:bottom-8 lg:bottom-12 left-1/2 transform -translate-x-1/2 hidden lg:flex flex-col items-center space-y-2 opacity-0 translate-y-[20px]">
            <span class="text-gray-400 text-sm">scroll down</span>
            <svg class="w-5 h-5 text-cyan-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
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

@keyframes float {
    0% { transform: translateY(0px) rotate(12deg); }
    50% { transform: translateY(-20px) rotate(12deg); }
    100% { transform: translateY(0px) rotate(12deg); }
}

@keyframes floatDelay {
    0% { transform: translateY(0px) rotate(-12deg); }
    50% { transform: translateY(-20px) rotate(-12deg); }
    100% { transform: translateY(0px) rotate(-12deg); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delay {
    animation: floatDelay 6s ease-in-out infinite;
    animation-delay: 1s;
}

@keyframes expand {
    from { transform: scaleX(0); }
    to { transform: scaleX(1); }
}

.animate-expand {
    animation: expand 1.5s ease-out forwards;
}

@keyframes float-0 {
    0%, 100% { transform: translate(0, 0) rotate(-2deg); }
    50% { transform: translate(0, -20px) rotate(2deg); }
}

@keyframes float-1 {
    0%, 100% { transform: translate(0, 0) rotate(2deg); }
    50% { transform: translate(0, -15px) rotate(-2deg); }
}

@keyframes float-2 {
    0%, 100% { transform: translate(0, 0) rotate(-1deg); }
    50% { transform: translate(0, -25px) rotate(1deg); }
}

@keyframes float-3 {
    0%, 100% { transform: translate(0, 0) rotate(1deg); }
    50% { transform: translate(0, -18px) rotate(-1deg); }
}

.animate-float-0 {
    animation: float-0 6s ease-in-out infinite;
}

.animate-float-1 {
    animation: float-1 7s ease-in-out infinite;
}

.animate-float-2 {
    animation: float-2 8s ease-in-out infinite;
}

.animate-float-3 {
    animation: float-3 9s ease-in-out infinite;
}
</style>

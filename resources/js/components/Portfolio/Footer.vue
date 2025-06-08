<script setup lang="ts">
import { useScrollAnimation } from '@/composables/useScrollAnimation';

const currentYear = new Date().getFullYear();

const quickLinks = [
    { name: 'About', href: '#about' },
    { name: 'Skills', href: '#skills' },
    { name: 'Projects', href: '#projects' },
    { name: 'Contact', href: '#contact' }
];

const technologies = [
    { name: 'Laravel', icon: '🚀' },
    { name: 'Vue.js', icon: '💚' },
    { name: 'Tailwind CSS', icon: '🎨' },
    { name: 'MySQL', icon: '🗄️' },
    { name: 'JavaScript', icon: '⚡' },
    { name: 'PHP', icon: '🐘' }
];

const socialLinks = [
    {
        name: 'GitHub',
        url: 'https://github.com/kennethjohnribay',
        icon: 'github'
    },
    {
        name: 'LinkedIn',
        url: 'https://linkedin.com/in/kennethjohnribay',
        icon: 'linkedin'
    },
    {
        name: 'Facebook',
        url: 'https://facebook.com/kennethjohn.ribay',
        icon: 'facebook'
    }
];

const getSocialIcon = (iconType: string) => {
    const icons: Record<string, string> = {
        github: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path></svg>`,
        linkedin: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z" clip-rule="evenodd"></path></svg>`,
        facebook: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"></path></svg>`
    };
    return icons[iconType] || '';
};

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.footer-content',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    }
]);
</script>

<template>
    <footer class="bg-slate-950 border-t border-slate-800 px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16">
        <div class="max-w-7xl mx-auto">
            <div class="footer-content grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-12 lg:gap-16 mb-8 sm:mb-12 lg:mb-16 opacity-0 transform translate-y-[30px]">
                <!-- Brand Section -->
                <div class="space-y-4 sm:space-y-6">
                    <div class="space-y-3 sm:space-y-4">
                        <h3 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold">
                            <span class="text-white">Kenneth</span>
                            <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Dev</span>
                        </h3>
                        <p class="text-sm sm:text-base md:text-lg text-gray-400 leading-relaxed">
                            Full-Stack Developer passionate about creating efficient and user-friendly web applications.
                        </p>
                    </div>

                    <!-- Social Links -->
                    <div class="flex gap-3 sm:gap-4">
                        <a
                            v-for="social in socialLinks"
                            :key="social.name"
                            :href="social.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl hover:border-cyan-500/50 hover:bg-slate-700/50 transition-all duration-300 hover:scale-110"
                            :title="social.name"
                        >
                            <div class="w-5 h-5 sm:w-6 sm:h-6 text-gray-300 hover:text-cyan-400 transition-colors duration-300" v-html="getSocialIcon(social.icon)"></div>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4 sm:space-y-6">
                    <h4 class="text-lg sm:text-xl md:text-2xl font-bold text-white">Quick Links</h4>
                    <nav class="flex flex-col space-y-2 sm:space-y-3">
                        <a
                            v-for="link in quickLinks"
                            :key="link.name"
                            :href="link.href"
                            class="text-sm sm:text-base md:text-lg text-gray-400 hover:text-cyan-400 transition-colors duration-300 w-fit"
                        >
                            {{ link.name }}
                        </a>
                    </nav>
                </div>

                <!-- Technologies -->
                <div class="space-y-4 sm:space-y-6 sm:col-span-2 lg:col-span-1">
                    <h4 class="text-lg sm:text-xl md:text-2xl font-bold text-white">Technologies</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 gap-2 sm:gap-3">
                        <div
                            v-for="tech in technologies"
                            :key="tech.name"
                            class="flex items-center gap-2 sm:gap-3 px-3 py-2 sm:px-4 sm:py-3 bg-slate-800/30 border border-slate-700/50 rounded-lg sm:rounded-xl hover:bg-slate-700/30 hover:border-cyan-500/50 transition-all duration-300 group"
                        >
                            <span class="text-base sm:text-lg group-hover:scale-110 transition-transform duration-300">{{ tech.icon }}</span>
                            <span class="text-xs sm:text-sm md:text-base text-gray-300 group-hover:text-cyan-400 transition-colors duration-300">{{ tech.name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-800 mb-6 sm:mb-8" />

            <!-- Bottom Section -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-6">
                <div class="text-center sm:text-left">
                    <p class="text-xs sm:text-sm md:text-base text-gray-400">
                        © {{ currentYear }} Kenneth John C. Ribay. All rights reserved.
                    </p>
                </div>

                <div class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base text-gray-400">
                    <span>Made with</span>
                    <span class="text-red-400 animate-pulse">♥</span>
                    <span>using Laravel & Vue.js</span>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
.bg-grid-gray-900\/5 {
    background-image: linear-gradient(to right, rgb(17 24 39 / 0.05) 1px, transparent 1px),
                      linear-gradient(to bottom, rgb(17 24 39 / 0.05) 1px, transparent 1px);
}

.bg-grid-white\/5 {
    background-image: linear-gradient(to right, rgb(255 255 255 / 0.05) 1px, transparent 1px),
                      linear-gradient(to bottom, rgb(255 255 255 / 0.05) 1px, transparent 1px);
}

@keyframes float {
    0% { transform: translate(0, 0); }
    50% { transform: translate(-10px, -10px); }
    100% { transform: translate(0, 0); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float 6s ease-in-out infinite;
    animation-delay: -3s;
}

.social-link {
    @apply p-2 text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200 hover:scale-110 transform bg-white dark:bg-gray-800 rounded-full shadow-lg hover:shadow-xl;
}

.footer-link {
    @apply text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200;
}

.contact-item {
    @apply flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200;
}

.contact-text {
    @apply hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200;
}
</style>

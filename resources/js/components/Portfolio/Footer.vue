<script setup lang="ts">
import { useScrollAnimation } from '@/composables/useScrollAnimation';
import { computed } from 'vue';

interface SocialLink {
    id: number;
    name: string;
    url: string;
    icon: string;
    is_active: boolean;
    sort_order: number;
}

const props = defineProps<{
    socialLinks: SocialLink[];
}>();

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

// Filter and sort active social links
const activeSocialLinks = computed(() => {
    return props.socialLinks
        .filter(link => link.is_active)
        .sort((a, b) => a.sort_order - b.sort_order);
});

const getSocialIcon = (iconType: string) => {
    const icons: Record<string, string> = {
        github: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path></svg>`,
        linkedin: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z" clip-rule="evenodd"></path></svg>`,
        facebook: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"></path></svg>`,
        twitter: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"></path></svg>`,
        instagram: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zm4.125 5.688a1.188 1.188 0 100-2.375 1.188 1.188 0 000 2.375zM10 14.375a4.375 4.375 0 110-8.75 4.375 4.375 0 010 8.75zm0-7.5a3.125 3.125 0 100 6.25 3.125 3.125 0 000-6.25z" clip-rule="evenodd"></path></svg>`,
        youtube: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.23 7.1c.363-.363.363-.952 0-1.315L11.315.87a.932.932 0 00-1.315 0L5.085 5.785c-.363.363-.363.952 0 1.315L10 12.015 16.23 7.1zM10 4l3.5 3.5L10 11 6.5 7.5 10 4z" clip-rule="evenodd"></path></svg>`,
        discord: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M16.942 6.478c-1.29-.606-2.656-1.05-4.078-1.29-.177.315-.374.728-.513 1.057a15.175 15.175 0 00-4.573 0c-.14-.329-.34-.742-.519-1.057-1.422.24-2.787.684-4.078 1.29C.484 9.718-.29 12.915.09 16.064c1.748 1.286 3.44 2.064 5.103 2.582.412-.561.778-1.156 1.094-1.777-.6-.226-1.173-.505-1.714-.832.143-.106.285-.217.421-.33a10.837 10.837 0 009.013 0c.136.113.278.224.421.33-.541.327-1.114.606-1.714.832.316.621.682 1.216 1.094 1.777 1.663-.518 3.355-1.296 5.103-2.582.45-3.65-.755-6.818-3.196-9.586zM6.678 13.482c-1.066 0-1.946-.98-1.946-2.184s.854-2.184 1.946-2.184c1.092 0 1.972.98 1.946 2.184 0 1.204-.854 2.184-1.946 2.184zm6.644 0c-1.066 0-1.946-.98-1.946-2.184s.854-2.184 1.946-2.184c1.092 0 1.972.98 1.946 2.184 0 1.204-.854 2.184-1.946 2.184z"></path></svg>`,
        telegram: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1010 10A10.011 10.011 0 0010 0zm4.54 6.89L12.84 14.2c-.18.8-.65 1-.32 1.02l.73-.57 1.1 1.14c.12.13.22.2.44.2.29 0 .42-.14.59-.6l2.17-10.23c.18-.79-.3-1.14-.8-.93L2.54 8.66c-.87.35-.86.85-.15 1.07l2.9.9 6.76-4.26c.32-.2.61-.09.37.12z"></path></svg>`,
        whatsapp: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M10.015 0C4.5 0 .029 4.472.029 9.987c0 1.762.459 3.416 1.257 4.85L.03 20l5.275-1.237A9.93 9.93 0 0010.015 20c5.515 0 9.985-4.472 9.985-9.987S15.53.001 10.015.001zM15.5 14.152c-.233.655-1.381 1.2-1.896 1.281-.514.08-1.15.037-1.85-.193-.428-.14-1.05-.326-1.794-.638-3.13-1.311-5.175-4.46-5.33-4.664-.155-.205-1.268-1.687-1.268-3.22 0-1.532.8-2.287 1.086-2.6.286-.313.624-.392.832-.392.208 0 .416.001.598.011.192.01.45-.073.703.536.257.62.874 2.134.95 2.289.076.154.127.337.025.543-.101.206-.152.337-.304.52-.152.182-.32.407-.457.547-.152.154-.31.32-.133.627.177.306.785 1.295 1.685 2.096 1.158 1.03 2.136 1.348 2.438 1.5.303.152.48.127.657-.077.177-.203.76-.886.962-1.19.203-.304.406-.253.684-.152.278.102 1.765.832 2.067.984.303.152.506.228.582.355.076.127.076.737-.157 1.392z"></path></svg>`,
        email: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>`,
        globe: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.559-.499-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.559.499.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.497-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path></svg>`
    };
    return icons[iconType] || icons.github;
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
                    <div v-if="activeSocialLinks.length > 0" class="flex gap-3 sm:gap-4">
                        <a
                            v-for="social in activeSocialLinks"
                            :key="social.id"
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

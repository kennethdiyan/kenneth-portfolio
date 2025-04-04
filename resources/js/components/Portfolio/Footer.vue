<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const currentYear = computed(() => new Date().getFullYear());

const socialLinks = [
    {
        name: 'GitHub',
        url: 'https://github.com/kennethdiyan',
        icon: 'M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z'
    },
    {
        name: 'LinkedIn',
        url: '#',
        icon: 'M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z'
    },
    {
        name: 'Email',
        url: 'mailto:kennethjohnribay@gmail.com',
        icon: 'M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z'
    }
];

const quickLinks = [
    { name: 'Home', href: '#' },
    { name: 'About', href: '#about' },
    { name: 'Skills', href: '#skills' },
    { name: 'Projects', href: '#projects' },
    { name: 'Experience', href: '#experience' },
    { name: 'Contact', href: '#contact' }
];
</script>

<template>
    <footer class="relative mt-20">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 overflow-hidden">
            <div class="absolute inset-0 bg-grid-gray-900/5 dark:bg-grid-white/5 bg-[size:3rem_3rem]"></div>
            <!-- Animated Gradient Orbs -->
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-3xl animate-float-delayed"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Border with Gradient -->
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent"></div>

            <div class="py-16">
                <!-- Footer Content Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12 mb-12">
                    <!-- Brand Section -->
                    <div class="space-y-6 sm:col-span-2 lg:col-span-1">
                        <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-transparent hover:scale-105 transform transition-transform cursor-default">
                            Kenneth John
                        </h3>
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed max-w-md sm:max-w-sm">
                            Full Stack Developer specializing in Laravel and Vue.js. Creating efficient and user-friendly web applications.
                        </p>
                        <div class="flex space-x-4">
                            <a v-for="social in socialLinks"
                               :key="social.name"
                               :href="social.url"
                               :title="social.name"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="social-link">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path :d="social.icon"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="sm:col-span-1">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-6">
                            Quick Links
                        </h3>
                        <ul class="space-y-3">
                            <li v-for="link in quickLinks" :key="link.name">
                                <a :href="link.href"
                                   class="footer-link group">
                                    <span class="inline-block">
                                        {{ link.name }}
                                        <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-indigo-500 dark:bg-indigo-400"></span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="sm:col-span-1">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-6">
                            Contact
                        </h3>
                        <div class="space-y-4">
                            <a href="mailto:kennethjohnribay@gmail.com" class="contact-item group">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="contact-text break-all">kennethjohnribay@gmail.com</span>
                            </a>
                            <div class="contact-item">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="contact-text">San Jose, Pili, Camarines Sur, Philippines</span>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter Section -->
                    <div class="sm:col-span-2 lg:col-span-1">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-6">
                            Stay Updated
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 max-w-md sm:max-w-sm">
                            Subscribe to my newsletter for latest updates and insights.
                        </p>
                        <form class="space-y-3">
                            <div class="relative max-w-md">
                                <input type="email"
                                       placeholder="Enter your email"
                                       class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent outline-none transition-all duration-200 text-sm">
                                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1 bg-indigo-600 dark:bg-indigo-500 text-white rounded-md text-sm hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors duration-200">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="pt-8 mt-8 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                        <p class="text-sm text-center sm:text-left text-gray-600 dark:text-gray-400">
                            &copy; {{ currentYear }} Kenneth John C. Ribay. All rights reserved.
                        </p>
                        <div class="flex space-x-6 text-sm">
                            <a href="#" class="footer-link group">
                                <span class="inline-block">
                                    Privacy Policy
                                    <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-indigo-500 dark:bg-indigo-400"></span>
                                </span>
                            </a>
                            <a href="#" class="footer-link group">
                                <span class="inline-block">
                                    Terms of Service
                                    <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-indigo-500 dark:bg-indigo-400"></span>
                                </span>
                            </a>
                        </div>
                    </div>
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

<script setup lang="ts">
import { ref } from 'vue';

interface ContactInfo {
    icon: string;
    label: string;
    value: string;
    link?: string;
}

const contactInfo: ContactInfo[] = [
    {
        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
               </svg>`,
        label: 'Location',
        value: 'San Jose, Pili, Camarines Sur, Philippines'
    },
    {
        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
               </svg>`,
        label: 'Email',
        value: 'kennethjohnribay@gmail.com',
        link: 'mailto:kennethjohnribay@gmail.com'
    }
];

const socialLinks = [
    {
        name: 'GitHub',
        url: 'https://github.com/kennethribay',
        icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
               </svg>`,
        color: 'text-[#2DA44E]',
        hoverBg: 'hover:bg-[#2DA44E]/10'
    },
    {
        name: 'LinkedIn',
        url: 'https://www.linkedin.com/in/kenneth-john-ribay/',
        icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
               </svg>`,
        color: 'text-[#0A66C2]',
        hoverBg: 'hover:bg-[#0A66C2]/10'
    },
    {
        name: 'Twitter',
        url: 'https://twitter.com/kennethribay',
        icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
               </svg>`,
        color: 'text-[#1DA1F2]',
        hoverBg: 'hover:bg-[#1DA1F2]/10'
    },
    {
        name: 'Instagram',
        url: 'https://instagram.com/kennethribay',
        icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
               </svg>`,
        color: 'text-[#E4405F]',
        hoverBg: 'hover:bg-[#E4405F]/10'
    },
    {
        name: 'YouTube',
        url: 'https://youtube.com/@kennethribay',
        icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
               </svg>`,
        color: 'text-[#FF0000]',
        hoverBg: 'hover:bg-[#FF0000]/10'
    },
    {
        name: 'Facebook',
        url: 'https://facebook.com/kennethribay',
        icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
               </svg>`,
        color: 'text-[#1877F2]',
        hoverBg: 'hover:bg-[#1877F2]/10'
    }
];

const form = ref({
    name: '',
    email: '',
    message: ''
});

const handleSubmit = (e: Event) => {
    e.preventDefault();
    // Handle form submission
    console.log('Form submitted:', form.value);
};
</script>

<template>
    <section id="contact" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Get in Touch
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Feel free to reach out for collaborations or just a friendly hello
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Contact Cards -->
                    <div v-for="info in contactInfo" :key="info.label"
                         class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-lg flex items-center justify-center text-primary-600 dark:text-primary-400"
                                     v-html="info.icon">
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                    {{ info.label }}
                                </h3>
                                <p v-if="info.link" class="text-gray-700 dark:text-gray-300">
                                    <a :href="info.link" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                        {{ info.value }}
                                    </a>
                                </p>
                                <p v-else class="text-gray-700 dark:text-gray-300">
                                    {{ info.value }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="pt-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            Connect with me
                        </h3>
                        <div class="flex flex-wrap gap-4">
                            <a v-for="social in socialLinks"
                               :key="social.name"
                               :href="social.url"
                               target="_blank"
                               rel="noopener noreferrer"
                               :class="['p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-all duration-300', social.color, social.hoverBg]"
                               :title="social.name"
                               v-html="social.icon">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                    <form @submit="handleSubmit" class="space-y-6">
                        <div>
                            <label for="name" class="block text-base font-medium text-gray-900 dark:text-white mb-2">
                                Name
                            </label>
                            <input type="text"
                                   id="name"
                                   v-model="form.name"
                                   class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                   placeholder="Your name"
                                   required>
                        </div>
                        <div>
                            <label for="email" class="block text-base font-medium text-gray-900 dark:text-white mb-2">
                                Email
                            </label>
                            <input type="email"
                                   id="email"
                                   v-model="form.email"
                                   class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                   placeholder="your.email@example.com"
                                   required>
                        </div>
                        <div>
                            <label for="message" class="block text-base font-medium text-gray-900 dark:text-white mb-2">
                                Message
                            </label>
                            <textarea id="message"
                                      v-model="form.message"
                                      rows="4"
                                      class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                                      placeholder="Your message here..."
                                      required></textarea>
                        </div>
                        <button type="submit"
                                class="w-full px-6 py-3.5 text-base font-medium text-white bg-gray-900 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transform hover:scale-[1.02] transition-all duration-300">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.social-icon-hover {
    transition: all 0.3s ease;
}
</style>

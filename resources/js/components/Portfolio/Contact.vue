<script setup lang="ts">
import { ref, computed } from 'vue';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

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
    contactInfo: ContactInfo[];
}>();

const form = ref({
    firstName: '',
    lastName: '',
    email: '',
    subject: '',
    message: ''
});

const isSubmitting = ref(false);
const submitStatus = ref<'success' | 'error' | null>(null);

// Filter and sort active contact info
const activeContactInfo = computed(() => {
    return props.contactInfo
        .filter(contact => contact.is_active)
        .sort((a, b) => a.sort_order - b.sort_order);
});

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

const getContactIcon = (iconType: string) => {
    const icons: Record<string, string> = {
        email: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>`,
        phone: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>`,
        location: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>`,
        envelope: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>`,
        'map-pin': `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>`,
        globe: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.559-.499-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.559.499.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.497-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path></svg>`,
        user: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>`,
        home: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>`,
        briefcase: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h2zm4-1a1 1 0 00-1 1v1h2V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>`
    };
    return icons[iconType] || icons.envelope;
};

const getSocialIcon = (iconType: string) => {
    const icons: Record<string, string> = {
        github: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path></svg>`,
        linkedin: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z" clip-rule="evenodd"></path></svg>`,
        facebook: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"></path></svg>`
    };
    return icons[iconType] || '';
};

const submitForm = async () => {
    isSubmitting.value = true;
    submitStatus.value = null;

    try {
        // Simulate form submission
        await new Promise(resolve => setTimeout(resolve, 2000));

        // Reset form
        form.value = {
            firstName: '',
            lastName: '',
            email: '',
            subject: '',
            message: ''
        };

        submitStatus.value = 'success';
    } catch (error) {
        submitStatus.value = 'error';
    } finally {
        isSubmitting.value = false;

        // Clear status after 5 seconds
        setTimeout(() => {
            submitStatus.value = null;
        }, 5000);
    }
};

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.contact-header',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.contact-form',
        animation: { opacity: 1, x: 0 },
        options: { duration: 0.8, delay: 0.2 }
    },
    {
        selector: '.contact-info',
        animation: { opacity: 1, x: 0 },
        options: { duration: 0.8, delay: 0.4 }
    },
    {
        selector: '.contact-info-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6 },
        staggerDelay: 0.1
    },
    {
        selector: '.contact-social',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8, delay: 0.6 }
    }
]);
</script>

<template>
    <section id="contact" class="py-12 sm:py-16 lg:py-20 bg-slate-950 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="contact-header text-center mb-12 sm:mb-16 lg:mb-20 opacity-0 transform translate-y-[30px]">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                    Get In <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Touch</span>
                </h2>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-400 max-w-3xl mx-auto">
                    Let's discuss your next project or just say hello!
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-16">
                <!-- Contact Form -->
                <div class="contact-form order-2 lg:order-1 opacity-0 transform translate-x-[-50px]">
                    <div class="bg-slate-900/50 backdrop-blur border border-slate-800 rounded-xl sm:rounded-2xl lg:rounded-3xl p-6 sm:p-8 lg:p-10">
                        <h3 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-6 sm:mb-8">
                            Send me a message
                        </h3>

                        <form @submit.prevent="submitForm" class="space-y-4 sm:space-y-6">
                            <!-- Name Fields -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <label for="firstName" class="block text-sm sm:text-base md:text-lg font-medium text-gray-300 mb-2 sm:mb-3">
                                        First Name
                                    </label>
                                    <input
                                        id="firstName"
                                        v-model="form.firstName"
                                        type="text"
                                        required
                                        class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl text-white placeholder-gray-400 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all duration-300 text-sm sm:text-base"
                                        placeholder="Your first name"
                                    />
                                </div>
                                <div>
                                    <label for="lastName" class="block text-sm sm:text-base md:text-lg font-medium text-gray-300 mb-2 sm:mb-3">
                                        Last Name
                                    </label>
                                    <input
                                        id="lastName"
                                        v-model="form.lastName"
                                        type="text"
                                        required
                                        class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl text-white placeholder-gray-400 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all duration-300 text-sm sm:text-base"
                                        placeholder="Your last name"
                                    />
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm sm:text-base md:text-lg font-medium text-gray-300 mb-2 sm:mb-3">
                                    Email Address
                                </label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl text-white placeholder-gray-400 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all duration-300 text-sm sm:text-base"
                                    placeholder="your.email@example.com"
                                />
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm sm:text-base md:text-lg font-medium text-gray-300 mb-2 sm:mb-3">
                                    Subject
                                </label>
                                <input
                                    id="subject"
                                    v-model="form.subject"
                                    type="text"
                                    required
                                    class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl text-white placeholder-gray-400 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all duration-300 text-sm sm:text-base"
                                    placeholder="What's this about?"
                                />
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm sm:text-base md:text-lg font-medium text-gray-300 mb-2 sm:mb-3">
                                    Message
                                </label>
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    rows="5"
                                    required
                                    class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl text-white placeholder-gray-400 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all duration-300 resize-none text-sm sm:text-base"
                                    placeholder="Tell me about your project..."
                                ></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="w-full flex items-center justify-center gap-2 sm:gap-3 px-6 sm:px-8 py-3 sm:py-4 lg:py-5 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full text-white font-semibold hover:from-cyan-400 hover:to-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-cyan-500/25 text-sm sm:text-base lg:text-lg"
                            >
                                <span v-if="!isSubmitting">Send Message</span>
                                <span v-else>Sending...</span>
                                <svg v-if="!isSubmitting" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                <div v-else class="w-4 h-4 sm:w-5 sm:h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                            </button>

                            <!-- Status Messages -->
                            <div v-if="submitStatus" class="text-center">
                                <p v-if="submitStatus === 'success'" class="text-green-400 text-sm sm:text-base">
                                    Message sent successfully! I'll get back to you soon.
                                </p>
                                <p v-else-if="submitStatus === 'error'" class="text-red-400 text-sm sm:text-base">
                                    Something went wrong. Please try again.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="contact-info order-1 lg:order-2 space-y-6 sm:space-y-8 lg:space-y-10 opacity-0 transform translate-x-[50px]">
                    <!-- Contact Information -->
                    <div class="space-y-4 sm:space-y-6">
                        <h3 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white">
                            Contact Information
                        </h3>
                        <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-400 leading-relaxed">
                            Ready to bring your ideas to life? Let's connect and discuss how we can work together.
                        </p>
                    </div>

                    <div class="space-y-4 sm:space-y-6">
                        <div
                            v-for="(info, index) in activeContactInfo"
                            :key="info.label"
                            class="contact-info-card group bg-slate-900/30 backdrop-blur border border-slate-800/50 rounded-lg sm:rounded-xl lg:rounded-2xl p-4 sm:p-6 md:p-8 hover:bg-slate-900/50 hover:border-cyan-500/50 transition-all duration-300 opacity-0 transform translate-y-[20px]"
                        >
                            <a :href="info.href" class="flex items-center gap-3 sm:gap-4 md:gap-6">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 bg-gradient-to-br from-cyan-500/20 to-blue-600/20 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <div class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8 text-cyan-400" v-html="getContactIcon(info.icon)"></div>
                                </div>
                                <div>
                                    <h4 class="text-base sm:text-lg md:text-xl lg:text-2xl font-semibold text-white group-hover:text-cyan-400 transition-colors duration-300">
                                        {{ info.label }}
                                    </h4>
                                    <p class="text-xs sm:text-sm md:text-base lg:text-lg text-gray-400">{{ info.value }}</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="contact-social space-y-4 sm:space-y-6 opacity-0 transform translate-y-[30px]">
                        <h4 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-white">Follow me</h4>
                        <div class="flex gap-3 sm:gap-4 md:gap-6">
                            <a
                                v-for="social in socialLinks"
                               :key="social.name"
                               :href="social.url"
                               target="_blank"
                               rel="noopener noreferrer"
                                class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 flex items-center justify-center bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl lg:rounded-2xl hover:border-cyan-500/50 hover:bg-slate-700/50 transition-all duration-300 hover:scale-110"
                               :title="social.name"
                            >
                                <div class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 text-gray-300 hover:text-cyan-400 transition-colors duration-300" v-html="getSocialIcon(social.icon)"></div>
                            </a>
                        </div>
                    </div>
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

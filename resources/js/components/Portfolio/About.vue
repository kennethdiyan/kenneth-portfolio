<script setup lang="ts">
interface ContactInfo {
    icon: string;
    value: string;
    link?: string;
}

const contactInfo: ContactInfo[] = [
    {
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>`,
        value: '054, Zone 6, San Jose, Pili, 4418, Camarines Sur'
    },
    {
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>`,
        value: '09165517358 / 09107872578',
        link: 'tel:09165517358'
    },
    {
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>`,
        value: 'kennethjohnribay@gmail.com',
        link: 'mailto:kennethjohnribay@gmail.com'
    }
];
</script>

<template>
    <section id="about" class="relative py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <!-- Main Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-white via-purple-50 to-indigo-50 dark:from-gray-900 dark:via-purple-900/10 dark:to-indigo-900/10"></div>

        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Gradient Orbs -->
            <div class="absolute top-1/4 -left-10 w-72 h-72 bg-purple-200/30 dark:bg-purple-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light blur-3xl animate-blob"></div>
            <div class="absolute -top-4 -right-10 w-72 h-72 bg-indigo-200/30 dark:bg-indigo-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-72 h-72 bg-pink-200/30 dark:bg-pink-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-grid-gray-100 dark:bg-grid-gray-800 opacity-[0.15]"></div>

        <div class="relative max-w-7xl mx-auto">
            <!-- Section Title with enhanced styling -->
            <div class="text-center mb-16 relative">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">About Me</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content Column -->
                <div class="order-2 lg:order-1 space-y-8">
                    <!-- About Text -->
                    <div class="prose prose-lg dark:prose-invert">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Hardworking and detail-oriented Web Developer with experience in building and maintaining web applications and management systems. Skilled in Laravel, Vue.js, and Tailwind CSS, with a strong focus on creating efficient and user-friendly software.
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Experienced in handling multiple projects independently, including POS systems, inventory management, and assessment tools. Passionate about solving problems, improving workflows, and continuously learning new technologies.
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Contact Information</h3>
                        <div class="space-y-4">
                            <div v-for="(info, index) in contactInfo"
                                 :key="index"
                                 class="flex items-start space-x-4 group">
                                <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800 transition-colors duration-300"
                                     v-html="info.icon">
                                </div>
                                <div class="flex-grow">
                                    <a v-if="info.link"
                                       :href="info.link"
                                       class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-300">
                                        {{ info.value }}
                                    </a>
                                    <div v-else class="text-gray-700 dark:text-gray-300">{{ info.value }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Column -->
                <div class="order-1 lg:order-2">
                    <div class="relative max-w-lg mx-auto">
                        <!-- Background Pattern -->
                        <div class="absolute inset-4 -z-10">
                            <div class="absolute inset-0 bg-gradient-to-tr from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 rounded-3xl"></div>
                            <div class="absolute inset-0 bg-grid-purple opacity-30 dark:opacity-20"></div>
                        </div>

                        <!-- Main Container with Purple Border -->
                        <div class="relative rounded-2xl p-1 bg-gradient-to-br from-purple-400 via-purple-500 to-indigo-500">
                            <!-- Image Container -->
                            <div class="relative rounded-xl overflow-hidden bg-white dark:bg-gray-800">
                                <img src="/images/kenneth-profile.jpg"
                                     alt="Kenneth John C. Ribay"
                                     class="w-full h-[480px] object-cover object-center transform hover:scale-105 transition-transform duration-500">
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -bottom-2 -right-2 w-28 h-28 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full opacity-20 blur-lg"></div>
                        <div class="absolute -top-2 -left-2 w-28 h-28 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full opacity-20 blur-lg"></div>

                        <!-- Corner Accent -->
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-purple-500 rounded-full"></div>
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

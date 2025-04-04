<script setup lang="ts">
import { onMounted, ref } from 'vue';

const roles = ['Web Developer', 'Laravel Developer', 'Vue.js Developer', 'Full Stack Developer'];
const currentRole = ref(roles[0]);
let roleIndex = 0;

const stats = [
    { label: 'Years Experience', value: '1+' },
    { label: 'Projects Completed', value: '20+' },
    { label: 'Happy Clients', value: '15+' },
    { label: 'Technologies', value: '10+' }
];

const technologies = [
    { name: 'Laravel', color: 'from-red-500 to-pink-500' },
    { name: 'Vue.js', color: 'from-emerald-500 to-green-500' },
    { name: 'Tailwind', color: 'from-cyan-500 to-blue-500' },
    { name: 'MySQL', color: 'from-orange-500 to-amber-500' }
];

onMounted(() => {
    setInterval(() => {
        roleIndex = (roleIndex + 1) % roles.length;
        currentRole.value = roles[roleIndex];
    }, 3000);
});

const socialLinks = [
    {
        name: 'GitHub',
        url: 'https://github.com/yourusername',
        icon: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
              </svg>`,
    },
    {
        name: 'LinkedIn',
        url: 'https://linkedin.com/in/yourusername',
        icon: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"></path>
              </svg>`,
    },
    {
        name: 'Email',
        url: 'mailto:kennethjohnribay@gmail.com',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>`,
    }
];
</script>

<template>
    <section class="relative min-h-screen flex items-center py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gradient-to-br from-white via-purple-50/50 to-indigo-50/50 dark:from-gray-900 dark:via-purple-900/5 dark:to-indigo-900/5"></div>

        <!-- Animated Shapes -->
        <div class="absolute inset-0">
            <!-- Gradient Circles -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-200/30 dark:bg-purple-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light blur-3xl animate-blob"></div>
            <div class="absolute top-1/3 right-1/3 w-96 h-96 bg-indigo-200/30 dark:bg-indigo-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-pink-200/30 dark:bg-pink-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <!-- Floating Technology Pills -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div v-for="(tech, index) in technologies" :key="tech.name"
                 :class="`absolute bg-gradient-to-r ${tech.color} p-2 px-4 rounded-full text-white text-sm font-medium opacity-80 shadow-lg transform animate-float-${index}`"
                 :style="`top: ${20 + index * 15}%; left: ${10 + index * 20}%`">
                {{ tech.name }}
            </div>
        </div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-grid-gray-100 dark:bg-grid-gray-800 opacity-[0.1]"></div>

        <!-- Content Container -->
        <div class="relative max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-8 text-center lg:text-left">
                    <!-- Greeting with Animated Underline -->
                    <div class="space-y-2">
                        <h2 class="text-2xl font-medium text-indigo-600 dark:text-indigo-400 relative inline-block">
                            Hello, I'm Kenneth John
                            <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 transform scale-x-0 animate-expand"></div>
                        </h2>
                        <div class="relative h-20">
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white">
                                <span class="inline-block">I'm a</span>
                                <span class="inline-block text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 ml-2">
                                    {{ currentRole }}
                                </span>
                            </h1>
                        </div>
                    </div>

                    <!-- Description with Highlight -->
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto lg:mx-0 relative">
                        <span class="relative">
                            Passionate about creating efficient and user-friendly web applications.
                            <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-indigo-200 dark:bg-indigo-800"></span>
                        </span>
                        <br>
                        Specialized in Laravel, Vue.js, and modern web technologies.
                    </p>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-6">
                        <div v-for="stat in stats" :key="stat.label"
                             class="p-4 rounded-lg bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-gray-200 dark:border-gray-700 transform hover:scale-105 transition-transform duration-300">
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ stat.value }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ stat.label }}</div>
                        </div>
                    </div>

                    <!-- CTA Buttons with Enhanced Styling -->
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="#contact"
                           class="group inline-flex items-center px-6 py-3 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg">
                            <span>Get in Touch</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                        <a href="#portfolio"
                           class="group inline-flex items-center px-6 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-700 hover:border-indigo-600 dark:hover:border-indigo-500 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg">
                            <span>View Portfolio</span>
                            <svg class="w-5 h-5 ml-2 opacity-0 group-hover:opacity-100 transform translate-x-[-10px] group-hover:translate-x-0 transition-all"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Social Links with Enhanced Hover Effects -->
                    <div class="flex items-center gap-6 justify-center lg:justify-start">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Follow me:</span>
                        <div class="flex gap-6">
                            <a v-for="link in socialLinks"
                               :key="link.name"
                               :href="link.url"
                               :title="link.name"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="group relative text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors duration-300">
                                <span class="sr-only">{{ link.name }}</span>
                                <div v-html="link.icon" class="transform group-hover:scale-110 transition-transform"></div>
                                <div class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-indigo-600 group-hover:w-full transform -translate-x-1/2 transition-all duration-300"></div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Code Editor Section -->
                <div class="relative">
                    <div class="relative max-w-lg mx-auto transform hover:scale-[1.02] transition-transform duration-300">
                        <!-- Code Window -->
                        <div class="relative rounded-xl overflow-hidden bg-gray-900 dark:bg-gray-800 shadow-2xl">
                            <!-- Window Header -->
                            <div class="flex items-center justify-start px-4 py-2 bg-gray-800 dark:bg-gray-700">
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                            </div>

                            <!-- Code Content -->
                            <div class="p-6 bg-[#1e1e1e]">
                                <!-- Code Lines Container -->
                                <div class="relative font-mono text-[13px]">
                                    <!-- Line Numbers Column -->
                                    <div class="absolute left-0 top-0 flex flex-col text-[#858585] select-none" style="line-height: 1.5rem;">
                                        <span class="w-5 text-right opacity-50">1</span>
                                        <span class="w-5 text-right opacity-50">2</span>
                                        <span class="w-5 text-right opacity-50">3</span>
                                        <span class="w-5 text-right opacity-50">4</span>
                                        <span class="w-5 text-right opacity-50">5</span>
                                        <span class="w-5 text-right opacity-50">6</span>
                                        <span class="w-5 text-right opacity-50">7</span>
                                    </div>

                                    <!-- Code Content -->
                                    <div class="pl-7 space-y-0">
                                        <!-- Line 1 -->
                                        <div class="flex items-center h-6">
                                            <span class="text-[#569cd6]">class</span>
                                            <span class="mx-1.5 text-[#4ec9b0]">Developer</span>
                                            <span class="text-[#569cd6]">extends</span>
                                            <span class="mx-1.5 text-[#4ec9b0]">Human</span>
                                            <span class="text-white">{</span>
                                        </div>

                                        <!-- Line 2 -->
                                        <div class="flex items-center h-6">
                                            <span class="ml-8 text-[#9cdcfe]">skills</span>
                                            <span class="mx-1.5 text-white">=</span>
                                            <span class="text-[#ce9178]">['Laravel', 'Vue.js', 'Tailwind']</span>
                                        </div>

                                        <!-- Line 3 -->
                                        <div class="flex items-center h-6">
                                            <span class="ml-8 text-[#9cdcfe]">passion</span>
                                            <span class="mx-1.5 text-white">=</span>
                                            <span class="text-[#ce9178]">'Creating Amazing Web Apps'</span>
                                        </div>

                                        <!-- Line 4 -->
                                        <div class="flex items-center h-6">
                                            <span class="ml-8 text-[#569cd6]">constructor</span>
                                            <span class="text-white">() {</span>
                                        </div>

                                        <!-- Line 5 -->
                                        <div class="flex items-center h-6">
                                            <span class="ml-16 text-[#569cd6]">this</span>
                                            <span class="text-white">.</span>
                                            <span class="text-[#9cdcfe]">code</span>
                                            <span class="mx-1.5 text-white">=</span>
                                            <span class="text-[#ce9178]">'24/7'</span>
                                        </div>

                                        <!-- Line 6 -->
                                        <div class="flex items-center h-6">
                                            <span class="ml-8 text-white">}</span>
                                        </div>

                                        <!-- Line 7 -->
                                        <div class="flex items-center h-6">
                                            <span class="text-white">}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -bottom-2 -right-2 w-28 h-28 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full opacity-20 blur-lg"></div>
                        <div class="absolute -top-2 -left-2 w-28 h-28 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full opacity-20 blur-lg"></div>

                        <!-- Floating Elements -->
                        <div class="absolute -right-8 top-1/4 w-16 h-16 bg-purple-500 rounded-xl rotate-12 animate-float opacity-50"></div>
                        <div class="absolute -left-8 bottom-1/4 w-16 h-16 bg-indigo-500 rounded-xl -rotate-12 animate-float-delay opacity-50"></div>
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

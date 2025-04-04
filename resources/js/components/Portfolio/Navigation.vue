<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

const isMenuOpen = ref(false);
const activeSection = ref('home');
const isScrolled = ref(false);

const sections = [
    { id: 'home', label: 'Home', icon: '🏠' },
    { id: 'about', label: 'About', icon: '👨‍💻' },
    { id: 'skills', label: 'Skills', icon: '⚡' },
    { id: 'projects', label: 'Projects', icon: '🚀' },
    { id: 'experience', label: 'Experience', icon: '💼' },
    { id: 'education', label: 'Education', icon: '🎓' },
    { id: 'contact', label: 'Contact', icon: '📬' }
];

const checkScroll = () => {
    isScrolled.value = window.scrollY > 50;

    const sectionElements = sections.map(section => ({
        id: section.id,
        element: document.getElementById(section.id)
    })).filter(section => section.element);

    const currentSection = sectionElements.find(section => {
        const rect = section.element!.getBoundingClientRect();
        return rect.top <= 150 && rect.bottom >= 150;
    });

    if (currentSection) {
        activeSection.value = currentSection.id;
    }
};

onMounted(() => {
    window.addEventListener('scroll', checkScroll);
    checkScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', checkScroll);
});

const scrollToSection = (sectionId: string) => {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
        isMenuOpen.value = false;
    }
};
</script>

<template>
    <nav :class="[
        'fixed w-full z-50 transition-all duration-500 ease-in-out',
        isScrolled
            ? 'h-20 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-lg dark:shadow-primary-500/10'
            : 'h-32 bg-gradient-to-b from-white via-white to-white/0 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900/0'
    ]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between items-center h-full transition-all duration-500"
                :class="[isScrolled ? 'gap-8' : 'gap-16']">
                <!-- Logo/Name Section -->
                <div class="flex items-center transition-all duration-500"
                    :class="[isScrolled ? 'scale-75 -translate-x-4' : 'scale-100']">
                    <div class="relative group">
                        <span class="absolute -inset-1 bg-gradient-to-r from-primary-600 to-secondary-600 rounded-lg blur opacity-25 group-hover:opacity-75 transition duration-500"></span>
                        <span class="relative text-2xl md:text-3xl font-bold bg-gradient-to-r from-primary-500 via-secondary-500 to-primary-500 bg-clip-text text-transparent bg-[length:200%_auto] hover:bg-right transition-all duration-500">
                            Kenneth John C. Ribay
                        </span>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center transition-all duration-500"
                    :class="[isScrolled ? 'space-x-2' : 'space-x-4']">
                    <button
                        v-for="section in sections"
                        :key="section.id"
                        @click="scrollToSection(section.id)"
                        class="group relative px-4 py-2 rounded-xl transition-all duration-300 hover:bg-white/10 dark:hover:bg-gray-800/50"
                        :class="[
                            activeSection === section.id
                                ? 'text-primary-600 dark:text-primary-400'
                                : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white',
                            isScrolled ? 'text-sm' : 'text-base'
                        ]"
                    >
                        <span class="relative z-10 flex items-center gap-2">
                            <span class="text-lg transition-transform group-hover:scale-110">{{ section.icon }}</span>
                            <span :class="[isScrolled ? 'scale-95' : 'scale-100']"
                                class="transition-transform duration-500">
                                {{ section.label }}
                            </span>
                        </span>
                        <div
                            class="absolute inset-0 rounded-xl bg-gradient-to-r from-primary-500/20 to-secondary-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                            :class="{ 'opacity-100': activeSection === section.id }"
                        ></div>
                        <div
                            class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-primary-500 to-secondary-500 transform origin-left transition-transform duration-300"
                            :class="activeSection === section.id ? 'scale-x-100' : 'scale-x-0'"
                        ></div>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button
                        @click="isMenuOpen = !isMenuOpen"
                        class="relative group p-2 rounded-xl transition-all duration-300"
                    >
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/20 to-secondary-500/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <svg
                            class="h-6 w-6 transition-all duration-300 text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            :class="{ 'rotate-180': isMenuOpen }"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path v-if="!isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            class="md:hidden overflow-hidden transition-all duration-500"
            :class="isMenuOpen ? 'max-h-[32rem] opacity-100' : 'max-h-0 opacity-0'"
        >
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md">
                <button
                    v-for="section in sections"
                    :key="section.id"
                    @click="scrollToSection(section.id)"
                    class="group relative flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-300"
                    :class="[
                        activeSection === section.id
                            ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50'
                    ]"
                >
                    <span class="text-xl mr-3 transition-transform group-hover:scale-110">{{ section.icon }}</span>
                    <span class="font-medium">{{ section.label }}</span>
                    <div
                        class="absolute inset-0 rounded-xl bg-gradient-to-r from-primary-500/10 to-secondary-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        :class="{ 'opacity-100': activeSection === section.id }"
                    ></div>
                </button>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.bg-right {
    background-position: 100% 50%;
}
</style>

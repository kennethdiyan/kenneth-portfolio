<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

const isMenuOpen = ref(false);
const isScrolled = ref(false);

const navItems = [
    { name: 'Home', href: '#', id: 'home' },
    { name: 'About', href: '#about', id: 'about' },
    { name: 'Skills', href: '#skills', id: 'skills' },
    { name: 'Projects', href: '#projects', id: 'projects' },
    { name: 'Contact', href: '#contact', id: 'contact' }
];

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const closeMenu = () => {
    isMenuOpen.value = false;
};

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
};

const scrollToSection = (href: string) => {
    if (href === '#') {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        const element = document.querySelector(href);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }
    closeMenu();
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    handleScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="isScrolled ? 'bg-slate-950/80 backdrop-blur border-b border-slate-800' : 'bg-transparent'">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#home" @click="scrollToSection('home')"
                       class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent hover:scale-105 transition-transform duration-300">
                        Kenneth<span class="text-white">Dev</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a v-for="item in navItems"
                           :key="item.name"
                           :href="item.href"
                           @click="scrollToSection(item.href.replace('#', ''))"
                           class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-cyan-400 transition-colors duration-300 relative group">
                            {{ item.name }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-cyan-400 to-blue-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="toggleMenu"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-cyan-400 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500 transition-colors duration-300">
                        <svg class="h-6 w-6" :class="{ 'hidden': isMenuOpen, 'block': !isMenuOpen }"
                             stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg class="h-6 w-6" :class="{ 'block': isMenuOpen, 'hidden': !isMenuOpen }"
                             stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div class="md:hidden" :class="{ 'block': isMenuOpen, 'hidden': !isMenuOpen }">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-slate-900/95 backdrop-blur rounded-lg mt-2 border border-slate-800">
                    <a v-for="item in navItems"
                       :key="item.name"
                       :href="item.href"
                       @click="scrollToSection(item.href.replace('#', '')); closeMenu()"
                       class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-cyan-400 hover:bg-slate-800/50 rounded-md transition-all duration-300">
                        {{ item.name }}
                    </a>
                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped>
.bg-right {
    background-position: 100% 50%;
}
</style>

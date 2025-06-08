<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Navigation from '@/components/Portfolio/Navigation.vue';
import Hero from '@/components/Portfolio/Hero.vue';
import About from '@/components/Portfolio/About.vue';
import Skills from '@/components/Portfolio/Skills.vue';
import Projects from '@/components/Portfolio/Projects.vue';
import Experience from '@/components/Portfolio/Experience.vue';
import Education from '@/components/Portfolio/Education.vue';
import Contact from '@/components/Portfolio/Contact.vue';
import Footer from '@/components/Portfolio/Footer.vue';
</script>

<template>
    <Head title="Kenneth John C. Ribay - Portfolio">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@300;400;500&display=swap" rel="stylesheet" />
    </Head>

    <div class="bg-slate-950 text-white overflow-hidden">
        <Navigation />
        <Hero />
        <About />
        <Skills />
        <Projects />
        <Experience />
        <Education />
        <Contact />
        <Footer />
    </div>
</template>

<style>
body {
    font-family: 'Space Grotesk', sans-serif;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #0f172a;
}

::-webkit-scrollbar-thumb {
    background: #334155;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #475569;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Selection styling */
::selection {
    background-color: #06b6d4;
    color: #ffffff;
}

::-moz-selection {
    background-color: #06b6d4;
    color: #ffffff;
}
</style>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Navigation from '@/Components/Portfolio/Navigation.vue';
import Hero from '@/Components/Portfolio/Hero.vue';
import About from '@/Components/Portfolio/About.vue';
import Skills from '@/Components/Portfolio/Skills.vue';
import Projects from '@/Components/Portfolio/Projects.vue';
import Experience from '@/Components/Portfolio/Experience.vue';
import Education from '@/Components/Portfolio/Education.vue';
import Contact from '@/Components/Portfolio/Contact.vue';
import Footer from '@/Components/Portfolio/Footer.vue';
</script>

<template>
    <Head title="Kenneth John C. Ribay - Portfolio">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
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

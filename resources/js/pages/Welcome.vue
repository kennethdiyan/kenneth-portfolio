<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Navigation from '@/Components/Portfolio/Navigation.vue';
import Hero from '@/Components/Portfolio/Hero.vue';
import About from '@/Components/Portfolio/About.vue';
import Skills from '@/Components/Portfolio/Skills.vue';
import Projects from '@/Components/Portfolio/Projects.vue';
import Experience from '@/Components/Portfolio/Experience.vue';
import Education from '@/Components/Portfolio/Education.vue';
import Contact from '@/Components/Portfolio/Contact.vue';
import Footer from '@/Components/Portfolio/Footer.vue';

onMounted(() => {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target); // Stop observing once animated
            }
        });
    }, observerOptions);

    // Observe all sections
    document.querySelectorAll('.animate-section').forEach((section) => {
        observer.observe(section);
    });
});
</script>

<template>
    <Head title="Kenneth John C. Ribay - Portfolio">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <Navigation />
        <Hero class="animate-section" />
        <About class="animate-section" />
        <Skills class="animate-section" />
        <Projects class="animate-section" />
        <Experience class="animate-section" />
        <Education class="animate-section" />
        <Contact class="animate-section" />
        <Footer class="animate-section" />
    </div>
</template>

<style>
.animate-section {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease-out;
}

.animate-section.show {
    opacity: 1;
    transform: translateY(0);
}

/* Add stagger effect for sections */
.animate-section:nth-child(2) { transition-delay: 100ms; }
.animate-section:nth-child(3) { transition-delay: 200ms; }
.animate-section:nth-child(4) { transition-delay: 300ms; }
.animate-section:nth-child(5) { transition-delay: 400ms; }
.animate-section:nth-child(6) { transition-delay: 500ms; }
.animate-section:nth-child(7) { transition-delay: 600ms; }
.animate-section:nth-child(8) { transition-delay: 700ms; }
.animate-section:nth-child(9) { transition-delay: 800ms; }
</style>

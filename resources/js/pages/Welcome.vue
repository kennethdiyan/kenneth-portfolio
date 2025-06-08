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

interface PersonalInfo {
    id: number;
    label: string;
    value: string;
    is_active: boolean;
    sort_order: number;
}

interface Skill {
    id: number;
    name: string;
    category: string;
    proficiency: string;
    description: string;
    is_active: boolean;
}

interface Project {
    id: number;
    title: string;
    description: string;
    technologies: string[];
    github_url: string;
    live_url: string;
    image_url: string;
    is_featured: boolean;
    is_active: boolean;
    sort_order: number;
}

interface Experience {
    id: number;
    title: string;
    company: string;
    location: string;
    start_date: string;
    end_date: string;
    description: string;
    responsibilities: string[];
    technologies: string[];
    is_current: boolean;
    is_active: boolean;
}

interface Education {
    id: number;
    degree: string;
    field_of_study: string;
    institution: string;
    location: string;
    start_date: string;
    end_date: string;
    gpa: string;
    description: string;
    achievements: string[];
    is_current: boolean;
    is_active: boolean;
}

interface Certification {
    id: number;
    name: string;
    issuer: string;
    issue_date: string;
    expiry_date: string;
    credential_id: string;
    credential_url: string;
    description: string;
    is_active: boolean;
}

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

interface SocialLink {
    id: number;
    name: string;
    url: string;
    icon: string;
    is_active: boolean;
    sort_order: number;
}

defineProps<{
    personalInfo: PersonalInfo[];
    skills: Skill[];
    projects: Project[];
    experiences: Experience[];
    educations: Education[];
    certifications: Certification[];
    contactInfo: ContactInfo[];
    socialLinks: SocialLink[];
}>();
</script>

<template>
    <Head title="Kenneth John C. Ribay - Portfolio">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@300;400;500&display=swap" rel="stylesheet" />
    </Head>

    <div class="bg-slate-950 text-white overflow-hidden">
        <Navigation />
        <Hero :personalInfo="personalInfo" />
        <About :personalInfo="personalInfo" :contactInfo="contactInfo" />
        <Skills :skills="skills" />
        <Projects :projects="projects" />
        <Experience :experiences="experiences" />
        <Education :educations="educations" />
        <Contact :contactInfo="contactInfo" />
        <Footer :socialLinks="socialLinks" />
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

<script setup lang="ts">
import { useScrollAnimation } from '@/composables/useScrollAnimation';
import { computed } from 'vue';

interface Project {
    id: number;
    title: string;
    description: string;
    technologies: string[] | string;
    github_url: string;
    live_url: string;
    image_url: string;
    is_featured: boolean;
    is_active: boolean;
    sort_order: number;
}

const props = defineProps<{
    projects: Project[];
}>();

// Helper function to safely parse technologies
const parseTechnologies = (technologies: string[] | string): string[] => {
    if (Array.isArray(technologies)) {
        return technologies;
    }

    if (typeof technologies === 'string') {
        try {
            const parsed = JSON.parse(technologies);
            return Array.isArray(parsed) ? parsed : [];
        } catch {
            return technologies.split(',').map(tech => tech.trim()).filter(Boolean);
        }
    }

    return [];
};

// Filter and sort active projects with proper technology parsing
const activeProjects = computed(() => {
    return props.projects
        .filter(project => project.is_active)
        .map(project => ({
            ...project,
            technologies: parseTechnologies(project.technologies)
        }))
        .sort((a, b) => a.sort_order - b.sort_order);
});

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.projects-header',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.project-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 },
        staggerDelay: 0.2
    }
]);
</script>

<template>
    <section id="projects" class="py-12 sm:py-16 lg:py-20 bg-slate-900 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="projects-header text-center mb-12 sm:mb-16 lg:mb-20 opacity-0 transform translate-y-[30px]">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                    My <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Projects</span>
                </h2>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-400 max-w-3xl mx-auto">
                    A showcase of my recent work and achievements
                </p>
            </div>

            <div v-if="activeProjects.length === 0" class="text-center py-12">
                <p class="text-gray-400 text-lg">No projects available at the moment.</p>
            </div>

            <div v-else class="space-y-8 sm:space-y-12 lg:space-y-16">
                <div
                    v-for="(project, index) in activeProjects"
                    :key="project.id"
                    class="project-card group relative opacity-0 transform translate-y-[50px]"
                >
                    <div
                        :class="[
                            'grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center',
                            index % 2 === 1 ? 'lg:grid-flow-col-dense' : ''
                        ]"
                    >
                        <!-- Project Image -->
                        <div :class="[
                            'relative overflow-hidden rounded-xl sm:rounded-2xl lg:rounded-3xl group-hover:scale-105 transition-transform duration-500',
                            index % 2 === 1 ? 'lg:col-start-2' : ''
                        ]">
                            <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/20 to-blue-600/20 rounded-xl sm:rounded-2xl lg:rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
                            <img
                                :src="project.image_url || 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=600&h=400&fit=crop&crop=center'"
                                :alt="project.title"
                                class="w-full h-64 sm:h-80 lg:h-96 object-cover"
                            />
                            <div v-if="project.is_featured" class="absolute top-4 right-4 z-20">
                                <span class="px-3 py-1 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-medium bg-cyan-500/20 text-cyan-400 border border-cyan-500/30">
                                    Featured
                                </span>
                            </div>
                        </div>

                        <!-- Project Content -->
                        <div :class="[
                            'space-y-4 sm:space-y-6 lg:space-y-8',
                            index % 2 === 1 ? 'lg:col-start-1' : ''
                        ]">
                            <div class="space-y-3 sm:space-y-4">
                                <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white group-hover:text-cyan-400 transition-colors duration-300">
                                    {{ project.title }}
                                </h3>
                                <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-400 leading-relaxed">
                                    {{ project.description }}
                                </p>
                            </div>

                            <!-- Technologies -->
                            <div v-if="project.technologies.length > 0" class="flex flex-wrap gap-2 sm:gap-3">
                                <span
                                    v-for="tech in project.technologies"
                                    :key="tech"
                                    class="px-3 py-1 sm:px-4 sm:py-2 bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl text-xs sm:text-sm md:text-base text-cyan-400 hover:bg-slate-700/50 hover:border-cyan-500/50 transition-all duration-300"
                                >
                                    {{ tech }}
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 lg:gap-6 pt-2 sm:pt-4">
                                <a
                                    v-if="project.live_url"
                                    :href="project.live_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="group inline-flex items-center justify-center gap-2 sm:gap-3 px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full text-white font-semibold hover:from-cyan-400 hover:to-blue-500 transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-cyan-500/25 text-sm sm:text-base lg:text-lg"
                                >
                                    <span>View Project</span>
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                                <a
                                    v-if="project.github_url"
                                    :href="project.github_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="group inline-flex items-center justify-center gap-2 sm:gap-3 px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 border border-slate-700 rounded-full text-white font-semibold hover:border-cyan-500 hover:bg-slate-900/50 transition-all duration-300 text-sm sm:text-base lg:text-lg"
                                >
                                    <span>View Code</span>
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.237 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Projects Button -->
            <div class="text-center mt-12 sm:mt-16 lg:mt-20 opacity-0 transform translate-y-[30px]">
                <a
                    href="#contact"
                    class="inline-flex items-center gap-2 sm:gap-3 px-8 sm:px-10 lg:px-12 py-4 sm:py-5 lg:py-6 border border-slate-700 rounded-full text-white font-semibold hover:border-cyan-500 hover:bg-slate-900/50 transition-all duration-300 text-base sm:text-lg lg:text-xl"
                >
                    <span>Want to see more? Let's talk!</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.bg-grid-gray-900\/5 {
    background-image: linear-gradient(to right, rgb(17 24 39 / 0.05) 1px, transparent 1px),
                      linear-gradient(to bottom, rgb(17 24 39 / 0.05) 1px, transparent 1px);
}

.bg-grid-white\/5 {
    background-image: linear-gradient(to right, rgb(255 255 255 / 0.05) 1px, transparent 1px),
                      linear-gradient(to bottom, rgb(255 255 255 / 0.05) 1px, transparent 1px);
}

.animate-in {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

/* Add smooth transitions for filtered items */
.grid > div {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Add hover animation for project cards */
.group:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Add smooth transition for modal */
.modal-enter-active,
.modal-leave-active {
    transition: all 0.3s ease-out;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

/* Update transition group animations */
.projects-grid-move {
    transition: transform 0.5s ease-out;
}

.projects-grid-enter-active,
.projects-grid-leave-active {
    transition: all 0.5s ease-out;
}

.projects-grid-enter-from,
.projects-grid-leave-to {
    opacity: 0;
    transform: scale(0.95) translateY(20px);
}

.projects-grid-leave-active {
    position: absolute;
}

.projects-container {
    width: 100%;
    min-height: 200px;
    position: relative;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1rem;
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.5rem;
    width: 100%;
    justify-content: center;
}

@media (min-width: 640px) {
    .projects-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
}

@media (min-width: 1024px) {
    .projects-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.project-card {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

/* Update modal styles for better mobile experience */
@media (max-width: 640px) {
    .sm\:max-w-4xl {
        max-width: calc(100vw - 2rem);
        margin: 1rem;
    }

    .h-72 {
        height: 200px;
    }

    .grid-cols-3 {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Enhance transitions */
.group {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.group:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Improve modal transitions */
.modal-enter-active,
.modal-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

/* Update project card animations */
.projects-grid-move {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.projects-grid-enter-active,
.projects-grid-leave-active {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.projects-grid-enter-from,
.projects-grid-leave-to {
    opacity: 0;
    transform: scale(0.98) translateY(10px);
}

.projects-grid-leave-active {
    position: absolute;
}
</style>


<script setup lang="ts">
import { useScrollAnimation } from '@/composables/useScrollAnimation';
import { computed, ref, watch } from 'vue';

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

const selectedProject = ref<Project | null>(null);
const isModalOpen = ref(false);
const selectedFilter = ref('all');
const imageLoading = ref<Record<number, boolean>>({});

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

// Get unique technology categories for filtering
const technologyFilters = computed(() => {
    const techs = new Set<string>();
    activeProjects.value.forEach(project => {
        project.technologies.forEach(tech => techs.add(tech));
    });
    return ['all', ...Array.from(techs).slice(0, 8)]; // Limit to 8 main technologies
});

// Filter and sort active projects with proper technology parsing
const activeProjects = computed(() => {
    return props.projects
        .filter(project => project.is_active)
        .map(project => ({
            ...project,
            technologies: parseTechnologies(project.technologies)
        }))
        .sort((a, b) => {
            // Featured projects first, then by sort order
            if (a.is_featured && !b.is_featured) return -1;
            if (!a.is_featured && b.is_featured) return 1;
            return a.sort_order - b.sort_order;
        });
});

// Filtered projects based on selected technology
const filteredProjects = computed(() => {
    if (selectedFilter.value === 'all') {
        return activeProjects.value;
    }
    return activeProjects.value.filter(project =>
        project.technologies.includes(selectedFilter.value)
    );
});

// Open project modal
const openProjectModal = (project: Project) => {
    selectedProject.value = project;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

// Close project modal
const closeModal = () => {
    isModalOpen.value = false;
    selectedProject.value = null;
    document.body.style.overflow = 'auto';
};

// Handle image loading states
const handleImageLoad = (projectId: number) => {
    imageLoading.value[projectId] = false;
};

const handleImageError = (projectId: number) => {
    imageLoading.value[projectId] = false;
};

// Initialize image loading states
watch(activeProjects, (projects) => {
    projects.forEach(project => {
        imageLoading.value[project.id] = true;
    });
}, { immediate: true });

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.projects-header',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.projects-filters',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6, delay: 0.2 }
    },
    {
        selector: '.project-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 },
        staggerDelay: 0.1
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

            <!-- Interactive Technology Filters -->
            <div class="projects-filters mb-8 sm:mb-12 lg:mb-16 opacity-0 transform translate-y-[20px]">
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3 md:gap-4">
                    <button
                        v-for="filter in technologyFilters"
                        :key="filter"
                        @click="selectedFilter = filter"
                        :class="[
                            'px-4 sm:px-6 py-2 sm:py-3 rounded-full text-xs sm:text-sm md:text-base font-medium transition-all duration-300 transform hover:scale-105',
                            selectedFilter === filter
                                ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg shadow-cyan-500/25 scale-105'
                                : 'bg-slate-800/50 text-gray-400 hover:bg-slate-700/50 hover:text-white border border-slate-700 hover:border-slate-600'
                        ]"
                    >
                        {{ filter === 'all' ? 'All Projects' : filter }}
                        <span v-if="filter !== 'all'" class="ml-2 text-xs opacity-75">
                            ({{ activeProjects.filter(p => p.technologies.includes(filter)).length }})
                        </span>
                    </button>
                </div>
            </div>

            <div v-if="filteredProjects.length === 0" class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-800/50 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <p class="text-gray-400 text-lg">No projects found for this filter.</p>
            </div>

            <!-- Enhanced Project Grid with Transitions -->
            <div v-else class="space-y-8 sm:space-y-12 lg:space-y-16">
                <TransitionGroup name="project-list" tag="div" class="space-y-8 sm:space-y-12 lg:space-y-16">
                    <div
                        v-for="(project, index) in filteredProjects"
                        :key="project.id"
                        class="project-card group relative opacity-0 transform translate-y-[50px] cursor-pointer"
                        @click="openProjectModal(project)"
                    >
                        <div
                            :class="[
                                'grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center',
                                index % 2 === 1 ? 'lg:grid-flow-col-dense' : ''
                            ]"
                        >
                            <!-- Enhanced Project Image -->
                            <div :class="[
                                'relative overflow-hidden rounded-xl sm:rounded-2xl lg:rounded-3xl group-hover:scale-105 transition-all duration-500',
                                index % 2 === 1 ? 'lg:col-start-2' : ''
                            ]">
                                <!-- Loading Skeleton -->
                                <div v-if="imageLoading[project.id]" class="absolute inset-0 bg-slate-800 animate-pulse rounded-xl sm:rounded-2xl lg:rounded-3xl"></div>

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/20 to-blue-600/20 rounded-xl sm:rounded-2xl lg:rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center">
                                    <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                        <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-full flex items-center justify-center mb-4 mx-auto">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium">Click to view details</p>
                                    </div>
                                </div>

                                <img
                                    :src="project.image_url || 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=600&h=400&fit=crop&crop=center'"
                                    :alt="project.title"
                                    class="w-full h-64 sm:h-80 lg:h-96 object-cover transition-transform duration-500 group-hover:scale-110"
                                    @load="handleImageLoad(project.id)"
                                    @error="handleImageError(project.id)"
                                />

                                <!-- Featured Badge -->
                                <div v-if="project.is_featured" class="absolute top-4 right-4 z-20">
                                    <span class="px-3 py-1 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-medium bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-lg animate-pulse">
                                        ⭐ Featured
                                    </span>
                                </div>
                            </div>

                            <!-- Enhanced Project Content -->
                            <div :class="[
                                'space-y-4 sm:space-y-6 lg:space-y-8',
                                index % 2 === 1 ? 'lg:col-start-1' : ''
                            ]">
                                <div class="space-y-3 sm:space-y-4">
                                    <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white group-hover:text-cyan-400 transition-colors duration-300">
                                        {{ project.title }}
                                    </h3>
                                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-400 leading-relaxed line-clamp-3">
                                        {{ project.description }}
                                    </p>
                                </div>

                                <!-- Animated Technologies -->
                                <div v-if="project.technologies.length > 0" class="flex flex-wrap gap-2 sm:gap-3">
                                    <span
                                        v-for="(tech, techIndex) in project.technologies.slice(0, 6)"
                                        :key="tech"
                                        :style="{ animationDelay: `${techIndex * 100}ms` }"
                                        class="px-3 py-1 sm:px-4 sm:py-2 bg-slate-800/50 border border-slate-700 rounded-lg sm:rounded-xl text-xs sm:text-sm md:text-base text-cyan-400 hover:bg-slate-700/50 hover:border-cyan-500/50 transition-all duration-300 hover:scale-105 animate-fade-in-up"
                                    >
                                        {{ tech }}
                                    </span>
                                    <span v-if="project.technologies.length > 6" class="px-3 py-1 sm:px-4 sm:py-2 bg-slate-800/30 border border-slate-700 rounded-lg sm:rounded-xl text-xs sm:text-sm md:text-base text-gray-500">
                                        +{{ project.technologies.length - 6 }} more
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 lg:gap-6 pt-2 sm:pt-4">
                                    <button
                                        @click.stop="openProjectModal(project)"
                                        class="group inline-flex items-center justify-center gap-2 sm:gap-3 px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full text-white font-semibold hover:from-cyan-400 hover:to-blue-500 transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-cyan-500/25 text-sm sm:text-base lg:text-lg"
                                    >
                                        <span>View Details</span>
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>

                                    <div class="flex gap-3 sm:gap-4">
                                        <a
                                            v-if="project.live_url"
                                            :href="project.live_url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            @click.stop
                                            class="group inline-flex items-center justify-center gap-2 sm:gap-3 px-4 sm:px-6 lg:px-8 py-3 sm:py-4 lg:py-5 border border-slate-700 rounded-full text-white font-semibold hover:border-cyan-500 hover:bg-slate-900/50 transition-all duration-300 text-sm sm:text-base lg:text-lg"
                                        >
                                            <span>Live Demo</span>
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                        <a
                                            v-if="project.github_url"
                                            :href="project.github_url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            @click.stop
                                            class="group inline-flex items-center justify-center gap-2 sm:gap-3 px-4 sm:px-6 lg:px-8 py-3 sm:py-4 lg:py-5 border border-slate-700 rounded-full text-white font-semibold hover:border-cyan-500 hover:bg-slate-900/50 transition-all duration-300 text-sm sm:text-base lg:text-lg"
                                        >
                                            <span>GitHub</span>
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </TransitionGroup>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-12 sm:mt-16 lg:mt-20 opacity-0 transform translate-y-[30px]">
                <a
                    href="#contact"
                    class="inline-flex items-center gap-2 sm:gap-3 px-8 sm:px-10 lg:px-12 py-4 sm:py-5 lg:py-6 border border-slate-700 rounded-full text-white font-semibold hover:border-cyan-500 hover:bg-slate-900/50 transition-all duration-300 transform hover:scale-105 text-base sm:text-lg lg:text-xl"
                >
                    <span>Want to see more? Let's talk!</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Interactive Project Modal -->
        <Teleport to="body">
            <Transition name="modal">
                <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <!-- Backdrop -->
                    <div
                        class="absolute inset-0 bg-black/80 backdrop-blur-sm"
                        @click="closeModal"
                    ></div>

                    <!-- Modal Content -->
                    <div v-if="selectedProject" class="relative bg-slate-900 rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden border border-slate-700 shadow-2xl">
                        <!-- Close Button -->
                        <button
                            @click="closeModal"
                            class="absolute top-4 right-4 z-10 w-10 h-10 bg-slate-800/80 hover:bg-slate-700 rounded-full flex items-center justify-center text-gray-400 hover:text-white transition-colors duration-200"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <!-- Modal Body -->
                        <div class="flex flex-col lg:flex-row h-full max-h-[90vh]">
                            <!-- Project Image -->
                            <div class="lg:w-1/2 h-64 lg:h-auto">
                                <img
                                    :src="selectedProject.image_url || 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&h=600&fit=crop&crop=center'"
                                    :alt="selectedProject.title"
                                    class="w-full h-full object-cover"
                                />
                            </div>

                            <!-- Project Details -->
                            <div class="lg:w-1/2 p-6 lg:p-8 overflow-y-auto">
                                <div class="space-y-6">
                                    <!-- Title and Featured Badge -->
                                    <div>
                                        <div class="flex items-center gap-3 mb-3">
                                            <h3 class="text-2xl lg:text-3xl font-bold text-white">{{ selectedProject.title }}</h3>
                                            <span v-if="selectedProject.is_featured" class="px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-500 to-orange-500 text-white">
                                                ⭐ Featured
                                            </span>
                                        </div>
                                        <p class="text-gray-400 leading-relaxed">{{ selectedProject.description }}</p>
                                    </div>

                                    <!-- Technologies -->
                                    <div>
                                        <h4 class="text-lg font-semibold text-white mb-3">Technologies Used</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <span
                                                v-for="tech in selectedProject.technologies"
                                                :key="tech"
                                                class="px-3 py-1 bg-slate-800 border border-slate-700 rounded-lg text-sm text-cyan-400"
                                            >
                                                {{ tech }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                        <a
                                            v-if="selectedProject.live_url"
                                            :href="selectedProject.live_url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full text-white font-semibold hover:from-cyan-400 hover:to-blue-500 transition-all duration-300 transform hover:scale-105"
                                        >
                                            <span>View Live Demo</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                        <a
                                            v-if="selectedProject.github_url"
                                            :href="selectedProject.github_url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-slate-700 rounded-full text-white font-semibold hover:border-cyan-500 hover:bg-slate-800/50 transition-all duration-300"
                                        >
                                            <span>View on GitHub</span>
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </section>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Modal Animations */
.modal-enter-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-leave-active {
    transition: all 0.2s cubic-bezier(0.4, 0, 1, 1);
}

.modal-enter-from {
    opacity: 0;
    transform: scale(0.95);
}

.modal-leave-to {
    opacity: 0;
    transform: scale(1.05);
}

/* Project List Transitions */
.project-list-move,
.project-list-enter-active,
.project-list-leave-active {
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.project-list-enter-from {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
}

.project-list-leave-to {
    opacity: 0;
    transform: translateY(-30px) scale(0.95);
}

.project-list-leave-active {
    position: absolute;
    width: 100%;
}

/* Enhanced Hover Effects */
.group {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.group:hover {
    transform: translateY(-8px);
}

.group:hover .project-image {
    transform: scale(1.05);
}

/* Fade In Up Animation for Tech Tags */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
}

/* Loading Shimmer Effect */
@keyframes shimmer {
    0% {
        background-position: -200px 0;
    }
    100% {
        background-position: calc(200px + 100%) 0;
    }
}

.animate-pulse {
    background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%);
    background-size: 200px 100%;
    animation: shimmer 2s infinite;
}

/* Filter Button Animations */
.projects-filters button {
    position: relative;
    overflow: hidden;
}

.projects-filters button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s;
}

.projects-filters button:hover::before {
    left: 100%;
}

/* Enhanced Card Shadows */
.project-card {
    position: relative;
}

.project-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(59, 130, 246, 0.1));
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 1.5rem;
    z-index: -1;
}

.project-card:hover::before {
    opacity: 1;
}

/* Image Overlay Effects */
.project-image-overlay {
    background: linear-gradient(
        135deg,
        rgba(6, 182, 212, 0.3) 0%,
        rgba(59, 130, 246, 0.3) 50%,
        rgba(147, 51, 234, 0.3) 100%
    );
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar for modal */
.overflow-y-auto {
    scrollbar-width: thin;
    scrollbar-color: #475569 transparent;
}

.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background-color: #475569;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background-color: #64748b;
}

/* Responsive Improvements */
@media (max-width: 640px) {
    .modal-enter-from,
    .modal-leave-to {
        transform: scale(0.9) translateY(20px);
    }

    .project-card {
        margin-bottom: 2rem;
    }
}

/* Focus States for Accessibility */
.projects-filters button:focus-visible,
.project-card:focus-visible {
    outline: 2px solid #06b6d4;
    outline-offset: 2px;
}

/* High Contrast Mode Support */
@media (prefers-contrast: high) {
    .bg-slate-800\/50 {
        background-color: #000;
        border: 2px solid #fff;
    }

    .text-gray-400 {
        color: #fff;
    }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .group,
    .modal-enter-active,
    .modal-leave-active,
    .project-list-move,
    .project-list-enter-active,
    .project-list-leave-active,
    .animate-fade-in-up,
    .animate-pulse {
        animation-duration: 0.01s !important;
        transition-duration: 0.01s !important;
    }

    .group:hover {
        transform: none;
    }
}

/* Interactive Elements */
.interactive-element {
    cursor: pointer;
    user-select: none;
}

.interactive-element:active {
    transform: scale(0.98);
}

/* Badge Animations */
@keyframes badge-pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
}

.animate-pulse {
    animation: badge-pulse 2s infinite;
}

/* Gradient Text Effects */
.gradient-text {
    background: linear-gradient(135deg, #06b6d4, #3b82f6, #8b5cf6);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradient-shift 3s ease infinite;
}

@keyframes gradient-shift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

/* Loading States */
.loading-placeholder {
    background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%);
    background-size: 200% 100%;
    animation: loading-shimmer 2s infinite;
}

@keyframes loading-shimmer {
    0% {
        background-position: -200% 0;
    }
    100% {
        background-position: 200% 0;
    }
}

/* Enhanced Button Hover Effects */
.enhanced-button {
    position: relative;
    overflow: hidden;
    isolation: isolate;
}

.enhanced-button::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.2) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

.enhanced-button:hover::before {
    transform: translateX(100%);
}

/* Stagger Animation Delays */
.tech-tag-1 { animation-delay: 0.1s; }
.tech-tag-2 { animation-delay: 0.2s; }
.tech-tag-3 { animation-delay: 0.3s; }
.tech-tag-4 { animation-delay: 0.4s; }
.tech-tag-5 { animation-delay: 0.5s; }
.tech-tag-6 { animation-delay: 0.6s; }
</style>


<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { TransitionGroup } from 'vue';

interface Project {
    title: string;
    description: string;
    technologies: string[];
    image: string;
    link: string;
    category: string;
    features: string[];
    year: string;
    color: string;
    stats: {
        label: string;
        value: string;
    }[];
}

const projects: Project[] = [
    {
        title: 'POS System',
        description: 'A comprehensive Point of Sale system with real-time inventory tracking, sales analytics, and multi-branch management capabilities.',
        technologies: ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS', 'REST API'],
        image: 'https://raw.githubusercontent.com/tailwindui/catalyst/main/src/img/screenshots/inventory.png',
        link: '#',
        category: 'Web Application',
        features: [
            'Real-time inventory management',
            'Sales analytics and reporting',
            'Multi-branch support',
            'User role management',
            'Automated stock alerts',
            'Custom reporting tools'
        ],
        year: '2023',
        color: 'blue',
        stats: [
            { label: 'Active Users', value: '500+' },
            { label: 'Transactions', value: '1M+' },
            { label: 'Uptime', value: '99.9%' }
        ]
    },
    {
        title: 'Assessment Tools',
        description: 'Modern web-based assessment platform featuring automated grading, detailed analytics, and comprehensive reporting system.',
        technologies: ['Laravel', 'Vue.js', 'Tailwind CSS', 'Alpine.js', 'Charts.js'],
        image: 'https://raw.githubusercontent.com/tailwindui/catalyst/main/src/img/screenshots/analytics.png',
        link: '#',
        category: 'Education',
        features: [
            'Automated grading system',
            'Performance analytics',
            'Custom assessment creation',
            'Result reporting',
            'Student progress tracking',
            'Interactive dashboards'
        ],
        year: '2023',
        color: 'purple',
        stats: [
            { label: 'Students', value: '10K+' },
            { label: 'Assessments', value: '50K+' },
            { label: 'Schools', value: '25+' }
        ]
    },
    {
        title: 'Department Management Systems',
        description: 'Suite of integrated web systems designed for government departments, focusing on workflow automation and document management.',
        technologies: ['Laravel', 'Livewire', 'Bootstrap', 'MySQL', 'PDF Generation'],
        image: 'https://raw.githubusercontent.com/tailwindui/catalyst/main/src/img/screenshots/documents.png',
        link: '#',
        category: 'Government',
        features: [
            'Document management',
            'Workflow automation',
            'Digital signatures',
            'Audit logging',
            'Role-based access',
            'Compliance tracking'
        ],
        year: '2022',
        color: 'emerald',
        stats: [
            { label: 'Documents', value: '1M+' },
            { label: 'Users', value: '1000+' },
            { label: 'Departments', value: '15+' }
        ]
    }
];

const activeProject = ref<Project | null>(null);
const isModalOpen = ref(false);
const selectedCategory = ref('all');

// Add refs for animation
const sectionRef = ref<HTMLElement | null>(null);
const headerRef = ref<HTMLElement | null>(null);
const categoryFilterRef = ref<HTMLElement | null>(null);

const categories = computed(() => {
    const cats = ['all', ...new Set(projects.map(p => p.category.toLowerCase()))];
    return cats.map(cat => ({
        id: cat,
        name: cat === 'all' ? 'All Projects' : cat
    }));
});

const filteredProjects = computed(() => {
    if (selectedCategory.value === 'all') return projects;
    return projects.filter(p => p.category.toLowerCase() === selectedCategory.value);
});

const openProjectDetails = (project: Project) => {
    activeProject.value = project;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    isModalOpen.value = false;
    document.body.style.overflow = 'auto';
    setTimeout(() => {
        activeProject.value = null;
    }, 300);
};

const getProjectColor = (color: string) => {
    const colors = {
        blue: 'from-blue-500 to-blue-700',
        purple: 'from-purple-500 to-purple-700',
        emerald: 'from-emerald-500 to-emerald-700'
    };
    return colors[color as keyof typeof colors] || 'from-primary-500 to-primary-700';
};

const getProjectBadgeColors = (color: string) => {
    const colors = {
        blue: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
        purple: 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300',
        emerald: 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300'
    };
    return colors[color as keyof typeof colors] || 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300';
};

onMounted(() => {
    // Create intersection observer for section header
    const headerObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    headerObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    // Create intersection observer for category filter
    const filterObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    filterObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    // Observe header
    if (headerRef.value) {
        headerObserver.observe(headerRef.value);
    }

    // Observe category filter
    if (categoryFilterRef.value) {
        filterObserver.observe(categoryFilterRef.value);
    }
});
</script>

<template>
    <section id="projects" ref="sectionRef" class="relative py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-b from-white to-gray-50 dark:from-gray-800 dark:to-gray-900">
            <div class="absolute inset-0 bg-grid-gray-900/5 dark:bg-grid-white/5 bg-[size:3rem_3rem]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto">
            <!-- Section Header -->
            <div ref="headerRef" class="text-center mb-16 opacity-0 translate-y-8 transition-all duration-700 ease-out">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text">
                        Featured Projects
                    </span>
                </h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto text-lg">
                    Explore my latest work and projects that showcase my expertise in web development and system design.
                </p>
            </div>

            <!-- Category Filter -->
            <div ref="categoryFilterRef" class="flex justify-center mb-12 space-x-2 opacity-0 translate-y-8 transition-all duration-700 ease-out">
                <button
                    v-for="category in categories"
                    :key="category.id"
                    @click="selectedCategory = category.id"
                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 transform hover:scale-105"
                    :class="[
                        selectedCategory === category.id
                            ? 'bg-primary-500 text-black shadow-lg shadow-primary-500/25 dark:shadow-primary-500/40 capitalize'
                            : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 capitalize'
                    ]"
                >
                    {{ category.name }}
                </button>
            </div>

            <!-- Projects Grid -->
            <TransitionGroup
                name="projects-grid"
                tag="div"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
            >
                <div v-for="(project, index) in filteredProjects"
                     :key="project.title"
                     class="group relative bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2"
                     :style="{ transitionDelay: `${index * 100}ms` }">
                    <!-- Project Image -->
                    <div class="relative h-56 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br"
                             :class="[`${getProjectColor(project.color)}/20`]"></div>
                        <img :src="project.image" :alt="project.title"
                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Project Info -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-3 py-1 text-sm rounded-full"
                                  :class="getProjectBadgeColors(project.color)">
                                {{ project.category }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ project.year }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            {{ project.title }}
                        </h3>

                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                            {{ project.description }}
                        </p>

                        <!-- Project Stats -->
                        <div class="grid grid-cols-3 gap-4 mb-4 py-3 border-y border-gray-100 dark:border-gray-700">
                            <div v-for="stat in project.stats" :key="stat.label" class="text-center">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">{{ stat.value }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ stat.label }}</div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4">
                            <span v-for="tech in project.technologies.slice(0, 3)"
                                  :key="tech"
                                  class="px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md">
                                {{ tech }}
                            </span>
                            <span v-if="project.technologies.length > 3"
                                  class="px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md">
                                +{{ project.technologies.length - 3 }} more
                            </span>
                        </div>

                        <button @click="openProjectDetails(project)"
                                class="w-full px-4 py-2 mt-2 text-sm font-medium text-white rounded-lg transition-all duration-300 bg-gradient-to-r"
                                :class="[getProjectColor(project.color)]">
                            View Details
                        </button>
                    </div>
                </div>
            </TransitionGroup>
        </div>

        <!-- Project Details Modal -->
        <div v-if="activeProject"
             class="fixed inset-0 z-50 overflow-y-auto"
             @click="closeModal">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div class="fixed inset-0 transition-opacity duration-300" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75 backdrop-blur-sm"></div>
                </div>

                <!-- Modal Panel -->
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all duration-300 sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
                     :class="isModalOpen ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                     @click.stop>
                    <div class="relative">
                        <div class="h-72 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br"
                                 :class="[`${getProjectColor(activeProject.color)}/20`]"></div>
                            <img :src="activeProject.image" :alt="activeProject.title"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>

                        <button @click="closeModal"
                                class="absolute top-4 right-4 p-2 rounded-full bg-black/50 hover:bg-black/70 text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Project Title Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 text-sm rounded-full bg-white/20 backdrop-blur-sm text-white">
                                    {{ activeProject.category }}
                                </span>
                                <span class="text-sm opacity-75">{{ activeProject.year }}</span>
                            </div>
                            <h3 class="text-3xl font-bold">{{ activeProject.title }}</h3>
                        </div>
                    </div>

                    <div class="px-6 py-8">
                        <!-- Project Stats -->
                        <div class="grid grid-cols-3 gap-6 mb-8 p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                            <div v-for="stat in activeProject.stats"
                                 :key="stat.label"
                                 class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ stat.value }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ stat.label }}</div>
                            </div>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 mb-8 text-lg leading-relaxed">
                            {{ activeProject.description }}
                        </p>

                        <div class="grid md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Key Features</h4>
                                <ul class="space-y-3">
                                    <li v-for="feature in activeProject.features"
                                        :key="feature"
                                        class="flex items-start text-gray-600 dark:text-gray-300">
                                        <svg class="w-5 h-5 mr-2 text-primary-500 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ feature }}
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Technologies Used</h4>
                                <div class="flex flex-wrap gap-2">
                                    <span v-for="tech in activeProject.technologies"
                                          :key="tech"
                                          class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full">
                                        {{ tech }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <a :href="activeProject.link"
                               class="inline-flex items-center px-6 py-3 text-base font-medium text-white rounded-lg transition-all duration-300 transform hover:scale-105 bg-gradient-to-r"
                               :class="[getProjectColor(activeProject.color)]">
                                Visit Project
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
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

/* Add transition group animations */
.projects-grid-move,
.projects-grid-enter-active,
.projects-grid-leave-active {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.projects-grid-enter-from,
.projects-grid-leave-to {
    opacity: 0;
    transform: translateY(30px);
}

.projects-grid-leave-active {
    position: absolute;
}
</style>

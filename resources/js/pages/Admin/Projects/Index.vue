<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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
    created_at: string;
}

const props = defineProps<{
    projects: Project[];
}>();

const searchQuery = ref('');
const selectedFilter = ref('');

const filteredProjects = computed(() => {
    return props.projects.filter(project => {
        const matchesSearch = project.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            project.description.toLowerCase().includes(searchQuery.value.toLowerCase());

        let matchesFilter = true;
        if (selectedFilter.value === 'featured') {
            matchesFilter = project.is_featured;
        } else if (selectedFilter.value === 'active') {
            matchesFilter = project.is_active;
        } else if (selectedFilter.value === 'inactive') {
            matchesFilter = !project.is_active;
        }

        return matchesSearch && matchesFilter;
    });
});

const stats = computed(() => ({
    total: props.projects.length,
    active: props.projects.filter(project => project.is_active).length,
    inactive: props.projects.filter(project => !project.is_active).length,
    featured: props.projects.filter(project => project.is_featured).length
}));

const deleteProject = (id: number) => {
    if (confirm('Are you sure you want to delete this project?')) {
        router.delete(route('admin.projects.destroy', id));
    }
};

const getTechColor = (index: number) => {
    const colors = [
        'bg-blue-100/20 text-blue-300 border-blue-400/20',
        'bg-green-100/20 text-green-300 border-green-400/20',
        'bg-purple-100/20 text-purple-300 border-purple-400/20',
        'bg-yellow-100/20 text-yellow-300 border-yellow-400/20',
        'bg-pink-100/20 text-pink-300 border-pink-400/20'
    ];
    return colors[index % colors.length];
};
</script>

<template>
    <Head title="Projects Management - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Projects Management</h1>
                                <p class="text-sm text-slate-300">Showcase your work and achievements</p>
                            </div>
                        </div>
                    </div>
                    <Link :href="route('admin.projects.create')"
                          class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-6 py-2.5 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Project
                    </Link>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium">Total Projects</p>
                            <p class="text-3xl font-bold text-white mt-1">{{ stats.total }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium">Active Projects</p>
                            <p class="text-3xl font-bold text-green-400 mt-1">{{ stats.active }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium">Featured Projects</p>
                            <p class="text-3xl font-bold text-yellow-400 mt-1">{{ stats.featured }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium">Inactive Projects</p>
                            <p class="text-3xl font-bold text-slate-400 mt-1">{{ stats.inactive }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-slate-500 to-slate-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search projects..."
                                class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                            />
                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="md:w-64">
                        <select
                            v-model="selectedFilter"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                        >
                            <option value="">All Projects</option>
                            <option value="featured" class="text-slate-900">Featured Only</option>
                            <option value="active" class="text-slate-900">Active Only</option>
                            <option value="inactive" class="text-slate-900">Inactive Only</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Projects Grid -->
            <div v-if="filteredProjects.length === 0" class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 text-center py-16">
                <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">No projects found</h3>
                <p class="text-slate-400">Get started by creating your first project.</p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="project in filteredProjects" :key="project.id"
                     class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden hover:bg-white/15 transition-all duration-200 group">
                    <!-- Project Image -->
                    <div class="relative h-48 bg-gradient-to-br from-slate-700 to-slate-800">
                        <img v-if="project.image_url"
                             :src="project.image_url"
                             :alt="project.title"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                        <div v-else class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                        </div>
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                            <span v-if="project.is_featured" class="px-2 py-1 bg-yellow-500/90 text-yellow-100 text-xs font-medium rounded-lg backdrop-blur-md">
                                Featured
                            </span>
                            <span :class="project.is_active ? 'bg-green-500/90 text-green-100' : 'bg-slate-500/90 text-slate-100'"
                                  class="px-2 py-1 text-xs font-medium rounded-lg backdrop-blur-md">
                                {{ project.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    <!-- Project Content -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-white group-hover:text-orange-300 transition-colors duration-200 line-clamp-1">
                                {{ project.title }}
                            </h3>
                            <div class="flex space-x-2 ml-4">
                                <Link :href="route('admin.projects.edit', project.id)"
                                      class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </Link>
                                <button @click="deleteProject(project.id)"
                                        class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <p class="text-slate-400 text-sm mb-4 line-clamp-2">{{ project.description }}</p>

                        <!-- Technologies -->
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span v-for="(tech, index) in project.technologies.slice(0, 3)" :key="index"
                                  :class="['inline-flex items-center px-2 py-1 rounded-md text-xs font-medium border', getTechColor(index)]">
                                {{ tech }}
                            </span>
                            <span v-if="project.technologies.length > 3"
                                  class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-100/20 text-slate-400 border border-slate-400/20">
                                +{{ project.technologies.length - 3 }}
                            </span>
                        </div>

                        <!-- Links -->
                        <div class="flex space-x-2">
                            <a v-if="project.github_url" :href="project.github_url" target="_blank"
                               class="flex-1 bg-white/10 hover:bg-white/20 text-white text-center py-2 px-3 rounded-lg text-sm transition-colors duration-200">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                                </svg>
                                Code
                            </a>
                            <a v-if="project.live_url" :href="project.live_url" target="_blank"
                               class="flex-1 bg-orange-500/20 hover:bg-orange-500/30 text-orange-300 text-center py-2 px-3 rounded-lg text-sm transition-colors duration-200">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Live
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

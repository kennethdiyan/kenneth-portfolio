<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    stats: {
        personal_infos: number;
        skills: number;
        projects: number;
        experiences: number;
        educations: number;
        certifications: number;
        contact_infos: number;
        social_links: number;
    }
}>();

const adminSections = [
    { name: 'Personal Info', route: 'admin.personal-info.index', createRoute: 'admin.personal-info.create', key: 'personal_infos', color: 'from-blue-500 to-purple-600', icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' },
    { name: 'Skills', route: 'admin.skills.index', createRoute: 'admin.skills.create', key: 'skills', color: 'from-green-500 to-teal-600', icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' },
    { name: 'Projects', route: 'admin.projects.index', createRoute: 'admin.projects.create', key: 'projects', color: 'from-orange-500 to-red-600', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
    { name: 'Experience', route: 'admin.experiences.index', createRoute: 'admin.experiences.create', key: 'experiences', color: 'from-cyan-500 to-blue-600', icon: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6' },
    { name: 'Education', route: 'admin.educations.index', createRoute: 'admin.educations.create', key: 'educations', color: 'from-purple-500 to-pink-600', icon: 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z' },
    { name: 'Certifications', route: 'admin.certifications.index', createRoute: 'admin.certifications.create', key: 'certifications', color: 'from-yellow-500 to-orange-600', icon: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z' },
    { name: 'Contact Info', route: 'admin.contact-info.index', createRoute: 'admin.contact-info.create', key: 'contact_infos', color: 'from-pink-500 to-rose-600', icon: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z' },
    { name: 'Social Links', route: 'admin.social-links.index', createRoute: 'admin.social-links.create', key: 'social_links', color: 'from-indigo-500 to-purple-600', icon: 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1' },
];
</script>

<template>
    <Head title="Portfolio Admin Dashboard" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <header class="backdrop-blur border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 lg:h-20">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-lg lg:text-xl font-bold text-white">Portfolio Admin</h1>
                                <p class="text-xs lg:text-sm text-gray-400 hidden sm:block">Content Management</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 lg:space-x-4">
                        <Link :href="route('portfolio.index')"
                              class="hidden sm:flex items-center space-x-2 px-3 lg:px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-200 text-white text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            <span>View Portfolio</span>
                        </Link>
                        <Link :href="route('dashboard')"
                              class="flex items-center space-x-2 px-3 lg:px-4 py-2 bg-cyan-500/20 hover:bg-cyan-500/30 rounded-xl transition-all duration-200 text-cyan-400 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            <span class="hidden sm:inline">Dashboard</span>
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
            <!-- Welcome Section -->
            <div class="mb-8 lg:mb-12">
                <div class="text-center lg:text-left">
                    <h2 class="text-2xl lg:text-4xl font-bold text-white mb-2 lg:mb-4">
                        Welcome back! 👋
                    </h2>
                    <p class="text-gray-400 text-sm lg:text-base max-w-2xl mx-auto lg:mx-0">
                        Manage your portfolio content, track your progress, and keep everything up to date.
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8 lg:mb-12">
                <div
                    v-for="section in adminSections"
                    :key="section.key"
                    class="group relative overflow-hidden bg-white/5 backdrop-blur border border-white/10 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:scale-105"
                >
                    <div class="absolute inset-0 bg-gradient-to-r opacity-10 group-hover:opacity-20 transition-opacity duration-300" :class="section.color"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3 lg:mb-4">
                            <div :class="`bg-gradient-to-r ${section.color} w-10 h-10 lg:w-12 lg:h-12 rounded-xl lg:rounded-2xl flex items-center justify-center`">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="section.icon"></path>
                                </svg>
                            </div>
                            <span class="text-2xl lg:text-3xl font-bold text-white">
                                {{ stats[section.key as keyof typeof stats] || 0 }}
                            </span>
                        </div>
                        <h3 class="text-sm lg:text-base font-semibold text-white mb-1 lg:mb-2">{{ section.name }}</h3>
                        <Link :href="route(section.route)"
                              class="text-xs lg:text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group/link">
                            <span>Manage items</span>
                            <svg class="w-3 h-3 lg:w-4 lg:h-4 ml-1 group-hover/link:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl lg:rounded-3xl p-6 lg:p-8">
                <div class="flex items-center justify-between mb-6 lg:mb-8">
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-white mb-1 lg:mb-2">Quick Actions</h3>
                        <p class="text-sm lg:text-base text-gray-400">Add new content to your portfolio</p>
                    </div>
                    <div class="hidden lg:block w-12 h-12 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
                    <Link
                        v-for="section in adminSections"
                        :key="section.createRoute"
                        :href="route(section.createRoute)"
                        class="group flex items-center space-x-3 lg:space-x-4 p-3 lg:p-4 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 rounded-xl lg:rounded-2xl transition-all duration-300 hover:scale-105"
                    >
                        <div :class="`bg-gradient-to-r ${section.color} w-8 h-8 lg:w-10 lg:h-10 rounded-lg lg:rounded-xl flex items-center justify-center flex-shrink-0`">
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm lg:text-base font-medium text-white group-hover:text-cyan-400 transition-colors duration-200 truncate">
                                Add {{ section.name }}
                            </p>
                            <p class="text-xs lg:text-sm text-gray-400 truncate">Create new {{ section.name.toLowerCase() }}</p>
                        </div>
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 group-hover:text-white group-hover:translate-x-1 transition-all duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </Link>
                </div>
            </div>
        </main>
    </div>
</template>

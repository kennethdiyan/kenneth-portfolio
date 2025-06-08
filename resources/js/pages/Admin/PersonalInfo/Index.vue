<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

interface PersonalInfo {
    id: number;
    label: string;
    value: string;
    is_active: boolean;
    sort_order: number;
}

defineProps<{
    personalInfos: PersonalInfo[];
}>();

const deletePersonalInfo = (id: number) => {
    if (confirm('Are you sure you want to delete this personal information?')) {
        router.delete(route('admin.personal-info.destroy', id));
    }
};
</script>

<template>
    <Head title="Personal Information - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <header class="backdrop-blur border-b border-white/10 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    <div class="flex items-center space-x-4">
                        <Link :href="route('admin.dashboard')"
                              class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200 group">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="text-sm lg:text-base font-medium">Dashboard</span>
                        </Link>
                        <div class="hidden sm:block w-px h-6 bg-white/20"></div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-lg lg:text-xl font-bold text-white">Personal Information</h1>
                                <p class="text-xs lg:text-sm text-gray-400 hidden sm:block">Manage personal details</p>
                            </div>
                        </div>
                    </div>
                    <Link :href="route('admin.personal-info.create')"
                          class="flex items-center space-x-2 px-4 lg:px-6 py-2 lg:py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 rounded-xl transition-all duration-200 text-white font-medium text-sm lg:text-base group hover:scale-105">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add New</span>
                    </Link>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
            <!-- Stats -->
            <div class="mb-6 lg:mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-xl lg:rounded-2xl p-4 lg:p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-white">{{ personalInfos.length }}</p>
                                <p class="text-sm text-gray-400">Total Items</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-xl lg:rounded-2xl p-4 lg:p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-white">{{ personalInfos.filter(info => info.is_active).length }}</p>
                                <p class="text-sm text-gray-400">Active</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-xl lg:rounded-2xl p-4 lg:p-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-white">{{ personalInfos.filter(info => !info.is_active).length }}</p>
                                <p class="text-sm text-gray-400">Inactive</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl lg:rounded-3xl overflow-hidden">
                <!-- Header -->
                <div class="p-6 lg:p-8 border-b border-white/10">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold text-white">Personal Information Items</h2>
                            <p class="text-sm lg:text-base text-gray-400 mt-1">Manage your personal information details</p>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Last updated: just now</span>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <div v-if="personalInfos.length === 0" class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-6 bg-gray-600/20 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">No personal information found</h3>
                        <p class="text-gray-400 mb-6">Get started by adding your first personal information item.</p>
                        <Link :href="route('admin.personal-info.create')"
                              class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 rounded-xl transition-all duration-200 text-white font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Add Personal Information</span>
                        </Link>
                    </div>

                    <div v-else class="min-w-full">
                        <!-- Desktop Table -->
                        <table class="hidden lg:table min-w-full">
                            <thead class="border-b border-white/10">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Label</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Value</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Order</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                <tr v-for="info in personalInfos" :key="info.id" class="group hover:bg-white/5 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-white">{{ info.label }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 max-w-xs truncate">{{ info.value }}</td>
                                    <td class="px-6 py-4">
                                        <span :class="info.is_active ? 'bg-green-500/20 text-green-400 border-green-500/30' : 'bg-red-500/20 text-red-400 border-red-500/30'"
                                              class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border">
                                            <div :class="info.is_active ? 'bg-green-400' : 'bg-red-400'" class="w-1.5 h-1.5 rounded-full mr-2"></div>
                                            {{ info.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-600/20 text-gray-400 text-xs font-medium">
                                            #{{ info.sort_order }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <Link :href="route('admin.personal-info.edit', info.id)"
                                              class="inline-flex items-center px-3 py-1.5 bg-cyan-500/20 hover:bg-cyan-500/30 text-cyan-400 rounded-lg text-xs font-medium transition-all duration-200 hover:scale-105">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </Link>
                                        <button @click="deletePersonalInfo(info.id)"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg text-xs font-medium transition-all duration-200 hover:scale-105">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Mobile Cards -->
                        <div class="lg:hidden space-y-4 p-4">
                            <div v-for="info in personalInfos" :key="info.id"
                                 class="bg-white/5 border border-white/10 rounded-xl p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-white">{{ info.label }}</span>
                                    </div>
                                    <span :class="info.is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'"
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium">
                                        {{ info.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-300">{{ info.value }}</p>
                                <div class="flex items-center justify-between pt-2 border-t border-white/10">
                                    <span class="text-xs text-gray-400">Order: #{{ info.sort_order }}</span>
                                    <div class="flex space-x-2">
                                        <Link :href="route('admin.personal-info.edit', info.id)"
                                              class="flex items-center px-3 py-1.5 bg-cyan-500/20 text-cyan-400 rounded-lg text-xs font-medium">
                                            Edit
                                        </Link>
                                        <button @click="deletePersonalInfo(info.id)"
                                                class="flex items-center px-3 py-1.5 bg-red-500/20 text-red-400 rounded-lg text-xs font-medium">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

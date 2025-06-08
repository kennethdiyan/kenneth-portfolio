<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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

const props = defineProps<{
    experiences: Experience[];
}>();

const searchQuery = ref('');
const statusFilter = ref('all');
const currentFilter = ref('all');

const filteredExperiences = computed(() => {
    return props.experiences.filter(experience => {
        const matchesSearch = experience.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                             experience.company.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                             experience.location.toLowerCase().includes(searchQuery.value.toLowerCase());

        const matchesStatus = statusFilter.value === 'all' ||
                             (statusFilter.value === 'active' && experience.is_active) ||
                             (statusFilter.value === 'inactive' && !experience.is_active);

        const matchesCurrent = currentFilter.value === 'all' ||
                              (currentFilter.value === 'current' && experience.is_current) ||
                              (currentFilter.value === 'past' && !experience.is_current);

        return matchesSearch && matchesStatus && matchesCurrent;
    });
});

const stats = computed(() => ({
    total: props.experiences.length,
    active: props.experiences.filter(e => e.is_active).length,
    inactive: props.experiences.filter(e => !e.is_active).length,
    current: props.experiences.filter(e => e.is_current).length
}));

const deleteExperience = (id: number) => {
    if (confirm('Are you sure you want to delete this experience?')) {
        router.delete(route('admin.experiences.destroy', id));
    }
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short'
    });
};

const formatDuration = (startDate: string, endDate: string | null) => {
    const start = new Date(startDate);
    const end = endDate ? new Date(endDate) : new Date();

    const diffInMonths = (end.getFullYear() - start.getFullYear()) * 12 +
                        (end.getMonth() - start.getMonth());

    const years = Math.floor(diffInMonths / 12);
    const months = diffInMonths % 12;

    if (years === 0) return `${months} month${months !== 1 ? 's' : ''}`;
    if (months === 0) return `${years} year${years !== 1 ? 's' : ''}`;
    return `${years} year${years !== 1 ? 's' : ''}, ${months} month${months !== 1 ? 's' : ''}`;
};
</script>

<template>
    <Head title="Experience Management - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">Experience Management</h1>
                            <p class="text-sm text-slate-300">Manage your work experience</p>
                        </div>
                    </div>
                    <Link :href="route('admin.experiences.create')"
                          class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Experience</span>
                    </Link>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-300">Total Experience</p>
                            <p class="text-2xl font-bold text-white">{{ stats.total }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-300">Active</p>
                            <p class="text-2xl font-bold text-white">{{ stats.active }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-300">Current</p>
                            <p class="text-2xl font-bold text-white">{{ stats.current }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-300">Inactive</p>
                            <p class="text-2xl font-bold text-white">{{ stats.inactive }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Search</label>
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search by title, company, or location..."
                            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                        <select
                            v-model="statusFilter"
                            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                        >
                            <option value="all">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Employment</label>
                        <select
                            v-model="currentFilter"
                            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                        >
                            <option value="all">All Positions</option>
                            <option value="current">Current</option>
                            <option value="past">Past</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Experience List -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-white/20">
                    <h3 class="text-lg font-semibold text-white">Experience Records ({{ filteredExperiences.length }})</h3>
                </div>

                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Position</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            <tr v-for="experience in filteredExperiences" :key="experience.id"
                                class="hover:bg-white/5 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ experience.title }}</div>
                                        <div class="text-sm text-slate-400">{{ experience.location }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-white">{{ experience.company }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-white">
                                        {{ formatDate(experience.start_date) }} -
                                        {{ experience.is_current ? 'Present' : formatDate(experience.end_date) }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ formatDuration(experience.start_date, experience.end_date) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <span v-if="experience.is_current"
                                              class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-300 border border-yellow-400/20">
                                            Current
                                        </span>
                                        <span :class="[
                                            'inline-flex px-2 py-1 text-xs font-semibold rounded-full border',
                                            experience.is_active
                                                ? 'bg-green-500/20 text-green-300 border-green-400/20'
                                                : 'bg-red-500/20 text-red-300 border-red-400/20'
                                        ]">
                                            {{ experience.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <Link :href="route('admin.experiences.edit', experience.id)"
                                              class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </Link>
                                        <button @click="deleteExperience(experience.id)"
                                                class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1V4a1 1 0 00-1-1H6a1 1 0 000 2h1m0 0h10m0 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1V6h10z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden">
                    <div v-for="experience in filteredExperiences" :key="experience.id"
                         class="p-6 border-b border-white/10 last:border-b-0">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="text-lg font-medium text-white">{{ experience.title }}</h4>
                                <p class="text-sm text-slate-300">{{ experience.company }}</p>
                                <p class="text-sm text-slate-400">{{ experience.location }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <Link :href="route('admin.experiences.edit', experience.id)"
                                      class="p-2 text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </Link>
                                <button @click="deleteExperience(experience.id)"
                                        class="p-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1V4a1 1 0 00-1-1H6a1 1 0 000 2h1m0 0h10m0 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1V6h10z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="text-sm text-white">
                                {{ formatDate(experience.start_date) }} -
                                {{ experience.is_current ? 'Present' : formatDate(experience.end_date) }}
                                <span class="text-slate-400 ml-1">
                                    ({{ formatDuration(experience.start_date, experience.end_date) }})
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span v-if="experience.is_current"
                                      class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-300 border border-yellow-400/20">
                                    Current
                                </span>
                                <span :class="[
                                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full border',
                                    experience.is_active
                                        ? 'bg-green-500/20 text-green-300 border-green-400/20'
                                        : 'bg-red-500/20 text-red-300 border-red-400/20'
                                ]">
                                    {{ experience.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="filteredExperiences.length === 0" class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">No experience found</h3>
                    <p class="text-slate-400 mb-6">Get started by adding your first work experience.</p>
                    <Link :href="route('admin.experiences.create')"
                          class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Your First Experience</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

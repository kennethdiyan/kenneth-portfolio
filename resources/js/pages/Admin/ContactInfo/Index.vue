<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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

const props = defineProps<{
    contactInfos: ContactInfo[];
}>();

const searchQuery = ref('');
const selectedType = ref('');

const filteredContactInfos = computed(() => {
    return props.contactInfos.filter(contactInfo => {
        const matchesSearch = contactInfo.label.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            contactInfo.value.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            contactInfo.type.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesType = !selectedType.value || contactInfo.type === selectedType.value;
        return matchesSearch && matchesType;
    }).sort((a, b) => a.sort_order - b.sort_order);
});

const contactTypes = computed(() => {
    return [...new Set(props.contactInfos.map(info => info.type))];
});

const stats = computed(() => ({
    total: props.contactInfos.length,
    active: props.contactInfos.filter(info => info.is_active).length,
    inactive: props.contactInfos.filter(info => !info.is_active).length,
    types: contactTypes.value.length
}));

const deleteContactInfo = (id: number) => {
    if (confirm('Are you sure you want to delete this contact information?')) {
        router.delete(route('admin.contact-info.destroy', id));
    }
};

const getTypeColor = (type: string) => {
    const colors: Record<string, string> = {
        'email': 'bg-blue-100/20 text-blue-300 border-blue-400/20',
        'phone': 'bg-green-100/20 text-green-300 border-green-400/20',
        'address': 'bg-purple-100/20 text-purple-300 border-purple-400/20',
        'website': 'bg-orange-100/20 text-orange-300 border-orange-400/20',
        'social': 'bg-pink-100/20 text-pink-300 border-pink-400/20'
    };
    return colors[type.toLowerCase()] || 'bg-slate-100/20 text-slate-300 border-slate-400/20';
};
</script>

<template>
    <Head title="Contact Information Management - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-red-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Contact Information</h1>
                                <p class="text-sm text-slate-300">Manage contact details and social links</p>
                            </div>
                        </div>
                    </div>
                    <Link :href="route('admin.contact-info.create')"
                          class="bg-gradient-to-r from-pink-500 to-red-600 hover:from-pink-600 hover:to-red-700 text-white px-6 py-2.5 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Contact Info
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
                            <p class="text-slate-300 text-sm font-medium">Total Contact Info</p>
                            <p class="text-3xl font-bold text-white mt-1">{{ stats.total }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium">Active</p>
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
                            <p class="text-slate-300 text-sm font-medium">Inactive</p>
                            <p class="text-3xl font-bold text-slate-400 mt-1">{{ stats.inactive }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-slate-500 to-slate-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium">Contact Types</p>
                            <p class="text-3xl font-bold text-pink-400 mt-1">{{ stats.types }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-red-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
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
                                placeholder="Search contact information..."
                                class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-md"
                            />
                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="md:w-64">
                        <select
                            v-model="selectedType"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-md"
                        >
                            <option value="">All Types</option>
                            <option v-for="type in contactTypes" :key="type" :value="type" class="text-slate-900">
                                {{ type }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Contact Info Table/Cards -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden">
                <div v-if="filteredContactInfos.length === 0" class="text-center py-16">
                    <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">No contact information found</h3>
                    <p class="text-slate-400">Get started by adding your first contact information.</p>
                </div>

                <!-- Desktop Table -->
                <div v-else class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5 border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Label</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Value</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Icon</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            <tr v-for="contactInfo in filteredContactInfos" :key="contactInfo.id" class="hover:bg-white/5 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border', getTypeColor(contactInfo.type)]">
                                        {{ contactInfo.type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-white">{{ contactInfo.label }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a v-if="contactInfo.href"
                                       :href="contactInfo.href"
                                       class="text-cyan-400 hover:text-cyan-300 transition-colors duration-200 text-sm"
                                       target="_blank">
                                        {{ contactInfo.value }}
                                        <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                    <span v-else class="text-sm text-slate-300">{{ contactInfo.value }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-400 font-mono">{{ contactInfo.icon }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100/20 text-gray-300 border border-gray-400/20">
                                        {{ contactInfo.sort_order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span v-if="contactInfo.is_active" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100/20 text-green-300 border border-green-400/20">
                                        Active
                                    </span>
                                    <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100/20 text-slate-400 border border-slate-400/20">
                                        Inactive
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <Link :href="route('admin.contact-info.edit', contactInfo.id)"
                                              class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </Link>
                                        <button @click="deleteContactInfo(contactInfo.id)"
                                                class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-4 p-4">
                    <div v-for="contactInfo in filteredContactInfos" :key="contactInfo.id"
                         class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border', getTypeColor(contactInfo.type)]">
                                        {{ contactInfo.type }}
                                    </span>
                                    <span class="text-xs text-slate-400">Order: {{ contactInfo.sort_order }}</span>
                                </div>
                                <h3 class="text-lg font-medium text-white">{{ contactInfo.label }}</h3>
                                <div class="mt-1">
                                    <a v-if="contactInfo.href"
                                       :href="contactInfo.href"
                                       class="text-cyan-400 hover:text-cyan-300 transition-colors duration-200 text-sm"
                                       target="_blank">
                                        {{ contactInfo.value }}
                                        <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                    <span v-else class="text-sm text-slate-300">{{ contactInfo.value }}</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1 font-mono">Icon: {{ contactInfo.icon }}</p>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                <Link :href="route('admin.contact-info.edit', contactInfo.id)"
                                      class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </Link>
                                <button @click="deleteContactInfo(contactInfo.id)"
                                        class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span v-if="contactInfo.is_active" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100/20 text-green-300 border border-green-400/20">
                                Active
                            </span>
                            <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100/20 text-slate-400 border border-slate-400/20">
                                Inactive
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

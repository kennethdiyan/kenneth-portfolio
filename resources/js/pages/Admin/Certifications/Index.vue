<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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

const props = defineProps<{
    certifications: Certification[];
}>();

const searchQuery = ref('');
const selectedStatus = ref('');

const filteredCertifications = computed(() => {
    return props.certifications.filter(certification => {
        const matchesSearch = certification.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            certification.issuer.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesStatus = !selectedStatus.value ||
                            (selectedStatus.value === 'active' && certification.is_active) ||
                            (selectedStatus.value === 'inactive' && !certification.is_active) ||
                            (selectedStatus.value === 'expired' && isExpired(certification.expiry_date)) ||
                            (selectedStatus.value === 'valid' && !isExpired(certification.expiry_date));
        return matchesSearch && matchesStatus;
    });
});

const stats = computed(() => ({
    total: props.certifications.length,
    active: props.certifications.filter(cert => cert.is_active).length,
    expired: props.certifications.filter(cert => isExpired(cert.expiry_date)).length,
    valid: props.certifications.filter(cert => !isExpired(cert.expiry_date)).length
}));

const deleteCertification = (id: number) => {
    if (confirm('Are you sure you want to delete this certification?')) {
        router.delete(route('admin.certifications.destroy', id));
    }
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short'
    });
};

const isExpired = (date: string) => {
    return date && new Date(date) < new Date();
};
</script>

<template>
    <Head title="Certifications Management - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-yellow-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Certifications Management</h1>
                                <p class="text-sm text-slate-300">Manage professional certifications and credentials</p>
                            </div>
                        </div>
                    </div>
                    <Link :href="route('admin.certifications.create')"
                          class="bg-gradient-to-r from-orange-500 to-yellow-600 hover:from-orange-600 hover:to-yellow-700 text-white px-6 py-2.5 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Certification
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
                            <p class="text-slate-300 text-sm font-medium">Total Certifications</p>
                            <p class="text-3xl font-bold text-white mt-1">{{ stats.total }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium">Active Certs</p>
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
                            <p class="text-slate-300 text-sm font-medium">Valid Certs</p>
                            <p class="text-3xl font-bold text-blue-400 mt-1">{{ stats.valid }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-300 text-sm font-medium">Expired</p>
                            <p class="text-3xl font-bold text-red-400 mt-1">{{ stats.expired }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
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
                                placeholder="Search certifications..."
                                class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                            />
                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="md:w-64">
                        <select
                            v-model="selectedStatus"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                        >
                            <option value="">All Status</option>
                            <option value="active" class="text-slate-900">Active</option>
                            <option value="inactive" class="text-slate-900">Inactive</option>
                            <option value="valid" class="text-slate-900">Valid</option>
                            <option value="expired" class="text-slate-900">Expired</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Certifications Table/Cards -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden">
                <div v-if="filteredCertifications.length === 0" class="text-center py-16">
                    <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">No certifications found</h3>
                    <p class="text-slate-400">Get started by adding your first certification.</p>
                </div>

                <!-- Desktop Table -->
                <div v-else class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5 border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Certification</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Issuer</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Issue Date</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Expiry</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            <tr v-for="certification in filteredCertifications" :key="certification.id" class="hover:bg-white/5 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ certification.name }}</div>
                                        <div v-if="certification.credential_id" class="text-sm text-slate-400">
                                            ID: {{ certification.credential_id }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-white">{{ certification.issuer }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-300">{{ formatDate(certification.issue_date) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div v-if="certification.expiry_date" class="space-y-1">
                                        <span :class="isExpired(certification.expiry_date) ? 'text-red-400' : 'text-slate-300'" class="text-sm">
                                            {{ formatDate(certification.expiry_date) }}
                                        </span>
                                        <div v-if="isExpired(certification.expiry_date)" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100/20 text-red-300 border border-red-400/20">
                                            Expired
                                        </div>
                                        <div v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100/20 text-green-300 border border-green-400/20">
                                            Valid
                                        </div>
                                    </div>
                                    <span v-else class="text-sm text-slate-400">No expiry</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span v-if="certification.is_active" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100/20 text-green-300 border border-green-400/20">
                                        Active
                                    </span>
                                    <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100/20 text-slate-400 border border-slate-400/20">
                                        Inactive
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a v-if="certification.credential_url"
                                           :href="certification.credential_url"
                                           target="_blank"
                                           class="text-cyan-400 hover:text-cyan-300 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                        <Link :href="route('admin.certifications.edit', certification.id)"
                                              class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </Link>
                                        <button @click="deleteCertification(certification.id)"
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
                    <div v-for="certification in filteredCertifications" :key="certification.id"
                         class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-white">{{ certification.name }}</h3>
                                <p class="text-sm text-slate-400 mt-1">{{ certification.issuer }}</p>
                                <p v-if="certification.credential_id" class="text-xs text-slate-400 mt-1">
                                    ID: {{ certification.credential_id }}
                                </p>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                <a v-if="certification.credential_url"
                                   :href="certification.credential_url"
                                   target="_blank"
                                   class="text-cyan-400 hover:text-cyan-300 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                                <Link :href="route('admin.certifications.edit', certification.id)"
                                      class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </Link>
                                <button @click="deleteCertification(certification.id)"
                                        class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100/20 text-orange-300 border border-orange-400/20">
                                Issued: {{ formatDate(certification.issue_date) }}
                            </span>
                            <span v-if="certification.expiry_date" :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border',
                                isExpired(certification.expiry_date)
                                    ? 'bg-red-100/20 text-red-300 border-red-400/20'
                                    : 'bg-green-100/20 text-green-300 border-green-400/20'
                            ]">
                                {{ isExpired(certification.expiry_date) ? 'Expired' : 'Valid' }}: {{ formatDate(certification.expiry_date) }}
                            </span>
                            <span v-if="certification.is_active" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100/20 text-green-300 border border-green-400/20">
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

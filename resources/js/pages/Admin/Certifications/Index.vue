<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

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

defineProps<{
    certifications: Certification[];
}>();

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
    <Head title="Certifications - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.dashboard')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Dashboard
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Certifications</h1>
                    </div>
                    <div class="flex items-center">
                        <Link :href="route('admin.certifications.create')">
                            <Button>Add New Certification</Button>
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Certification
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Issuer
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Issue Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expiry
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="certification in certifications" :key="certification.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ certification.name }}</div>
                                                <div v-if="certification.credential_id" class="text-sm text-gray-500">
                                                    ID: {{ certification.credential_id }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ certification.issuer }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatDate(certification.issue_date) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span v-if="certification.expiry_date">
                                                <span :class="isExpired(certification.expiry_date) ? 'text-red-600' : ''">
                                                    {{ formatDate(certification.expiry_date) }}
                                                </span>
                                                <span v-if="isExpired(certification.expiry_date)" class="ml-1 text-red-600 text-xs">
                                                    (Expired)
                                                </span>
                                            </span>
                                            <span v-else class="text-gray-400">No expiry</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="certification.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                                {{ certification.is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Link v-if="certification.credential_url"
                                                  :href="certification.credential_url"
                                                  target="_blank"
                                                  class="text-blue-600 hover:text-blue-900">
                                                View
                                            </Link>
                                            <Link :href="route('admin.certifications.edit', certification.id)"
                                                  class="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </Link>
                                            <button @click="deleteCertification(certification.id)"
                                                    class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

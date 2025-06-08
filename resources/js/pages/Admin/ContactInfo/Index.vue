<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

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

defineProps<{
    contactInfos: ContactInfo[];
}>();

const deleteContactInfo = (id: number) => {
    if (confirm('Are you sure you want to delete this contact information?')) {
        router.delete(route('admin.contact-info.destroy', id));
    }
};
</script>

<template>
    <Head title="Contact Information - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.dashboard')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Dashboard
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Contact Information</h1>
                    </div>
                    <div class="flex items-center">
                        <Link :href="route('admin.contact-info.create')">
                            <Button>Add New Contact Info</Button>
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
                                            Type
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Label
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Value
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Icon
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Sort Order
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
                                    <tr v-for="contactInfo in contactInfos" :key="contactInfo.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ contactInfo.type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ contactInfo.label }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <a v-if="contactInfo.href"
                                               :href="contactInfo.href"
                                               class="text-blue-600 hover:text-blue-900"
                                               target="_blank">
                                                {{ contactInfo.value }}
                                            </a>
                                            <span v-else>{{ contactInfo.value }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ contactInfo.icon }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ contactInfo.sort_order }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="contactInfo.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                                {{ contactInfo.is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Link :href="route('admin.contact-info.edit', contactInfo.id)"
                                                  class="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </Link>
                                            <button @click="deleteContactInfo(contactInfo.id)"
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

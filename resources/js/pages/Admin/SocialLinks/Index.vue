<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

interface SocialLink {
    id: number;
    name: string;
    url: string;
    icon: string;
    is_active: boolean;
    sort_order: number;
}

defineProps<{
    socialLinks: SocialLink[];
}>();

const deleteSocialLink = (id: number) => {
    if (confirm('Are you sure you want to delete this social link?')) {
        router.delete(route('admin.social-links.destroy', id));
    }
};
</script>

<template>
    <Head title="Social Links - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.dashboard')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Dashboard
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Social Links</h1>
                    </div>
                    <div class="flex items-center">
                        <Link :href="route('admin.social-links.create')">
                            <Button>Add New Social Link</Button>
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
                                            Platform
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            URL
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
                                    <tr v-for="socialLink in socialLinks" :key="socialLink.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ socialLink.name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <a :href="socialLink.url"
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-900 truncate max-w-xs block">
                                                {{ socialLink.url }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ socialLink.icon }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ socialLink.sort_order }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="socialLink.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                                {{ socialLink.is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Link :href="route('admin.social-links.edit', socialLink.id)"
                                                  class="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </Link>
                                            <button @click="deleteSocialLink(socialLink.id)"
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

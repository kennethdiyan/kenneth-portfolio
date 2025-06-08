<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

interface Education {
    id: number;
    degree: string;
    field_of_study: string;
    institution: string;
    location: string;
    start_date: string;
    end_date: string;
    gpa: string;
    description: string;
    achievements: string[];
    is_current: boolean;
    is_active: boolean;
}

defineProps<{
    educations: Education[];
}>();

const deleteEducation = (id: number) => {
    if (confirm('Are you sure you want to delete this education record?')) {
        router.delete(route('admin.educations.destroy', id));
    }
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short'
    });
};
</script>

<template>
    <Head title="Education - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.dashboard')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Dashboard
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Education</h1>
                    </div>
                    <div class="flex items-center">
                        <Link :href="route('admin.educations.create')">
                            <Button>Add New Education</Button>
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
                                            Degree
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Institution
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Duration
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            GPA
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
                                    <tr v-for="education in educations" :key="education.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ education.degree }}</div>
                                                <div class="text-sm text-gray-500">{{ education.field_of_study }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm text-gray-900">{{ education.institution }}</div>
                                                <div class="text-sm text-gray-500">{{ education.location }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatDate(education.start_date) }} -
                                            {{ education.is_current ? 'Present' : formatDate(education.end_date) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ education.gpa || 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="education.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                                {{ education.is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Link :href="route('admin.educations.edit', education.id)"
                                                  class="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </Link>
                                            <button @click="deleteEducation(education.id)"
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

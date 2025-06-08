<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

interface PersonalInfo {
    id: number;
    label: string;
    value: string;
    is_active: boolean;
    sort_order: number;
}

const props = defineProps<{
    personalInfo: PersonalInfo;
}>();

const form = useForm({
    label: props.personalInfo.label,
    value: props.personalInfo.value,
    is_active: props.personalInfo.is_active,
    sort_order: props.personalInfo.sort_order || 0
});

const submit = () => {
    form.put(route('admin.personal-info.update', props.personalInfo.id));
};

const commonLabels = [
    'Full Name',
    'Email',
    'Phone',
    'Location',
    'Title',
    'Bio',
    'Years Experience',
    'Projects Completed',
    'Happy Clients',
    'Website',
    'LinkedIn',
    'GitHub'
];
</script>

<template>
    <Head title="Edit Personal Info - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <Link :href="route('admin.personal-info.index')"
                              class="text-slate-300 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </Link>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-white">Edit Personal Info</h1>
                                <p class="text-sm text-slate-300">Update {{ personalInfo.label }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Form Content -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white mb-2">Update Information</h2>
                        <p class="text-slate-300">Modify your personal details below</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-8">
                        <!-- Basic Information -->
                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Basic Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        Label *
                                    </label>
                                    <select
                                        v-model="form.label"
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-md"
                                        required
                                    >
                                        <option value="" class="text-slate-900">Select a label</option>
                                        <option v-for="label in commonLabels" :key="label" :value="label" class="text-slate-900">
                                            {{ label }}
                                        </option>
                                    </select>
                                    <p class="text-sm text-slate-400 mt-2">Choose a descriptive label for this information</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        Sort Order
                                    </label>
                                    <input
                                        v-model.number="form.sort_order"
                                        type="number"
                                        min="0"
                                        placeholder="0"
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-md"
                                    />
                                    <p class="text-sm text-slate-400 mt-2">Lower numbers appear first</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Content
                            </h3>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Value *
                                </label>
                                <textarea
                                    v-model="form.value"
                                    rows="4"
                                    placeholder="Enter the information content..."
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-md resize-none"
                                    required
                                ></textarea>
                                <p class="text-sm text-slate-400 mt-2">Enter the actual content for this information piece</p>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                            </h3>
                            <div>
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_active"
                                        class="w-5 h-5 rounded border-white/20 bg-white/10 text-blue-500 focus:ring-blue-500 focus:ring-offset-0"
                                    />
                                    <div>
                                        <span class="text-white font-medium">Active</span>
                                        <p class="text-sm text-slate-400">Show this information on your portfolio</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-between items-center pt-6">
                            <Link :href="route('admin.personal-info.index')"
                                  class="px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all duration-200">
                                Cancel
                            </Link>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                :class="[
                                    'flex items-center space-x-2 px-6 py-2.5 rounded-xl transition-all duration-200',
                                    !form.processing
                                        ? 'bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white transform hover:scale-105'
                                        : 'bg-slate-600 text-slate-400 cursor-not-allowed'
                                ]"
                            >
                                <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>{{ form.processing ? 'Updating...' : 'Update Information' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

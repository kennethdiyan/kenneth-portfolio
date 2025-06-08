<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

const form = useForm({
    label: '',
    value: '',
    is_active: true,
    sort_order: 0,
});

const submit = () => {
    form.post(route('admin.personal-info.store'));
};
</script>

<template>
    <Head title="Create Personal Information - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <header class="backdrop-blur border-b border-white/10 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    <div class="flex items-center space-x-4">
                        <Link :href="route('admin.personal-info.index')"
                              class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200 group">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="text-sm lg:text-base font-medium">Personal Information</span>
                        </Link>
                        <div class="hidden sm:block w-px h-6 bg-white/20"></div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-lg lg:text-xl font-bold text-white">Create Personal Info</h1>
                                <p class="text-xs lg:text-sm text-gray-400 hidden sm:block">Add new personal information</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 lg:space-x-4">
                        <Link :href="route('admin.dashboard')"
                              class="flex items-center space-x-2 px-3 lg:px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-200 text-white text-sm">
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
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
            <!-- Progress Indicator -->
            <div class="mb-8 lg:mb-12">
                <div class="flex items-center space-x-4 text-sm">
                    <span class="text-gray-400">Step 1 of 1</span>
                    <div class="flex-1 h-1 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 w-full rounded-full"></div>
                    </div>
                    <span class="text-white font-medium">Basic Information</span>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl lg:rounded-3xl overflow-hidden">
                <!-- Form Header -->
                <div class="p-6 lg:p-8 border-b border-white/10">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold text-white">Personal Information Details</h2>
                            <p class="text-sm lg:text-base text-gray-400 mt-1">Fill in the information below to create a new personal information item</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form @submit.prevent="submit" class="p-6 lg:p-8 space-y-6 lg:space-y-8">
                    <!-- Label Field -->
                    <div class="space-y-2">
                        <label for="label" class="flex items-center space-x-2 text-sm lg:text-base font-medium text-white">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span>Label</span>
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            id="label"
                            v-model="form.label"
                            type="text"
                            class="w-full px-4 py-3 lg:py-4 bg-white/5 border border-white/20 rounded-xl lg:rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="e.g., Full Name, Email, Phone Number"
                            required
                        />
                        <p class="text-xs lg:text-sm text-gray-400">Choose a descriptive label for this information</p>
                        <InputError :message="form.errors.label" />
                    </div>

                    <!-- Value Field -->
                    <div class="space-y-2">
                        <label for="value" class="flex items-center space-x-2 text-sm lg:text-base font-medium text-white">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Value</span>
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            id="value"
                            v-model="form.value"
                            type="text"
                            class="w-full px-4 py-3 lg:py-4 bg-white/5 border border-white/20 rounded-xl lg:rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="e.g., Kenneth John C. Ribay, kenneth@example.com"
                            required
                        />
                        <p class="text-xs lg:text-sm text-gray-400">Enter the actual value for this information</p>
                        <InputError :message="form.errors.value" />
                    </div>

                    <!-- Sort Order Field -->
                    <div class="space-y-2">
                        <label for="sort_order" class="flex items-center space-x-2 text-sm lg:text-base font-medium text-white">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                            </svg>
                            <span>Sort Order</span>
                        </label>
                        <input
                            id="sort_order"
                            v-model="form.sort_order"
                            type="number"
                            min="0"
                            class="w-full px-4 py-3 lg:py-4 bg-white/5 border border-white/20 rounded-xl lg:rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="0"
                        />
                        <p class="text-xs lg:text-sm text-gray-400">Lower numbers appear first in the list</p>
                        <InputError :message="form.errors.sort_order" />
                    </div>

                    <!-- Active Status -->
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2 text-sm lg:text-base font-medium text-white">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Status</span>
                        </label>
                        <div class="flex items-center space-x-3 p-4 bg-white/5 border border-white/10 rounded-xl">
                            <input
                                id="is_active"
                                v-model="form.is_active"
                                type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-transparent border-2 border-white/30 rounded focus:ring-blue-500 focus:ring-2"
                            />
                            <label for="is_active" class="text-sm lg:text-base text-white cursor-pointer">
                                Make this information active and visible
                            </label>
                        </div>
                        <p class="text-xs lg:text-sm text-gray-400">Only active information will be displayed on your portfolio</p>
                        <InputError :message="form.errors.is_active" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-white/10">
                        <Link :href="route('admin.personal-info.index')"
                              class="flex items-center justify-center space-x-2 px-6 py-3 lg:py-4 bg-white/5 hover:bg-white/10 border border-white/20 hover:border-white/30 rounded-xl transition-all duration-200 text-white font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Cancel</span>
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex-1 flex items-center justify-center space-x-2 px-6 py-3 lg:py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed rounded-xl transition-all duration-200 text-white font-medium hover:scale-105"
                        >
                            <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ form.processing ? 'Creating...' : 'Create Personal Information' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</template>

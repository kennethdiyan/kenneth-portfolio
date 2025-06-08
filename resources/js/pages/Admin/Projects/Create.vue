<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const currentStep = ref(1);
const totalSteps = 4;

const form = useForm({
    title: '',
    description: '',
    technologies: [] as string[],
    github_url: '',
    live_url: '',
    image_url: '',
    is_featured: false,
    is_active: true,
    sort_order: 0
});

const progressPercentage = computed(() => (currentStep.value / totalSteps) * 100);

const techInput = ref('');

const nextStep = () => {
    if (currentStep.value < totalSteps) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const addTechnology = () => {
    if (techInput.value.trim() && !form.technologies.includes(techInput.value.trim())) {
        form.technologies.push(techInput.value.trim());
        techInput.value = '';
    }
};

const removeTechnology = (index: number) => {
    form.technologies.splice(index, 1);
};

const submit = () => {
    form.post(route('admin.projects.store'));
};

const canProceed = computed(() => {
    switch (currentStep.value) {
        case 1: return form.title && form.description;
        case 2: return form.technologies.length > 0;
        case 3: return true; // URLs are optional
        case 4: return true;
        default: return false;
    }
});
</script>

<template>
    <Head title="Create Project - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <Link :href="route('admin.projects.index')"
                              class="text-slate-300 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </Link>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-white">Create New Project</h1>
                                <p class="text-sm text-slate-300">Add a project to showcase your work</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div v-for="step in totalSteps" :key="step"
                             :class="[
                                 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium transition-all duration-200',
                                 step <= currentStep ? 'bg-gradient-to-r from-orange-500 to-red-600 text-white' : 'bg-white/10 text-slate-400'
                             ]">
                            {{ step }}
                        </div>
                    </div>
                    <span class="text-slate-300 text-sm">Step {{ currentStep }} of {{ totalSteps }}</span>
                </div>
                <div class="w-full bg-white/10 rounded-full h-2">
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 h-2 rounded-full transition-all duration-300"
                         :style="{ width: progressPercentage + '%' }"></div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden">
                <form @submit.prevent="submit">
                    <!-- Step 1: Basic Information -->
                    <div v-show="currentStep === 1" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Project Details</h2>
                            <p class="text-slate-300">Let's start with the project name and description</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Project Title *
                                </label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    placeholder="e.g., E-commerce Platform, Portfolio Website"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                                    required
                                />
                                <p class="text-sm text-slate-400 mt-2">Give your project a descriptive name</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                    Description *
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="4"
                                    placeholder="Describe what this project does, its purpose, and key features..."
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md resize-none"
                                    required
                                ></textarea>
                                <p class="text-sm text-slate-400 mt-2">Explain the project's purpose and main features</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Technologies -->
                    <div v-show="currentStep === 2" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Technologies Used</h2>
                            <p class="text-slate-300">What technologies did you use in this project?</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Add Technologies
                                </label>
                                <div class="flex space-x-2">
                                    <input
                                        v-model="techInput"
                                        type="text"
                                        placeholder="e.g., React, Laravel, MySQL"
                                        class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                                        @keyup.enter="addTechnology"
                                    />
                                    <button
                                        type="button"
                                        @click="addTechnology"
                                        class="px-6 py-3 bg-orange-500/20 hover:bg-orange-500/30 text-orange-300 rounded-xl transition-all duration-200"
                                    >
                                        Add
                                    </button>
                                </div>
                                <p class="text-sm text-slate-400 mt-2">Press Enter or click Add to include a technology</p>
                            </div>

                            <div v-if="form.technologies.length > 0">
                                <label class="block text-sm font-medium text-slate-300 mb-3">
                                    Technologies ({{ form.technologies.length }})
                                </label>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="(tech, index) in form.technologies"
                                        :key="index"
                                        class="inline-flex items-center px-3 py-2 rounded-xl text-sm font-medium bg-orange-500/20 text-orange-300 border border-orange-400/20"
                                    >
                                        {{ tech }}
                                        <button
                                            type="button"
                                            @click="removeTechnology(index)"
                                            class="ml-2 text-orange-400 hover:text-orange-200 transition-colors duration-200"
                                        >
                                            ×
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Links -->
                    <div v-show="currentStep === 3" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Project Links</h2>
                            <p class="text-slate-300">Add links to view or access your project</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    GitHub URL
                                </label>
                                <input
                                    v-model="form.github_url"
                                    type="url"
                                    placeholder="https://github.com/username/repository"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                                />
                                <p class="text-sm text-slate-400 mt-2">Link to the source code repository</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Live Demo URL
                                </label>
                                <input
                                    v-model="form.live_url"
                                    type="url"
                                    placeholder="https://yourproject.com"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                                />
                                <p class="text-sm text-slate-400 mt-2">Link to the live/demo version of your project</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Project Image URL
                                </label>
                                <input
                                    v-model="form.image_url"
                                    type="url"
                                    placeholder="https://example.com/project-image.jpg"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                                />
                                <p class="text-sm text-slate-400 mt-2">Screenshot or preview image of your project</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Settings -->
                    <div v-show="currentStep === 4" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Project Settings</h2>
                            <p class="text-slate-300">Configure visibility and display options</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Sort Order
                                </label>
                                <input
                                    v-model.number="form.sort_order"
                                    type="number"
                                    min="0"
                                    placeholder="0"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent backdrop-blur-md"
                                />
                                <p class="text-sm text-slate-400 mt-2">Lower numbers appear first in the portfolio</p>
                            </div>

                            <div class="space-y-4">
                                <label class="flex items-center space-x-3 cursor-pointer p-4 rounded-xl border border-white/20 hover:bg-white/5 transition-colors duration-200">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_featured"
                                        class="w-5 h-5 rounded border-white/20 bg-white/10 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-0"
                                    />
                                    <div>
                                        <span class="text-white font-medium">Featured Project</span>
                                        <p class="text-sm text-slate-400">Highlight this project prominently in your portfolio</p>
                                    </div>
                                </label>

                                <label class="flex items-center space-x-3 cursor-pointer p-4 rounded-xl border border-white/20 hover:bg-white/5 transition-colors duration-200">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_active"
                                        class="w-5 h-5 rounded border-white/20 bg-white/10 text-orange-500 focus:ring-orange-500 focus:ring-offset-0"
                                    />
                                    <div>
                                        <span class="text-white font-medium">Active Project</span>
                                        <p class="text-sm text-slate-400">Show this project on your portfolio</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="px-8 py-6 bg-white/5 border-t border-white/10">
                        <div class="flex justify-between items-center">
                            <button
                                v-if="currentStep > 1"
                                type="button"
                                @click="prevStep"
                                class="flex items-center space-x-2 px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all duration-200"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span>Previous</span>
                            </button>
                            <div v-else></div>

                            <div class="flex space-x-3">
                                <Link :href="route('admin.projects.index')"
                                      class="px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all duration-200">
                                    Cancel
                                </Link>

                                <button
                                    v-if="currentStep < totalSteps"
                                    type="button"
                                    @click="nextStep"
                                    :disabled="!canProceed"
                                    :class="[
                                        'flex items-center space-x-2 px-6 py-2.5 rounded-xl transition-all duration-200',
                                        canProceed
                                            ? 'bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white transform hover:scale-105'
                                            : 'bg-slate-600 text-slate-400 cursor-not-allowed'
                                    ]"
                                >
                                    <span>Next</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>

                                <button
                                    v-else
                                    type="submit"
                                    :disabled="form.processing"
                                    :class="[
                                        'flex items-center space-x-2 px-6 py-2.5 rounded-xl transition-all duration-200',
                                        !form.processing
                                            ? 'bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white transform hover:scale-105'
                                            : 'bg-slate-600 text-slate-400 cursor-not-allowed'
                                    ]"
                                >
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>{{ form.processing ? 'Creating...' : 'Create Project' }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

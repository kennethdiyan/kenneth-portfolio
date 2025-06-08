<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const currentStep = ref(1);
const totalSteps = 3;

const form = useForm({
    name: '',
    category: '',
    proficiency: '',
    description: '',
    is_active: true
});

const progressPercentage = computed(() => (currentStep.value / totalSteps) * 100);

const proficiencyLevels = [
    { value: 'beginner', label: 'Beginner', description: 'Just getting started' },
    { value: 'intermediate', label: 'Intermediate', description: 'Comfortable with basics' },
    { value: 'advanced', label: 'Advanced', description: 'Highly proficient' },
    { value: 'expert', label: 'Expert', description: 'Deep expertise' }
];

const skillCategories = [
    'Frontend Development',
    'Backend Development',
    'Database',
    'DevOps',
    'Mobile Development',
    'Data Science',
    'Design',
    'Project Management',
    'Other'
];

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

const submit = () => {
    form.post(route('admin.skills.store'));
};

const canProceed = computed(() => {
    switch (currentStep.value) {
        case 1: return form.name && form.category;
        case 2: return form.proficiency;
        case 3: return true;
        default: return false;
    }
});
</script>

<template>
    <Head title="Create Skill - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <Link :href="route('admin.skills.index')"
                              class="text-slate-300 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </Link>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-white">Create New Skill</h1>
                                <p class="text-sm text-slate-300">Add a new skill to your portfolio</p>
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
                                 step <= currentStep ? 'bg-gradient-to-r from-green-500 to-teal-600 text-white' : 'bg-white/10 text-slate-400'
                             ]">
                            {{ step }}
                        </div>
                    </div>
                    <span class="text-slate-300 text-sm">Step {{ currentStep }} of {{ totalSteps }}</span>
                </div>
                <div class="w-full bg-white/10 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-teal-600 h-2 rounded-full transition-all duration-300"
                         :style="{ width: progressPercentage + '%' }"></div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden">
                <form @submit.prevent="submit">
                    <!-- Step 1: Basic Information -->
                    <div v-show="currentStep === 1" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Basic Information</h2>
                            <p class="text-slate-300">Let's start with the skill name and category</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                    Skill Name *
                                </label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    placeholder="e.g., React.js, Python, Adobe Photoshop"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-md"
                                    required
                                />
                                <p class="text-sm text-slate-400 mt-2">Enter the name of the skill or technology</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Category *
                                </label>
                                <select
                                    v-model="form.category"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-md"
                                    required
                                >
                                    <option value="" class="text-slate-900">Select a category</option>
                                    <option v-for="category in skillCategories" :key="category" :value="category" class="text-slate-900">
                                        {{ category }}
                                    </option>
                                </select>
                                <p class="text-sm text-slate-400 mt-2">Choose the most appropriate category</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Proficiency Level -->
                    <div v-show="currentStep === 2" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Proficiency Level</h2>
                            <p class="text-slate-300">How would you rate your skill level?</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div v-for="level in proficiencyLevels" :key="level.value"
                                 :class="[
                                     'p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:scale-105',
                                     form.proficiency === level.value
                                         ? 'border-green-500 bg-green-500/20'
                                         : 'border-white/20 bg-white/5 hover:border-white/30'
                                 ]"
                                 @click="form.proficiency = level.value">
                                <div class="flex items-center space-x-3">
                                    <div :class="[
                                        'w-4 h-4 rounded-full border-2 transition-all duration-200',
                                        form.proficiency === level.value
                                            ? 'bg-green-500 border-green-500'
                                            : 'border-white/40'
                                    ]"></div>
                                    <div>
                                        <h3 class="text-lg font-medium text-white">{{ level.label }}</h3>
                                        <p class="text-sm text-slate-400">{{ level.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Additional Details -->
                    <div v-show="currentStep === 3" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Additional Details</h2>
                            <p class="text-slate-300">Add description and set visibility</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                    Description
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="4"
                                    placeholder="Describe your experience with this skill, projects you've used it in, or any relevant details..."
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-md resize-none"
                                ></textarea>
                                <p class="text-sm text-slate-400 mt-2">Optional: Add context about your experience</p>
                            </div>

                            <div>
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_active"
                                        class="w-5 h-5 rounded border-white/20 bg-white/10 text-green-500 focus:ring-green-500 focus:ring-offset-0"
                                    />
                                    <div>
                                        <span class="text-white font-medium">Active Skill</span>
                                        <p class="text-sm text-slate-400">Show this skill on your portfolio</p>
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
                                <Link :href="route('admin.skills.index')"
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
                                            ? 'bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white transform hover:scale-105'
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
                                            ? 'bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white transform hover:scale-105'
                                            : 'bg-slate-600 text-slate-400 cursor-not-allowed'
                                    ]"
                                >
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>{{ form.processing ? 'Creating...' : 'Create Skill' }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

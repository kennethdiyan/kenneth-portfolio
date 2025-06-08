<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const currentStep = ref(1);
const totalSteps = 4;

const form = useForm({
    title: '',
    company: '',
    location: '',
    start_date: '',
    end_date: '',
    description: '',
    responsibilities: [] as string[],
    technologies: [] as string[],
    is_current: false,
    is_active: true
});

const progressPercentage = computed(() => (currentStep.value / totalSteps) * 100);

const responsibilityInput = ref('');
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

const addResponsibility = () => {
    if (responsibilityInput.value.trim() && !form.responsibilities.includes(responsibilityInput.value.trim())) {
        form.responsibilities.push(responsibilityInput.value.trim());
        responsibilityInput.value = '';
    }
};

const removeResponsibility = (index: number) => {
    form.responsibilities.splice(index, 1);
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
    form.post(route('admin.experiences.store'));
};

const canProceed = computed(() => {
    switch (currentStep.value) {
        case 1: return form.title && form.company && form.location;
        case 2: return form.start_date && (form.is_current || form.end_date);
        case 3: return form.description;
        case 4: return true;
        default: return false;
    }
});
</script>

<template>
    <Head title="Add Experience - Admin" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header -->
        <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <Link :href="route('admin.experiences.index')"
                              class="text-slate-300 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </Link>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-white">Add Work Experience</h1>
                                <p class="text-sm text-slate-300">Document your professional journey</p>
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
                                 step <= currentStep ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white' : 'bg-white/10 text-slate-400'
                             ]">
                            {{ step }}
                        </div>
                    </div>
                    <span class="text-slate-300 text-sm">Step {{ currentStep }} of {{ totalSteps }}</span>
                </div>
                <div class="w-full bg-white/10 rounded-full h-2">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2 rounded-full transition-all duration-300"
                         :style="{ width: progressPercentage + '%' }"></div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden">
                <form @submit.prevent="submit">
                    <!-- Step 1: Basic Information -->
                    <div v-show="currentStep === 1" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Position Details</h2>
                            <p class="text-slate-300">Tell us about your role and workplace</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                    </svg>
                                    Job Title *
                                </label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    placeholder="e.g., Senior Full Stack Developer"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-md"
                                    required
                                />
                                <p class="text-sm text-slate-400 mt-2">Your official job title or position</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Company *
                                    </label>
                                    <input
                                        v-model="form.company"
                                        type="text"
                                        placeholder="e.g., TechCorp Inc."
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-md"
                                        required
                                    />
                                    <p class="text-sm text-slate-400 mt-2">Company or organization name</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Location *
                                    </label>
                                    <input
                                        v-model="form.location"
                                        type="text"
                                        placeholder="e.g., San Francisco, CA"
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-md"
                                        required
                                    />
                                    <p class="text-sm text-slate-400 mt-2">City, state/province, country</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Employment Period -->
                    <div v-show="currentStep === 2" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Employment Period</h2>
                            <p class="text-slate-300">When did you work in this position?</p>
                        </div>

                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Start Date *
                                    </label>
                                    <input
                                        v-model="form.start_date"
                                        type="date"
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-md"
                                        required
                                    />
                                    <p class="text-sm text-slate-400 mt-2">When you started this position</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        End Date
                                    </label>
                                    <input
                                        v-model="form.end_date"
                                        type="date"
                                        :disabled="form.is_current"
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-md disabled:opacity-50"
                                        :required="!form.is_current"
                                    />
                                    <p class="text-sm text-slate-400 mt-2">When you left or will leave this position</p>
                                </div>
                            </div>

                            <div>
                                <label class="flex items-center space-x-3 cursor-pointer p-4 rounded-xl border border-white/20 hover:bg-white/5 transition-colors duration-200">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_current"
                                        class="w-5 h-5 rounded border-white/20 bg-white/10 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-0"
                                    />
                                    <div>
                                        <span class="text-white font-medium">Current Position</span>
                                        <p class="text-sm text-slate-400">I currently work in this position</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Description -->
                    <div v-show="currentStep === 3" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Job Description</h2>
                            <p class="text-slate-300">Describe your role and what you accomplished</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Description *
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="6"
                                    placeholder="Describe your role, key achievements, and impact in this position..."
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-md resize-none"
                                    required
                                ></textarea>
                                <p class="text-sm text-slate-400 mt-2">A comprehensive overview of your role and accomplishments</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Additional Details -->
                    <div v-show="currentStep === 4" class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Responsibilities & Technologies</h2>
                            <p class="text-slate-300">Add specific responsibilities and technologies used</p>
                        </div>

                        <div class="space-y-6">
                            <!-- Responsibilities -->
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Key Responsibilities
                                </label>
                                <div class="flex space-x-2 mb-3">
                                    <input
                                        v-model="responsibilityInput"
                                        type="text"
                                        placeholder="e.g., Led a team of 5 developers"
                                        class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-md"
                                        @keyup.enter="addResponsibility"
                                    />
                                    <button
                                        type="button"
                                        @click="addResponsibility"
                                        class="px-6 py-3 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 rounded-xl transition-all duration-200"
                                    >
                                        Add
                                    </button>
                                </div>
                                <div v-if="form.responsibilities.length > 0" class="space-y-2">
                                    <div
                                        v-for="(responsibility, index) in form.responsibilities"
                                        :key="index"
                                        class="flex items-center justify-between p-3 bg-white/5 rounded-lg border border-white/10"
                                    >
                                        <span class="text-white text-sm">{{ responsibility }}</span>
                                        <button
                                            type="button"
                                            @click="removeResponsibility(index)"
                                            class="text-red-400 hover:text-red-300 transition-colors duration-200"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1V4a1 1 0 00-1-1H6a1 1 0 000 2h1m0 0h10m0 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1V6h10z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Technologies -->
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Technologies Used
                                </label>
                                <div class="flex space-x-2 mb-3">
                                    <input
                                        v-model="techInput"
                                        type="text"
                                        placeholder="e.g., Laravel, Vue.js, MySQL"
                                        class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-md"
                                        @keyup.enter="addTechnology"
                                    />
                                    <button
                                        type="button"
                                        @click="addTechnology"
                                        class="px-6 py-3 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 rounded-xl transition-all duration-200"
                                    >
                                        Add
                                    </button>
                                </div>
                                <div v-if="form.technologies.length > 0" class="flex flex-wrap gap-2">
                                    <span
                                        v-for="(tech, index) in form.technologies"
                                        :key="index"
                                        class="inline-flex items-center px-3 py-2 rounded-xl text-sm font-medium bg-emerald-500/20 text-emerald-300 border border-emerald-400/20"
                                    >
                                        {{ tech }}
                                        <button
                                            type="button"
                                            @click="removeTechnology(index)"
                                            class="ml-2 text-emerald-400 hover:text-emerald-200 transition-colors duration-200"
                                        >
                                            ×
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <!-- Settings -->
                            <div>
                                <label class="flex items-center space-x-3 cursor-pointer p-4 rounded-xl border border-white/20 hover:bg-white/5 transition-colors duration-200">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_active"
                                        class="w-5 h-5 rounded border-white/20 bg-white/10 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-0"
                                    />
                                    <div>
                                        <span class="text-white font-medium">Active Experience</span>
                                        <p class="text-sm text-slate-400">Show this experience on your portfolio</p>
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
                                <Link :href="route('admin.experiences.index')"
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
                                            ? 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white transform hover:scale-105'
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
                                            ? 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white transform hover:scale-105'
                                            : 'bg-slate-600 text-slate-400 cursor-not-allowed'
                                    ]"
                                >
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>{{ form.processing ? 'Creating...' : 'Add Experience' }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

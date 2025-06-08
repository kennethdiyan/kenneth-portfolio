<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Skill {
    id: number;
    name: string;
    category: string;
    proficiency: string;
    description: string;
    is_active: boolean;
}

const props = defineProps<{
    skill: Skill;
}>();

const form = useForm({
    name: props.skill.name,
    category: props.skill.category,
    proficiency: props.skill.proficiency,
    description: props.skill.description || '',
    is_active: props.skill.is_active
});

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

const submit = () => {
    form.put(route('admin.skills.update', props.skill.id));
};
</script>

<template>
    <Head title="Edit Skill - Admin" />

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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-white">Edit Skill</h1>
                                <p class="text-sm text-slate-300">Update {{ skill.name }}</p>
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
                        <h2 class="text-2xl font-bold text-white mb-2">Update Skill Details</h2>
                        <p class="text-slate-300">Modify the skill information below</p>
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
                                        Skill Name *
                                    </label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        placeholder="e.g., React.js, Python, Adobe Photoshop"
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-md"
                                        required
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
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
                                </div>
                            </div>
                        </div>

                        <!-- Proficiency Level -->
                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Proficiency Level
                            </h3>
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
                                            <h4 class="text-lg font-medium text-white">{{ level.label }}</h4>
                                            <p class="text-sm text-slate-400">{{ level.description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                Additional Details
                            </h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        Description
                                    </label>
                                    <textarea
                                        v-model="form.description"
                                        rows="4"
                                        placeholder="Describe your experience with this skill, projects you've used it in, or any relevant details..."
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-md resize-none"
                                    ></textarea>
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

                        <!-- Submit Buttons -->
                        <div class="flex justify-between items-center pt-6">
                            <Link :href="route('admin.skills.index')"
                                  class="px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all duration-200">
                                Cancel
                            </Link>
                            <button
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
                                <span>{{ form.processing ? 'Updating...' : 'Update Skill' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

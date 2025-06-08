<script setup lang="ts">
import { useScrollAnimation } from '@/composables/useScrollAnimation';
import { computed } from 'vue';

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
    achievements: string[] | string;
    is_current: boolean;
    is_active: boolean;
}

const props = defineProps<{
    educations: Education[];
}>();

// Helper function to safely parse achievements
const parseAchievements = (achievements: string[] | string): string[] => {
    if (Array.isArray(achievements)) {
        return achievements;
    }

    if (typeof achievements === 'string') {
        try {
            const parsed = JSON.parse(achievements);
            return Array.isArray(parsed) ? parsed : [];
        } catch {
            return achievements.split(',').map(item => item.trim()).filter(Boolean);
        }
    }

    return [];
};

// Filter and sort active education records with proper achievements parsing
const activeEducations = computed(() => {
    return props.educations
        .filter(edu => edu.is_active)
        .map(edu => ({
            ...edu,
            achievements: parseAchievements(edu.achievements)
        }))
        .sort((a, b) => new Date(b.start_date).getTime() - new Date(a.start_date).getTime());
});

// Format date range
const formatDateRange = (startDate: string, endDate: string | null, isCurrent: boolean) => {
    const start = new Date(startDate).toLocaleDateString('en-US', { year: 'numeric' });
    if (isCurrent) {
        return `${start} - Present`;
    }
    if (endDate) {
        const end = new Date(endDate).toLocaleDateString('en-US', { year: 'numeric' });
        return `${start} - ${end}`;
    }
    return start;
};

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.education-header',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.education-item',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6 },
        staggerDelay: 0.2
    }
]);
</script>

<template>
    <section id="education" class="py-12 sm:py-16 lg:py-20 bg-slate-950 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="education-header text-center mb-8 sm:mb-12 lg:mb-16 opacity-0 transform translate-y-[30px]">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-3 sm:mb-4">Education</h2>
                <div class="w-16 sm:w-20 h-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded mx-auto"></div>
                <p class="text-gray-400 mt-4 sm:mt-6 max-w-2xl mx-auto text-sm sm:text-base">
                    My academic background and qualifications.
                </p>
            </div>

            <div v-if="activeEducations.length === 0" class="text-center py-12">
                <p class="text-gray-400 text-lg">No education records available.</p>
            </div>

            <div v-else class="space-y-6 sm:space-y-8">
                <div
                    v-for="education in activeEducations"
                    :key="education.id"
                    class="education-item group bg-slate-900/50 backdrop-blur border border-slate-800 rounded-xl sm:rounded-2xl lg:rounded-3xl p-6 sm:p-8 lg:p-10 hover:border-cyan-500/50 hover:bg-slate-900/70 transition-all duration-300 opacity-0 transform translate-y-[30px]"
                >
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 sm:gap-6 lg:gap-8">
                        <div class="lg:flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 sm:mb-4">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mb-2 sm:mb-0">
                                    <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-white group-hover:text-cyan-400 transition-colors duration-300">
                                        {{ education.degree }}
                                    </h3>
                                    <span v-if="education.field_of_study" class="text-cyan-400 text-sm sm:text-base font-medium">
                                        in {{ education.field_of_study }}
                                    </span>
                                </div>
                                <span :class="[
                                    'px-3 py-1 rounded-full text-xs sm:text-sm font-medium self-start sm:self-center',
                                    education.is_current
                                        ? 'bg-green-500/20 text-green-400 border border-green-500/30'
                                        : 'bg-blue-500/20 text-blue-400 border border-blue-500/30'
                                ]">
                                    {{ education.is_current ? 'Current' : 'Completed' }}
                                </span>
                            </div>

                            <div class="mb-3 sm:mb-4">
                                <p class="text-gray-300 font-semibold text-base sm:text-lg">{{ education.institution }}</p>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-gray-400 text-xs sm:text-sm">
                                    <span v-if="education.location">{{ education.location }}</span>
                                    <span>{{ formatDateRange(education.start_date, education.end_date, education.is_current) }}</span>
                                </div>
                            </div>

                            <div v-if="education.gpa" class="mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-400 text-sm">GPA:</span>
                                    <span class="text-cyan-400 font-semibold">{{ education.gpa }}</span>
                                </div>
                            </div>

                            <p v-if="education.description" class="text-gray-300 text-sm sm:text-base leading-relaxed mb-4 sm:mb-6">
                                {{ education.description }}
                            </p>

                            <div v-if="education.achievements.length > 0">
                                <h4 class="text-base sm:text-lg font-semibold text-white mb-3">Achievements & Honors:</h4>
                                <ul class="space-y-2">
                                    <li v-for="achievement in education.achievements" :key="achievement"
                                        class="flex items-start text-gray-300 text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-cyan-400 mr-2 sm:mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ achievement }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="lg:w-auto flex-shrink-0">
                            <div class="hidden lg:block w-20 h-20 xl:w-24 xl:h-24 bg-gradient-to-br from-cyan-500/20 to-blue-600/20 rounded-2xl flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-8 h-8 xl:w-10 xl:h-10 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

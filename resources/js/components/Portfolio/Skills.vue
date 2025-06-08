<script setup lang="ts">
import { ref, computed } from 'vue';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

interface Skill {
    id: number;
    name: string;
    category: string;
    proficiency: string | null;
    description: string;
    is_active: boolean;
}

const props = defineProps<{
    skills: Skill[];
}>();

const selectedCategory = ref('all');

// Get unique categories from the database skills
const categories = computed(() => {
    const uniqueCategories = ['all'];
    const skillCategories = [...new Set(props.skills.map(skill => skill.category.toLowerCase()))];
    return uniqueCategories.concat(skillCategories);
});

// Convert proficiency levels to numbers for progress bars
const getProficiencyLevel = (proficiency: string | null | undefined): number => {
    if (!proficiency || typeof proficiency !== 'string') {
        return 50; // Default to intermediate level
    }
    const levels: Record<string, number> = {
        'beginner': 25,
        'intermediate': 50,
        'advanced': 75,
        'expert': 90
    };
    return levels[proficiency.toLowerCase()] || 50;
};

// Get color for each skill based on category
const getSkillColor = (category: string): string => {
    const colors: Record<string, string> = {
        'frontend': '#4FC08D',
        'backend': '#FF2D20',
        'database': '#4479A1',
        'devops': '#F05032',
        'mobile': '#61DAFB',
        'other': '#9333EA'
    };
    return colors[category.toLowerCase()] || '#06B6D4';
};

// Transform database skills to match component format
const transformedSkills = computed(() => {
    return props.skills.map(skill => ({
        name: skill.name,
        category: skill.category.toLowerCase(),
        level: getProficiencyLevel(skill.proficiency),
        color: getSkillColor(skill.category),
        description: skill.description || `Professional experience with ${skill.name} at ${skill.proficiency} level.`
    }));
});

const filteredSkills = computed(() => {
    if (selectedCategory.value === 'all') {
        return transformedSkills.value;
    }
    return transformedSkills.value.filter(skill => skill.category === selectedCategory.value);
});

const getSkillIcon = (skillName: string) => {
    const icons: Record<string, string> = {
        'Laravel': `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.642 5.43a.364.364 0 01.014.1v5.149c0 .135-.073.26-.189.326l-4.323 2.49v4.934a.378.378 0 01-.188.326L9.93 23.949a.316.316 0 01-.066.027c-.008.002-.016.008-.024.01a.348.348 0 01-.192 0c-.011-.002-.02-.008-.03-.012-.02-.008-.042-.014-.062-.025L.533 18.755a.376.376 0 01-.189-.326V2.974c0-.033.005-.066.014-.098.003-.012.01-.02.014-.032a.369.369 0 01.023-.058c.004-.013.015-.022.023-.033l.033-.045c.012-.01.025-.018.037-.027.014-.012.027-.024.041-.034H.53L5.043.05a.375.375 0 01.375 0L9.93 2.647h.002c.015.01.027.021.04.033.012.009.026.018.037.027.014.013.024.030.033.045.008.011.02.021.025.033.01.02.017.040.024.058.003.011.010.021.013.032.01.031.014.064.014.098v9.652l3.76-2.164V5.527c0-.033.004-.066.013-.098.003-.01.01-.02.013-.032a.487.487 0 01.024-.059c.007-.012.018-.02.025-.033.01-.016.022-.03.033-.043.012-.012.025-.02.037-.028.013-.012.027-.023.041-.032h.001l4.513-2.598a.375.375 0 01.375 0l4.513 2.598c.016.01.029.021.042.031.012.01.025.018.036.028.01.014.022.027.032.043.008.012.019.021.024.033.011.02.018.04.024.06.006.01.012.021.015.032zm-.74 5.032V6.179l-1.578.908-2.182 1.256v4.283zm-4.51 7.75v-4.287l-2.146 1.225-6.265 3.57v4.325zM1.093 3.624v14.588l8.273 4.761v-4.325l-4.322-2.445-.002-.003-.002-.002c-.014-.010-.025-.021-.04-.031-.011-.01-.024-.018-.035-.027l-.001-.002c-.013-.012-.021-.025-.031-.04-.01-.011-.021-.02-.028-.032l-.002-.003c-.008-.014-.013-.031-.02-.047-.006-.016-.014-.027-.018-.043v-.001c-.004-.018-.006-.037-.008-.057-.002-.014-.006-.027-.006-.041V5.789l-2.18-1.257zM5.23.81L1.47 2.974l3.76 2.164 3.758-2.164zm1.956 13.505l2.182-1.256V3.624l-1.58.91-2.182 1.255v9.435zm11.581-10.95l-3.76 2.163 3.76 2.163 3.759-2.164zm-.376 4.978L16.21 7.087 14.63 6.18v4.283l2.182 1.256 1.58.908zm-8.65 9.654l5.514-3.148 2.756-1.572-3.757-2.163-4.323 2.489-3.941 2.27z"/></svg>`,
        'Vue.js': `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24,1.61H14.06L12,5.16,9.94,1.61H0L12,22.39ZM12,14.08,5.16,2.23H9.59L12,6.41l2.41-4.18h4.43Z"/></svg>`,
        'Tailwind CSS': `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.001,4.8c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 C13.666,10.618,15.027,12,18.001,12c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C16.337,6.182,14.976,4.8,12.001,4.8z M6.001,12c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 c1.177,1.194,2.538,2.576,5.512,2.576c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C10.337,13.382,8.976,12,6.001,12z"/></svg>`,
        'MySQL': `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M16.405 5.501c-.115 0-.193.014-.274.033v.013h.014c.054.104.146.18.214.273.054.107.1.214.154.32l.014-.015c.094-.066.14-.172.14-.333-.04-.047-.046-.094-.08-.14-.04-.067-.126-.1-.18-.153zM5.77 18.695h-.927a50.854 50.854 0 00-.27-4.41h-.008l-1.41 4.41H2.45l-1.4-4.41h-.01a72.892 72.892 0 00-.195 4.41H.1c.055-1.966.192-3.81.41-5.53h1.15l1.335 4.064h.008l1.347-4.064h1.095c.242 2.015.384 3.86.428 5.53zm4.017-4.08c-.378 2.045-.876 3.533-1.492 4.46-.482.716-1.01 1.073-1.583 1.073-.153 0-.34-.046-.566-.138v-.494c.11.017.24.026.386.026.268 0 .483-.075.647-.222.197-.18.295-.382.295-.605 0-.155-.077-.47-.23-.944L6.23 14.615h.91l.727 2.36c.164.536.233.91.205 1.123.4-1.064.678-2.227.835-3.483h.88zm12.325 4.08h-2.63v-5.53h.885v4.85h1.745v.68zm-3.32.135l-1.016-.5c.09-.076.177-.158.255-.25.433-.506.648-1.258.648-2.253 0-1.83-.718-2.746-2.155-2.746-.704 0-1.254.232-1.65.697-.43.508-.646 1.256-.646 2.245 0 .972.19 1.686.574 2.14.35.41.877.615 1.583.615.264 0 .506-.033.725-.098l1.325.772.357-.622zM15.5 17.588c-.225 0-.406-.104-.544-.31-.159-.24-.238-.78-.238-1.617 0-.843.074-1.51.222-2.002.129-.43.308-.647.537-.647.416 0 .624.718.624 2.152 0 1.976-.222 2.424-.6 2.424z"/></svg>`,
        'JavaScript': `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M0 0h24v24H0V0zm22.034 18.276c-.175-1.095-.888-2.015-3.003-2.873-.736-.345-1.554-.585-1.797-1.14-.091-.33-.105-.51-.046-.705.15-.646.915-.84 1.515-.66.39.12.75.42.976.9 1.034-.676 1.034-.676 1.755-1.125-.27-.42-.404-.601-.586-.78-.63-.705-1.469-1.065-2.834-1.034l-.705.089c-.676.165-1.32.525-1.71 1.005-1.14 1.291-.811 3.541.569 4.471 1.365 1.02 3.361 1.244 3.616 2.205.24 1.17-.87 1.545-1.966 1.41-.811-.18-1.26-.586-1.755-1.336l-1.83 1.051c.21.48.45.689.81 1.109 1.74 1.756 6.09 1.666 6.871-1.004.029-.09.24-.705.074-1.65l.046.067zm-8.983-7.245h-2.248c0 1.938-.009 3.864-.009 5.805 0 1.232.063 2.363-.138 2.711-.33.689-1.18.601-1.566.48-.396-.196-.597-.466-.83-.855-.063-.105-.11-.196-.127-.196l-1.825 1.125c.305.63.75 1.172 1.324 1.517.855.51 2.004.675 3.207.405.783-.226 1.458-.691 1.811-1.411.51-.93.402-2.07.397-3.346.012-2.054 0-4.109 0-6.179l.004-.056z"/></svg>`,
        'PHP': `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M7.01 10.207h-.944l-.515 2.648h.838c.556 0 .982-.122 1.296-.515.31-.394.465-.896.465-1.485 0-.279-.04-.498-.117-.632-.075-.134-.181-.24-.31-.31-.045-.024-.098-.04-.162-.049-.064-.01-.123-.014-.176-.014-.034-.001-.057-.001-.076-.001-.01.002-.022.002-.035.002-.013.001-.025.001-.038.002-.013 0-.025.002-.038.002h-.223zm5.502 0h-.944l-.515 2.648h.838c.556 0 .982-.122 1.296-.515.31-.394.465-.896.465-1.485 0-.279-.04-.498-.117-.632-.075-.134-.181-.24-.31-.31-.045-.024-.098-.04-.162-.049-.064-.01-.123-.014-.176-.014-.034-.001-.057-.001-.076-.001-.01.002-.022.002-.035.002-.013.001-.025.001-.038.002-.013 0-.025.002-.038.002h-.223z"/><path d="M11.468 6.283c-1.686 0-3.229.579-4.149 1.537C6.64 8.837 6.351 9.957 6.641 11.11c.232 1.153.854 2.08 1.807 2.747 1.063.744 2.522 1.128 4.061 1.022 1.538-.107 2.962-.69 3.882-1.648.879-1.038 1.168-2.158.878-3.31-.232-1.154-.854-2.08-1.807-2.748C14.399 6.429 12.94 6.044 11.468 6.283z"/><path d="M24 12c0 6.627-5.373 12-12 12S0 18.627 0 12 5.373 0 12 0s12 5.373 12 12zM5.394 10.516c.232-.807.835-1.462 1.665-1.847 1.201-.557 2.747-.568 4.002-.09.838.319 1.554.871 2.068 1.618.514.747.766 1.648.766 2.62 0 .972-.252 1.873-.766 2.62-.514.747-1.23 1.299-2.068 1.618-1.255.478-2.801.467-4.002-.09-.83-.385-1.433-1.04-1.665-1.847-.265-.922-.132-1.938.518-2.845.65-.906 1.645-1.561 2.784-1.811.606-.133 1.24-.133 1.846 0 .606.133 1.164.392 1.618.756.454.364.797.833 1.01 1.369.213.536.282 1.124.204 1.694-.078.57-.295 1.112-.633 1.559-.338.447-.79.794-1.318 1.005-.528.211-1.112.269-1.688.169-.576-.1-1.125-.359-1.588-.751-.463-.392-.826-.909-1.052-1.319-.226-.55-.305-1.155-.229-1.74.076-.585.295-1.139.633-1.594.338-.455.79-.808 1.318-1.039.528-.231 1.112-.319 1.688-.259.576.06 1.125.259 1.588.591.463.332.826.779 1.052 1.309.226.53.305 1.115.229 1.68-.076.565-.295 1.099-.633 1.544-.338.445-.79.788-1.318 1.019-.528.231-1.112.309-1.688.239-.576-.07-1.125-.289-1.588-.631-.463-.342-.826-.799-1.052-1.329-.226-.53-.305-1.115-.229-1.68.076-.565.295-1.099.633-1.544.338-.445.79-.788 1.318-1.019.528-.231 1.112-.309 1.688-.239z"/></svg>`,
        'Git': `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.546 10.93L13.067.452c-.604-.603-1.582-.603-2.188 0L8.708 2.627l2.76 2.76c.645-.215 1.379-.07 1.889.441.516.515.658 1.258.438 1.9l2.658 2.66c.645-.223 1.387-.078 1.9.435.721.721.721 1.884 0 2.604-.719.719-1.881.719-2.6 0-.539-.541-.674-1.337-.404-1.996L12.86 8.955v6.525c.176.086.342.203.488.348.713.721.713 1.883 0 2.6-.719.721-1.889.721-2.609 0-.719-.719-.719-1.879 0-2.598.182-.18.387-.316.605-.406V8.835c-.217-.091-.424-.222-.6-.401-.545-.545-.676-1.342-.396-2.009L7.636 3.7.45 10.881c-.6.605-.6 1.584 0 2.189l10.48 10.477c.604.604 1.582.604 2.186 0L23.546 13.12c.603-.603.603-1.582 0-2.189"/></svg>`,
        'Inertia.js': `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.001 0C5.373 0 0 5.373 0 12.001s5.373 12.001 12.001 12.001 12.001-5.373 12.001-12.001S18.629 0 12.001 0zm-.001 4.62c1.842 0 3.344 1.501 3.344 3.343s-1.502 3.344-3.344 3.344-3.343-1.502-3.343-3.344 1.501-3.343 3.343-3.343zm0 6.685c1.842 0 3.344 1.502 3.344 3.344S13.843 18.001 12 18.001s-3.343-1.501-3.343-3.343S10.158 11.305 12 11.305z"/></svg>`
    };
    return icons[skillName] || `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>`;
};

// Setup scroll-triggered animations
useScrollAnimation([
    {
        selector: '.skills-header',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8 }
    },
    {
        selector: '.skills-filters',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6, delay: 0.2 }
    },
    {
        selector: '.skills-grid',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.8, delay: 0.4 }
    },
    {
        selector: '.skill-card',
        animation: { opacity: 1, y: 0 },
        options: { duration: 0.6 },
        staggerDelay: 0.1
    }
]);
</script>

<template>
    <section id="skills" class="py-12 sm:py-16 lg:py-20 bg-slate-900 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="skills-header text-center mb-12 sm:mb-16 lg:mb-20 opacity-0 transform translate-y-[30px]">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                    My <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Skills</span>
                </h2>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-400 max-w-3xl mx-auto">
                    Technologies I work with
                </p>
            </div>

            <!-- Category Filters -->
            <div class="skills-filters mb-8 sm:mb-12 lg:mb-16 opacity-0 transform translate-y-[20px]">
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3 md:gap-4 lg:gap-6">
                    <button
                        v-for="category in categories"
                        :key="category"
                        @click="selectedCategory = category"
                        :class="[
                            'px-4 sm:px-6 lg:px-8 py-2 sm:py-3 lg:py-4 rounded-full text-xs sm:text-sm md:text-base lg:text-lg font-medium transition-all duration-300 capitalize',
                            selectedCategory === category
                                ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg shadow-cyan-500/25'
                                : 'bg-slate-800/50 text-gray-400 hover:bg-slate-700/50 hover:text-white border border-slate-700 hover:border-slate-600'
                        ]"
                    >
                        {{ category }}
                </button>
                </div>
            </div>

            <!-- Skills Grid -->
            <div class="skills-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 md:gap-8 lg:gap-10 opacity-0 transform translate-y-[50px]">
                <div
                    v-for="(skill, index) in filteredSkills"
                     :key="skill.name"
                    class="skill-card group relative bg-slate-800/30 backdrop-blur border border-slate-700/50 rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6 md:p-8 lg:p-10 hover:bg-slate-800/50 hover:border-slate-600/50 transition-all duration-300 hover:transform hover:scale-105 opacity-0 transform translate-y-[30px]"
                >
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-blue-600/5 rounded-xl sm:rounded-2xl lg:rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative z-10">
                        <!-- Skill Header -->
                        <div class="flex items-center mb-4 sm:mb-6 lg:mb-8">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 rounded-lg sm:rounded-xl lg:rounded-2xl flex items-center justify-center mr-3 sm:mr-4 md:mr-6 group-hover:scale-110 transition-transform duration-300"
                                :style="{ backgroundColor: skill.color + '20', color: skill.color }"
                            >
                                <div class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10" v-html="getSkillIcon(skill.name)"></div>
                    </div>
                            <div>
                                <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white group-hover:text-cyan-400 transition-colors duration-300">
                                    {{ skill.name }}
                                </h3>
                                <p class="text-xs sm:text-sm md:text-base text-gray-400 capitalize">{{ skill.category }}</p>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-4 sm:mb-6">
                            <div class="flex justify-between items-center mb-2 sm:mb-3">
                                <span class="text-xs sm:text-sm md:text-base lg:text-lg text-gray-300">Proficiency</span>
                                <span class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-cyan-400">{{ skill.level }}%</span>
                                </div>
                            <div class="w-full bg-slate-700/50 rounded-full h-2 sm:h-3 md:h-4 overflow-hidden">
                                <div
                                    class="skill-progress h-full bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full transition-all duration-1000 ease-out"
                                    :style="{ width: '0%' }"
                                    :data-width="skill.level + '%'"
                                />
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-xs sm:text-sm md:text-base text-gray-400 leading-relaxed">
                            {{ skill.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.group:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Progressive skill bar animation */
.skill-card:hover .skill-progress {
    width: var(--skill-width) !important;
}
</style>

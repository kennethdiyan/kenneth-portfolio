<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';
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
const skillsContainer = ref<HTMLElement>();
const animatedSkills = ref<Set<number>>(new Set());

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
        id: skill.id,
        name: skill.name,
        category: skill.category.toLowerCase(),
        level: getProficiencyLevel(skill.proficiency),
        color: getSkillColor(skill.category),
        description: skill.description || `Professional experience with ${skill.name} at ${skill.proficiency} level.`,
        proficiency: skill.proficiency
    }));
});

const filteredSkills = computed(() => {
    if (selectedCategory.value === 'all') {
        return transformedSkills.value;
    }
    return transformedSkills.value.filter(skill => skill.category === selectedCategory.value);
});

// Animate skill progress bars when they come into view
const animateSkillBar = (skillId: number, level: number) => {
    if (animatedSkills.value.has(skillId)) return;

    const progressBar = document.querySelector(`[data-skill-id="${skillId}"] .skill-progress`);
    if (progressBar) {
        setTimeout(() => {
            (progressBar as HTMLElement).style.width = `${level}%`;
            animatedSkills.value.add(skillId);
        }, 100);
    }
};

// Watch for skill filter changes and reset animations
watch(selectedCategory, () => {
    animatedSkills.value.clear();
    setTimeout(() => {
        filteredSkills.value.forEach(skill => {
            animateSkillBar(skill.id, skill.level);
        });
    }, 300);
});

const getSkillIcon = (skillName: string) => {
    const icons: Record<string, string> = {
        'Laravel': `<svg viewBox="0 0 24 24" fill="#FF2D20"><path d="M23.642 5.43a.364.364 0 01.014.1v5.149c0 .135-.073.26-.189.326l-4.323 2.49v4.934a.378.378 0 01-.188.326L9.93 23.949a.316.316 0 01-.066.027c-.008.002-.016.008-.024.01a.348.348 0 01-.192 0c-.011-.002-.02-.008-.03-.012-.02-.008-.042-.014-.062-.025L.533 18.755a.376.376 0 01-.189-.326V2.974c0-.033.005-.066.014-.098.003-.012.01-.02.014-.032a.369.369 0 01.023-.058c.004-.013.015-.022.023-.033l.033-.045c.012-.01.025-.018.037-.027.014-.012.027-.024.041-.034H.53L5.043.05a.375.375 0 01.375 0L9.93 2.647h.002c.015.01.027.021.04.033.012.009.026.018.037.027.014.013.024.030.033.045.008.011.02.021.025.033.01.02.017.040.024.058.003.011.010.021.013.032.01.031.014.064.014.098v9.652l3.76-2.164V5.527c0-.033.004-.066.013-.098.003-.01.01-.02.013-.032a.487.487 0 01.024-.059c.007-.012.018-.02.025-.033.01-.016.022-.03.033-.043.012-.012.025-.02.037-.028.013-.012.027-.023.041-.032h.001l4.513-2.598a.375.375 0 01.375 0l4.513 2.598c.016.01.029.021.042.031.012.01.025.018.036.028.01.014.022.027.032.043.008.012.019.021.024.033.011.02.018.04.024.06.006.01.012.021.015.032zm-.74 5.032V6.179l-1.578.908-2.182 1.256v4.283zm-4.51 7.75v-4.287l-2.146 1.225-6.265 3.57v4.325zM1.093 3.624v14.588l8.273 4.761v-4.325l-4.322-2.445-.002-.003-.002-.002c-.014-.010-.025-.021-.04-.031-.011-.01-.024-.018-.035-.027l-.001-.002c-.013-.012-.021-.025-.031-.04-.01-.011-.021-.02-.028-.032l-.002-.003c-.008-.014-.013-.031-.02-.047-.006-.016-.014-.027-.018-.043v-.001c-.004-.018-.006-.037-.008-.057-.002-.014-.006-.027-.006-.041V5.789l-2.18-1.257zM5.23.81L1.47 2.974l3.76 2.164 3.758-2.164zm1.956 13.505l2.182-1.256V3.624l-1.58.91-2.182 1.255v9.435zm11.581-10.95l-3.76 2.163 3.76 2.163 3.759-2.164zm-.376 4.978L16.21 7.087 14.63 6.18v4.283l2.182 1.256 1.58.908zm-8.65 9.654l5.514-3.148 2.756-1.572-3.757-2.163-4.323 2.489-3.941 2.27z"/></svg>`,
        'Vue.js': `<svg viewBox="0 0 24 24" fill="#4FC08D"><path d="M24,1.61H14.06L12,5.16,9.94,1.61H0L12,22.39ZM12,14.08,5.16,2.23H9.59L12,6.41l2.41-4.18h4.43Z"/></svg>`,
        'Vue': `<svg viewBox="0 0 24 24" fill="#4FC08D"><path d="M24,1.61H14.06L12,5.16,9.94,1.61H0L12,22.39ZM12,14.08,5.16,2.23H9.59L12,6.41l2.41-4.18h4.43Z"/></svg>`,
        'JavaScript': `<svg viewBox="0 0 24 24" fill="#F7DF1E"><path d="M0 0h24v24H0V0zm22.034 18.276c-.175-1.095-.888-2.015-3.003-2.873-.736-.345-1.554-.585-1.797-1.14-.091-.33-.105-.51-.046-.705.15-.646.915-.84 1.515-.66.39.12.75.42.976.9 1.034-.676 1.034-.676 1.755-1.125-.27-.42-.404-.601-.586-.78-.63-.705-1.469-1.065-2.834-1.034l-.705.089c-.676.165-1.32.525-1.71 1.005-1.14 1.291-.811 3.541.569 4.471 1.365 1.02 3.361 1.244 3.616 2.205.24 1.17-.87 1.545-1.966 1.41-.811-.18-1.26-.586-1.755-1.336l-1.83 1.051c.21.48.45.689.81 1.109 1.74 1.756 6.09 1.666 6.871-1.004.029-.09.24-.705.074-1.65l.046.067zm-8.983-7.245h-2.248c0 1.938-.009 3.864-.009 5.805 0 1.232.063 2.363-.138 2.711-.33.689-1.18.601-1.566.48-.396-.196-.597-.466-.83-.855-.063-.105-.11-.196-.127-.196l-1.825 1.125c.305.63.75 1.172 1.324 1.517.855.51 2.004.675 3.207.405.783-.226 1.458-.691 1.811-1.411.51-.93.402-2.07.397-3.346.012-2.054 0-4.109 0-6.179l.004-.056z"/></svg>`,
        'PHP': `<svg viewBox="0 0 24 24" fill="#777BB4"><path d="M7.01 10.207h-.944l-.515 2.648h.838c.556 0 .982-.122 1.292-.391.312-.27.463-.705.463-1.336 0-.472-.12-.822-.353-1.058-.235-.235-.618-.353-1.176-.353zm11.53 0h-.944l-.515 2.648h.838c.556 0 .982-.122 1.292-.391.312-.27.463-.705.463-1.336 0-.472-.12-.822-.353-1.058-.235-.235-.618-.353-1.176-.353z"/><path d="M24 12c0 6.627-5.373 12-12 12S0 18.627 0 12 5.373 0 12 0s12 5.373 12 12zM5.394 11.987l.704-3.642h2.177c.8 0 1.393.135 1.807.408.413.272.62.727.62 1.347 0 .246-.029.467-.084.67l-.013.041-.013.04c-.558 2.043-1.726 2.043-1.726 2.043H6.668l-.295 1.508h-1.284l.305-1.508zm7.735 0l.704-3.642h2.177c.8 0 1.393.135 1.807.408.413.272.62.727.62 1.347 0 .246-.029.467-.084.67l-.013.041-.013.04c-.558 2.043-1.726 2.043-1.726 2.043h-1.198l-.295 1.508h-1.284l.305-1.508z"/></svg>`,
        'MySQL': `<svg viewBox="0 0 24 24" fill="#4479A1"><path d="M16.405 5.501c-.115 0-.193.014-.274.033v.013h.014c.054.104.146.18.214.274.054.107.1.214.154.32l.014-.015c.094-.066.14-.172.14-.333-.04-.047-.046-.094-.08-.14-.04-.067-.126-.1-.18-.153zm-5.77 18.695h-.927c-.03-4.455-.267-8.91-.267-13.365C9.441 7.716 10.618 4.88 12.925 2.459c1.005-.991 2.009-1.982 3.347-2.614 1.339-.631 2.953-.632 4.292 0 1.34.632 2.343 1.623 3.347 2.614 2.307 2.42 3.484 5.257 3.484 8.372 0 4.455-.236 8.91-.267 13.365h-.926c-.03-4.455-.267-8.91-.267-13.365 0-3.115-.774-5.951-2.615-8.372-.859-.991-1.718-1.982-2.882-2.614-1.163-.631-2.59-.631-3.754 0-1.164.632-2.023 1.623-2.882 2.614-1.841 2.42-2.615 5.257-2.615 8.372 0 4.455-.236 8.91-.267 13.365z"/></svg>`,
        'Git': `<svg viewBox="0 0 24 24" fill="#F05032"><path d="M23.546 10.93L13.067.452c-.604-.603-1.582-.603-2.188 0L8.708 2.627l2.76 2.76c.645-.215 1.379-.07 1.889.441.516.515.658 1.258.438 1.9l2.658 2.66c.645-.223 1.387-.078 1.9.435.721.721.721 1.884 0 2.604-.719.719-1.881.719-2.6 0-.539-.541-.674-1.337-.404-1.996L12.86 8.955v6.525c.176.086.342.203.488.348.713.721.713 1.883 0 2.6-.719.721-1.889.721-2.609 0-.719-.719-.719-1.879 0-2.598.182-.18.387-.316.605-.406V8.835c-.217-.091-.424-.222-.6-.401-.545-.545-.676-1.342-.396-2.009L7.636 3.7.45 10.881c-.6.605-.6 1.584 0 2.189l10.48 10.477c.604.604 1.582.604 2.186 0L23.546 13.12c.603-.603.603-1.582 0-2.189"/></svg>`,
        'GitHub': `<svg viewBox="0 0 24 24" fill="#181717"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.521 17.34c.282.42.423.96.423 1.5 0 0-5.58-4.44-10.02-10.02-10.02-5.58 0-3.3 2.22-5.5 5.52-5.5 3.3 0 5.52 2.22 10.02 5.52 10.02.54 0 1.08-.12 1.5-.42 4.44-1.2 1.2-1.8 1.8-4.2 1.8-6.6 0-5.58-4.44-10.02-10.02-10.02z"/></svg>`,
        'HTML': `<svg viewBox="0 0 24 24" fill="#E34F26"><path d="M1.125 0C.502 0 0 .502 0 1.125v21.75C0 23.498.502 24 1.125 24h21.75c.623 0 1.125-.502 1.125-1.125V1.125C24 .502 23.498 0 22.875 0zm17.363 9.75c.612 0 1.154.037 1.627.111a6.38 6.38 0 0 1 1.306.34v2.458a3.95 3.95 0 0 0-.643-.361 5.093 5.093 0 0 0-.717-.26 5.453 5.453 0 0 0-1.426-.2c-.3 0-.573.028-.819.086a2.1 2.1 0 0 0-.623.242c-.17.104-.3.229-.393.374a.888.888 0 0 0-.14.49c0 .196.053.373.156.529.104.156.252.304.443.444s.423.276.696.41c.273.135.582.274.926.416.47.197.892.407 1.266.628.374.222.695.473.963.753.268.279.472.598.614.957.142.359.213.776.213 1.253 0 .657-.125 1.21-.373 1.656a3.033 3.033 0 0 1-1.012 1.085 4.38 4.38 0 0 1-1.487.596c-.566.12-1.163.18-1.79.18a9.916 9.916 0 0 1-1.84-.164 5.544 5.544 0 0 1-1.512-.493v-2.63a5.033 5.033 0 0 0 3.237 1.2c.333 0 .624-.03.872-.09.249-.06.456-.144.623-.25.166-.108.29-.234.373-.38a1.023 1.023 0 0 0-.074-1.089 2.12 2.12 0 0 0-.537-.5 5.597 5.597 0 0 0-.807-.444 27.72 27.72 0 0 0-1.007-.436c-.918-.383-1.602-.852-2.053-1.405-.45-.553-.676-1.222-.676-2.005 0-.614.123-1.141.369-1.582.246-.441.58-.804 1.004-1.089a4.494 4.494 0 0 1 1.47-.629 7.536 7.536 0 0 1 1.77-.201zm-15.113.188h9.563v2.166H9.506v9.646H6.789v-9.646H3.375z"/></svg>`,
        'CSS': `<svg viewBox="0 0 24 24" fill="#1572B6"><path d="M1.125 0C.502 0 0 .502 0 1.125v21.75C0 23.498.502 24 1.125 24h21.75c.623 0 1.125-.502 1.125-1.125V1.125C24 .502 23.498 0 22.875 0zm17.363 9.75c.612 0 1.154.037 1.627.111a6.38 6.38 0 0 1 1.306.34v2.458a3.95 3.95 0 0 0-.643-.361 5.093 5.093 0 0 0-.717-.26 5.453 5.453 0 0 0-1.426-.2c-.3 0-.573.028-.819.086a2.1 2.1 0 0 0-.623.242c-.17.104-.3.229-.393.374a.888.888 0 0 0-.14.49c0 .196.053.373.156.529.104.156.252.304.443.444s.423.276.696.41c.273.135.582.274.926.416.47.197.892.407 1.266.628.374.222.695.473.963.753.268.279.472.598.614.957.142.359.213.776.213 1.253 0 .657-.125 1.21-.373 1.656a3.033 3.033 0 0 1-1.012 1.085 4.38 4.38 0 0 1-1.487.596c-.566.12-1.163.18-1.79.18a9.916 9.916 0 0 1-1.84-.164 5.544 5.544 0 0 1-1.512-.493v-2.63a5.033 5.033 0 0 0 3.237 1.2c.333 0 .624-.03.872-.09.249-.06.456-.144.623-.25.166-.108.29-.234.373-.38a1.023 1.023 0 0 0-.074-1.089 2.12 2.12 0 0 0-.537-.5 5.597 5.597 0 0 0-.807-.444 27.72 27.72 0 0 0-1.007-.436c-.918-.383-1.602-.852-2.053-1.405-.45-.553-.676-1.222-.676-2.005 0-.614.123-1.141.369-1.582.246-.441.58-.804 1.004-1.089a4.494 4.494 0 0 1 1.47-.629 7.536 7.536 0 0 1 1.77-.201zm-15.113.188h9.563v2.166H9.506v9.646H6.789v-9.646H3.375z"/></svg>`,
        'Tailwind CSS': `<svg viewBox="0 0 24 24" fill="#06B6D4"><path d="M12.001,4.8c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 C13.666,10.618,15.027,12,18.001,12c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C16.337,6.182,14.976,4.8,12.001,4.8z M6.001,12c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 c1.177,1.194,2.538,2.576,5.512,2.576c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C10.337,13.382,8.976,12,6.001,12z"/></svg>`,
        'Bootstrap': `<svg viewBox="0 0 24 24" fill="#7952B3"><path d="M11.77 11.24H9.956V8.202h2.152c1.17 0 1.834.522 1.834 1.466 0 1.008-.773 1.572-2.174 1.572z"/><path d="M21.58 12c0 5.302-4.298 9.6-9.6 9.6s-9.6-4.298-9.6-9.6S6.678 2.4 12 2.4s9.58 4.298 9.58 9.6zm-9.804 6.045c2.653 0 4.45-1.371 4.45-3.542 0-1.79-1.227-2.851-3.044-3.044v-.029c1.371-.379 2.133-1.371 2.133-2.653 0-1.933-1.518-3.044-4.102-3.044H6.429v12.312h5.347zm.064-5.353c1.518 0 2.218.61 2.218 1.518 0 .956-.7 1.518-2.218 1.518H9.956v-3.036h2.884z"/></svg>`,
        'React': `<svg viewBox="0 0 24 24" fill="#61DAFB"><path d="M14.23 12.004a2.236 2.236 0 0 1-2.235 2.236 2.236 2.236 0 0 1-2.236-2.236 2.236 2.236 0 0 1 2.235-2.236 2.236 2.236 0 0 1 2.236 2.236zm2.648-10.69c-1.346 0-3.107.96-4.888 2.622-1.78-1.653-3.542-2.602-4.887-2.602-.41 0-.783.093-1.106.278-1.375.793-1.683 3.264-.973 6.365C1.98 8.917 0 10.42 0 12.004c0 1.59 1.99 3.097 5.043 4.03-.704 3.113-.39 5.588.988 6.38.32.187.69.275 1.102.275 1.345 0 3.107-.96 4.888-2.624 1.78 1.654 3.542 2.603 4.887 2.603.41 0 .783-.09 1.106-.275 1.374-.792 1.683-3.263.973-6.365C22.02 15.096 24 13.59 24 12.004c0-1.59-1.99-3.097-5.043-4.032.704-3.11.39-5.587-.988-6.38-.318-.184-.688-.277-1.092-.278zm-.005 1.09v.006c.225 0 .406.044.558.127.666.382.955 1.835.73 3.704-.054.46-.142.945-.25 1.44-.96-.236-2.006-.417-3.107-.534-.66-.905-1.345-1.727-2.035-2.047zm-13.395.004c.278.96.645 1.957 1.1 2.98-.45 1.017-.812 2.01-1.086 2.964-.484-.15-.944-.318-1.37-.5-1.732-.737-2.852-1.706-2.852-2.474 0-.768 1.12-1.742 2.852-2.476.42-.18.88-.342 1.356-.494zm11.678 4.28c.265.657.49 1.312.676 1.948-.64.157-1.316.29-2.016.39.24-.375.48-.762.705-1.158.225-.39.435-.788.636-1.18zm-9.945.02c.2.392.41.783.64 1.175.23.39.465.772.705 1.143-.695-.102-1.365-.23-2.006-.386.18-.63.406-1.282.66-1.933zM17.92 16.32c.112.493.2.968.254 1.423.23 1.868-.054 3.32-.714 3.708-.147.09-.338.128-.563.128-1.012 0-2.514-.807-4.11-2.28.686-.72 1.37-1.536 2.02-2.44 1.107-.118 2.154-.3 3.113-.54zm-11.83.01c.96.234 2.006.415 3.107.532.66.905 1.345 1.727 2.035 2.446-1.595 1.483-3.092 2.295-4.11 2.295-.22-.005-.406-.05-.553-.132-.666-.38-.955-1.834-.73-3.703.054-.46.142-.944.25-1.438zm4.56.64c.44.02.89.034 1.36.034.47 0 .92-.014 1.36-.034-.44.572-.895 1.095-1.36 1.562-.465-.467-.92-.99-1.36-1.562z"/></svg>`,
        'Node.js': `<svg viewBox="0 0 24 24" fill="#68A063"><path d="M11.998,24c-0.321,0-0.641-0.084-0.922-0.247l-2.936-1.737c-0.438-0.245-0.224-0.332-0.08-0.383 c0.585-0.203,0.703-0.25,1.328-0.604c0.065-0.037,0.151-0.023,0.218,0.017l2.256,1.339c0.082,0.045,0.197,0.045,0.272,0l8.795-5.076 c0.082-0.047,0.134-0.141,0.134-0.238V6.921c0-0.099-0.053-0.192-0.137-0.242l-8.791-5.072c-0.081-0.047-0.189-0.047-0.271,0 L3.075,6.68C2.990,6.729,2.936,6.825,2.936,6.921v10.15c0,0.097,0.054,0.189,0.139,0.235l2.409,1.392 c1.307,0.654,2.108-0.116,2.108-0.89V7.787c0-0.142,0.114-0.253,0.256-0.253h1.115c0.139,0,0.255,0.112,0.255,0.253v10.021 c0,1.745-0.95,2.745-2.604,2.745c-0.508,0-0.909,0-2.026-0.551L2.28,18.675c-0.57-0.329-0.922-0.945-0.922-1.604V6.921 c0-0.659,0.353-1.275,0.922-1.603l8.795-5.082c0.557-0.315,1.296-0.315,1.848,0l8.794,5.082c0.570,0.329,0.924,0.944,0.924,1.603 v10.15c0,0.659-0.354,1.277-0.924,1.604l-8.794,5.078C12.643,23.916,12.324,24,11.998,24z M19.099,13.993 c0-1.9-1.284-2.406-3.987-2.763c-2.731-0.361-3.009-0.548-3.009-1.187c0-0.528,0.235-1.233,2.258-1.233 c1.807,0,2.473,0.389,2.747,1.607c0.024,0.115,0.129,0.199,0.247,0.199h1.141c0.071,0,0.138-0.031,0.186-0.081 c0.048-0.054,0.074-0.123,0.067-0.196c-0.177-2.098-1.571-3.076-4.388-3.076c-2.508,0-4.004,1.058-4.004,2.833 c0,1.925,1.488,2.457,3.895,2.695c2.88,0.282,3.103,0.703,3.103,1.269c0,0.983-0.789,1.402-2.642,1.402 c-2.327,0-2.839-0.584-3.011-1.742c-0.02-0.124-0.126-0.215-0.253-0.215h-1.137c-0.141,0-0.254,0.112-0.254,0.253 c0,1.482,0.806,3.248,4.655,3.248C17.501,17.007,19.099,15.91,19.099,13.993z"/></svg>`,
        'TypeScript': `<svg viewBox="0 0 24 24" fill="#3178C6"><path d="M1.125 0C.502 0 0 .502 0 1.125v21.75C0 23.498.502 24 1.125 24h21.75c.623 0 1.125-.502 1.125-1.125V1.125C24 .502 23.498 0 22.875 0zm17.363 9.75c.612 0 1.154.037 1.627.111a6.38 6.38 0 0 1 1.306.34v2.458a3.95 3.95 0 0 0-.643-.361 5.093 5.093 0 0 0-.717-.26 5.453 5.453 0 0 0-1.426-.2c-.3 0-.573.028-.819.086a2.1 2.1 0 0 0-.623.242c-.17.104-.3.229-.393.374a.888.888 0 0 0-.14.49c0 .196.053.373.156.529.104.156.252.304.443.444s.423.276.696.41c.273.135.582.274.926.416.47.197.892.407 1.266.628.374.222.695.473.963.753.268.279.472.598.614.957.142.359.213.776.213 1.253 0 .657-.125 1.21-.373 1.656a3.033 3.033 0 0 1-1.012 1.085 4.38 4.38 0 0 1-1.487.596c-.566.12-1.163.18-1.79.18a9.916 9.916 0 0 1-1.84-.164 5.544 5.544 0 0 1-1.512-.493v-2.63a5.033 5.033 0 0 0 3.237 1.2c.333 0 .624-.03.872-.09.249-.06.456-.144.623-.25.166-.108.29-.234.373-.38a1.023 1.023 0 0 0-.074-1.089 2.12 2.12 0 0 0-.537-.5 5.597 5.597 0 0 0-.807-.444 27.72 27.72 0 0 0-1.007-.436c-.918-.383-1.602-.852-2.053-1.405-.45-.553-.676-1.222-.676-2.005 0-.614.123-1.141.369-1.582.246-.441.58-.804 1.004-1.089a4.494 4.494 0 0 1 1.47-.629 7.536 7.536 0 0 1 1.77-.201zm-15.113.188h9.563v2.166H9.506v9.646H6.789v-9.646H3.375z"/></svg>`,
        'Inertia.js': `<svg viewBox="0 0 24 24" fill="#9553E9"><path d="M12.001 0C5.373 0 0 5.373 0 12.001s5.373 12.001 12.001 12.001 12.001-5.373 12.001-12.001S18.629 0 12.001 0zm-.001 4.62c1.842 0 3.344 1.501 3.344 3.343s-1.502 3.344-3.344 3.344-3.343-1.502-3.343-3.344 1.501-3.343 3.343-3.343zm0 6.685c1.842 0 3.344 1.502 3.344 3.344S13.843 18.001 12 18.001s-3.343-1.501-3.343-3.343S10.158 11.305 12 11.305z"/></svg>`,
        'Vite': `<svg viewBox="0 0 24 24" fill="#646CFF"><path d="m8.286 10.578.512-8.657a.306.306 0 0 1 .247-.284L17.377.006a.306.306 0 0 1 .353.385l-1.558 5.403a.306.306 0 0 0 .352.385l2.388-.46a.306.306 0 0 1 .332.438l-6.79 13.55-.123.19a.294.294 0 0 1-.252.14c-.177 0-.35-.152-.305-.369l1.095-5.301a.306.306 0 0 0-.388-.355L5.599 15.33a.306.306 0 0 1-.388-.355l1.943-4.492a.306.306 0 0 1 .132-.905Z"/><path d="M14.583 2.926 14.583 2.926l1.216 5.159a.306.306 0 0 0 .388.355l6.904-1.318a.306.306 0 0 0 .132-.905L14.583 2.926Z" fill="#FFCA28"/></svg>`,
        'Docker': `<svg viewBox="0 0 24 24" fill="#2496ED"><path d="M13.983 11.078h2.119a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.119a.185.185 0 00-.185.185v1.888c0 .102.083.185.185.185m-2.954-5.43h2.118a.186.186 0 00.186-.186V3.574a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.888c0 .102.082.185.185.186m0 2.716h2.118a.187.187 0 00.186-.186V6.29a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.887c0 .102.082.185.185.186m-2.93 0h2.12a.186.186 0 00.184-.186V6.29a.185.185 0 00-.185-.185H8.1a.185.185 0 00-.185.185v1.887c0 .102.083.185.185.186m-2.964 0h2.119a.186.186 0 00.185-.186V6.29a.185.185 0 00-.184-.185H5.136a.186.186 0 00-.186.185v1.887c0 .102.084.185.186.186m5.893 2.715h2.118a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.118a.185.185 0 00-.185.185v1.888c0 .102.082.185.185.185m-2.93 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.185v1.888c0 .102.083.185.185.185m-2.964 0h2.119a.185.185 0 00.185-.185V9.006a.185.185 0 00-.184-.186h-2.12a.186.186 0 00-.186.186v1.887c0 .102.084.185.186.185m-2.92 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.185v1.888c0 .102.082.185.185.185M23.763 9.89c-.065-.051-.672-.51-1.954-.51-.338.001-.676.03-1.01.087-.248-1.7-1.653-2.53-1.716-2.566l-.344-.199-.226.327c-.284.438-.49.922-.612 1.43-.23.97-.09 1.882.403 2.661-.595.332-1.55.413-1.744.42H.751a.751.751 0 00-.75.748 11.376 11.376 0 00.692 4.062c.545 1.428 1.355 2.48 2.41 3.124 1.18.723 3.1 1.137 5.275 1.137.983.003 1.963-.086 2.93-.266a12.248 12.248 0 003.823-1.389c.98-.567 1.86-1.288 2.61-2.136 1.252-1.418 1.998-2.997 2.553-4.4h.221c1.372 0 2.215-.549 2.68-1.009.309-.293.55-.65.707-1.046l.098-.288Z"/></svg>`
    };
    return icons[skillName] || `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>`;
};

// Setup scroll-triggered animations with enhanced progression
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
        animation: { opacity: 1, y: 0, scale: 1 },
        options: { duration: 0.6 },
        staggerDelay: 0.1
    }
]);

// Initialize skill animations when component is mounted
onMounted(() => {
    setTimeout(() => {
        filteredSkills.value.forEach(skill => {
            animateSkillBar(skill.id, skill.level);
        });
    }, 1000);
});
</script>

<template>
    <section id="skills" class="py-12 sm:py-16 lg:py-20 bg-slate-900 px-4 sm:px-6 lg:px-8" ref="skillsContainer">
        <div class="max-w-7xl mx-auto">
            <div class="skills-header text-center mb-12 sm:mb-16 lg:mb-20 opacity-0 transform translate-y-[30px]">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                    My <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Skills</span>
                </h2>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-400 max-w-3xl mx-auto">
                    Technologies I work with
                </p>
            </div>

            <!-- Enhanced Category Filters -->
            <div class="skills-filters mb-8 sm:mb-12 lg:mb-16 opacity-0 transform translate-y-[20px]">
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3 md:gap-4 lg:gap-6">
                    <button
                        v-for="category in categories"
                        :key="category"
                        @click="selectedCategory = category"
                        :class="[
                            'px-4 sm:px-6 lg:px-8 py-2 sm:py-3 lg:py-4 rounded-full text-xs sm:text-sm md:text-base lg:text-lg font-medium transition-all duration-300 capitalize relative overflow-hidden group',
                            selectedCategory === category
                                ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg shadow-cyan-500/25 scale-105'
                                : 'bg-slate-800/50 text-gray-400 hover:bg-slate-700/50 hover:text-white border border-slate-700 hover:border-slate-600 hover:scale-105'
                        ]"
                    >
                        <span class="relative z-10">{{ category }}</span>
                        <span v-if="category !== 'all'" class="ml-2 text-xs opacity-75 relative z-10">
                            ({{ transformedSkills.filter(s => s.category === category).length }})
                        </span>

                        <!-- Button shine effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 transform -skew-x-12 group-hover:animate-shimmer"></div>
                    </button>
                </div>
            </div>

            <!-- Enhanced Skills Grid -->
            <div class="skills-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 md:gap-8 lg:gap-10 opacity-0 transform translate-y-[50px]">
                <TransitionGroup name="skill-list" tag="div" class="contents">
                    <div
                        v-for="(skill, index) in filteredSkills"
                        :key="skill.id"
                        :data-skill-id="skill.id"
                        class="skill-card group relative bg-slate-800/30 backdrop-blur border border-slate-700/50 rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6 md:p-8 lg:p-10 hover:bg-slate-800/50 hover:border-slate-600/50 transition-all duration-300 hover:transform hover:scale-105 opacity-0 transform translate-y-[30px] scale-95 cursor-pointer"
                        @mouseenter="animateSkillBar(skill.id, skill.level)"
                    >
                        <!-- Animated Background Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-blue-600/5 rounded-xl sm:rounded-2xl lg:rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Skill Level Indicator Ring -->
                        <div class="absolute -top-3 -right-3 w-12 h-12 rounded-full border-4 border-slate-700 bg-slate-800 flex items-center justify-center group-hover:border-cyan-500 transition-colors duration-300">
                            <span class="text-xs font-bold text-cyan-400">{{ skill.level }}%</span>
                        </div>

                        <div class="relative z-10">
                            <!-- Enhanced Skill Header -->
                            <div class="flex items-center mb-4 sm:mb-6 lg:mb-8">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 rounded-lg sm:rounded-xl lg:rounded-2xl flex items-center justify-center mr-3 sm:mr-4 md:mr-6 group-hover:scale-110 transition-transform duration-300 relative overflow-hidden"
                                    :style="{ backgroundColor: skill.color + '20', color: skill.color }"
                                >
                                    <div class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 relative z-10" v-html="getSkillIcon(skill.name)"></div>

                                    <!-- Icon pulse effect -->
                                    <div class="absolute inset-0 rounded-lg sm:rounded-xl lg:rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 animate-pulse-slow" :style="{ backgroundColor: skill.color + '10' }"></div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white group-hover:text-cyan-400 transition-colors duration-300">
                                        {{ skill.name }}
                                    </h3>
                                    <p class="text-xs sm:text-sm md:text-base text-gray-400 capitalize flex items-center gap-2">
                                        {{ skill.category }}
                                        <!-- Proficiency Badge -->
                                        <span
                                            class="px-2 py-1 text-xs rounded-full font-medium"
                                            :class="{
                                                'bg-red-500/20 text-red-400 border border-red-500/30': skill.level <= 30,
                                                'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30': skill.level > 30 && skill.level <= 60,
                                                'bg-green-500/20 text-green-400 border border-green-500/30': skill.level > 60 && skill.level <= 80,
                                                'bg-purple-500/20 text-purple-400 border border-purple-500/30': skill.level > 80
                                            }"
                                        >
                                            {{ skill.proficiency || 'Intermediate' }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <!-- Enhanced Progress Bar -->
                            <div class="mb-4 sm:mb-6">
                                <div class="flex justify-between items-center mb-2 sm:mb-3">
                                    <span class="text-xs sm:text-sm md:text-base lg:text-lg text-gray-300">Proficiency</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-cyan-400">{{ skill.level }}%</span>
                                        <!-- Star rating based on skill level -->
                                        <div class="flex gap-1">
                                            <div
                                                v-for="star in 5"
                                                :key="star"
                                                class="w-3 h-3 transition-colors duration-300"
                                                :class="star <= Math.ceil(skill.level / 20) ? 'text-yellow-400' : 'text-gray-600'"
                                            >
                                                <svg fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Animated Progress Container -->
                                <div class="relative w-full bg-slate-700/50 rounded-full h-2 sm:h-3 md:h-4 overflow-hidden">
                                    <!-- Background pattern -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-slate-700/30 to-slate-600/30"></div>

                                    <!-- Main progress bar -->
                                    <div
                                        class="skill-progress h-full bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full transition-all duration-1000 ease-out relative overflow-hidden"
                                        style="width: 0%"
                                    >
                                        <!-- Animated shine effect -->
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -skew-x-12 animate-shimmer"></div>
                                    </div>

                                    <!-- Skill level markers -->
                                    <div class="absolute inset-0 flex justify-between items-center px-1">
                                        <div v-for="marker in 4" :key="marker" class="w-0.5 h-full bg-slate-600/50 rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Description -->
                            <div class="space-y-3">
                                <p class="text-xs sm:text-sm md:text-base text-gray-400 leading-relaxed">
                                    {{ skill.description }}
                                </p>

                                <!-- Interactive Skill Tags -->
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-2 py-1 bg-slate-700/50 text-cyan-400 text-xs rounded-lg border border-slate-600/50 hover:border-cyan-500/50 transition-all duration-200 hover:scale-105 cursor-pointer"
                                        @click.stop
                                    >
                                        {{ skill.category }}
                                    </span>
                                    <span
                                        v-if="skill.level >= 75"
                                        class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded-lg border border-green-500/30 animate-pulse-slow"
                                    >
                                        Expert
                                    </span>
                                    <span
                                        v-else-if="skill.level >= 50"
                                        class="px-2 py-1 bg-blue-500/20 text-blue-400 text-xs rounded-lg border border-blue-500/30"
                                    >
                                        Proficient
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Hover tooltip -->
                        <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-sm px-3 py-2 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none z-20">
                            Click to learn more
                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-slate-800"></div>
                        </div>
                    </div>
                </TransitionGroup>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Skill List Transitions */
.skill-list-move,
.skill-list-enter-active,
.skill-list-leave-active {
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.skill-list-enter-from {
    opacity: 0;
    transform: translateY(30px) scale(0.9);
}

.skill-list-leave-to {
    opacity: 0;
    transform: translateY(-30px) scale(0.9);
}

.skill-list-leave-active {
    position: absolute;
    width: 100%;
}

/* Enhanced Hover Effects */
.skill-card {
    transform-origin: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.skill-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(6, 182, 212, 0.1), transparent);
    transition: left 0.6s;
    z-index: 1;
}

.skill-card:hover::before {
    left: 100%;
}

.skill-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
}

/* Progress Bar Animations */
.skill-progress {
    position: relative;
    background: linear-gradient(135deg, #06b6d4, #3b82f6, #8b5cf6);
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}

.skill-progress::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: progress-shine 2s infinite;
    opacity: 0;
}

.skill-card:hover .skill-progress::after {
    opacity: 1;
}

@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes progress-shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Shimmer Animation */
@keyframes shimmer {
    0% { transform: translateX(-100%) skewX(-12deg); }
    100% { transform: translateX(200%) skewX(-12deg); }
}

.animate-shimmer {
    animation: shimmer 2s infinite;
}

/* Pulse Animation */
@keyframes pulse-slow {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}

.animate-pulse-slow {
    animation: pulse-slow 3s infinite;
}

/* Star Rating Animation */
.text-yellow-400 {
    animation: star-glow 2s ease-in-out infinite alternate;
}

@keyframes star-glow {
    from { filter: drop-shadow(0 0 2px #fbbf24); }
    to { filter: drop-shadow(0 0 8px #fbbf24); }
}

/* Filter Button Enhancements */
.skills-filters button {
    backdrop-filter: blur(10px);
    position: relative;
    transform-origin: center;
}

.skills-filters button:active {
    transform: scale(0.95);
}

/* Skill Level Indicator Ring */
.skill-card .absolute.-top-3.-right-3 {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
}

.skill-card:hover .absolute.-top-3.-right-3 {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4);
}

/* Icon Container Enhancements */
.skill-card .w-10.h-10,
.skill-card .w-12.h-12,
.skill-card .w-14.h-14,
.skill-card .w-16.h-16 {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Tooltip Styling */
.skill-card .absolute.-top-12 {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    font-weight: 500;
    white-space: nowrap;
}

/* Progress Bar Container */
.skill-card .relative.w-full.bg-slate-700\/50 {
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

/* Skill Tags Interactive */
.skill-card .px-2.py-1 {
    backdrop-filter: blur(5px);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.skill-card .px-2.py-1:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Proficiency Badge Glow */
.bg-red-500\/20 { box-shadow: 0 0 10px rgba(239, 68, 68, 0.3); }
.bg-yellow-500\/20 { box-shadow: 0 0 10px rgba(245, 158, 11, 0.3); }
.bg-green-500\/20 { box-shadow: 0 0 10px rgba(34, 197, 94, 0.3); }
.bg-purple-500\/20 { box-shadow: 0 0 10px rgba(168, 85, 247, 0.3); }

/* Grid Layout Improvements */
.skills-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

@media (min-width: 640px) {
    .skills-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
}

@media (min-width: 1024px) {
    .skills-grid {
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    }
}

/* Focus States for Accessibility */
.skill-card:focus-visible,
.skills-filters button:focus-visible {
    outline: 2px solid #06b6d4;
    outline-offset: 2px;
}

/* High Contrast Mode Support */
@media (prefers-contrast: high) {
    .skill-card {
        border: 2px solid #fff;
    }

    .skill-progress {
        background: #06b6d4 !important;
    }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .skill-card,
    .skill-list-move,
    .skill-list-enter-active,
    .skill-list-leave-active,
    .skill-progress,
    .animate-shimmer,
    .animate-pulse-slow {
        animation: none !important;
        transition-duration: 0.01s !important;
    }

    .skill-card:hover {
        transform: none !important;
    }
}

/* Loading Skeleton */
.skill-card.loading {
    background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%);
    background-size: 200% 100%;
    animation: loading-pulse 2s infinite;
}

@keyframes loading-pulse {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* Enhanced Grid Animation */
.contents > .skill-card {
    animation: skill-appear 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
}

@keyframes skill-appear {
    from {
        opacity: 0;
        transform: translateY(40px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Stagger delays for skill cards */
.contents > .skill-card:nth-child(1) { animation-delay: 0.1s; }
.contents > .skill-card:nth-child(2) { animation-delay: 0.2s; }
.contents > .skill-card:nth-child(3) { animation-delay: 0.3s; }
.contents > .skill-card:nth-child(4) { animation-delay: 0.4s; }
.contents > .skill-card:nth-child(5) { animation-delay: 0.5s; }
.contents > .skill-card:nth-child(6) { animation-delay: 0.6s; }
.contents > .skill-card:nth-child(7) { animation-delay: 0.7s; }
.contents > .skill-card:nth-child(8) { animation-delay: 0.8s; }

/* Responsive Improvements */
@media (max-width: 640px) {
    .skill-card {
        margin-bottom: 1rem;
    }

    .skills-filters {
        margin-bottom: 2rem;
    }

    .skill-card .absolute.-top-12 {
        display: none; /* Hide tooltips on mobile */
    }
}

/* Dark mode enhancements */
.skill-card {
    background: rgba(30, 41, 59, 0.4);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.skill-card:hover {
    background: rgba(30, 41, 59, 0.6);
    border-color: rgba(6, 182, 212, 0.3);
}

/* Performance Optimizations */
.skill-card * {
    will-change: transform;
}

.skill-progress {
    will-change: width;
}
</style>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';
import { ref } from 'vue';

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

const props = defineProps<{
    education: Education;
}>();

const achievementInput = ref('');

const form = useForm({
    degree: props.education.degree,
    field_of_study: props.education.field_of_study,
    institution: props.education.institution,
    location: props.education.location,
    start_date: props.education.start_date,
    end_date: props.education.end_date,
    gpa: props.education.gpa,
    description: props.education.description,
    achievements: [...props.education.achievements],
    is_current: props.education.is_current,
    is_active: props.education.is_active,
});

const addAchievement = () => {
    if (achievementInput.value.trim() && !form.achievements.includes(achievementInput.value.trim())) {
        form.achievements.push(achievementInput.value.trim());
        achievementInput.value = '';
    }
};

const removeAchievement = (index: number) => {
    form.achievements.splice(index, 1);
};

const submit = () => {
    form.put(route('admin.educations.update', props.education.id));
};
</script>

<template>
    <Head title="Edit Education - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.educations.index')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Education
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Edit Education</h1>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <Label for="degree">Degree</Label>
                                    <Input
                                        id="degree"
                                        v-model="form.degree"
                                        type="text"
                                        class="mt-1"
                                        placeholder="e.g., Bachelor of Science"
                                        required
                                    />
                                    <InputError :message="form.errors.degree" />
                                </div>

                                <div>
                                    <Label for="field_of_study">Field of Study</Label>
                                    <Input
                                        id="field_of_study"
                                        v-model="form.field_of_study"
                                        type="text"
                                        class="mt-1"
                                        placeholder="e.g., Information Technology"
                                        required
                                    />
                                    <InputError :message="form.errors.field_of_study" />
                                </div>

                                <div>
                                    <Label for="institution">Institution</Label>
                                    <Input
                                        id="institution"
                                        v-model="form.institution"
                                        type="text"
                                        class="mt-1"
                                        placeholder="e.g., University of Technology"
                                        required
                                    />
                                    <InputError :message="form.errors.institution" />
                                </div>

                                <div>
                                    <Label for="location">Location</Label>
                                    <Input
                                        id="location"
                                        v-model="form.location"
                                        type="text"
                                        class="mt-1"
                                        placeholder="e.g., Manila, Philippines"
                                    />
                                    <InputError :message="form.errors.location" />
                                </div>

                                <div>
                                    <Label for="start_date">Start Date</Label>
                                    <Input
                                        id="start_date"
                                        v-model="form.start_date"
                                        type="date"
                                        class="mt-1"
                                        required
                                    />
                                    <InputError :message="form.errors.start_date" />
                                </div>

                                <div>
                                    <Label for="end_date">End Date</Label>
                                    <Input
                                        id="end_date"
                                        v-model="form.end_date"
                                        type="date"
                                        class="mt-1"
                                        :disabled="form.is_current"
                                    />
                                    <InputError :message="form.errors.end_date" />
                                </div>

                                <div>
                                    <Label for="gpa">GPA/Grade</Label>
                                    <Input
                                        id="gpa"
                                        v-model="form.gpa"
                                        type="text"
                                        class="mt-1"
                                        placeholder="e.g., 3.8 or Magna Cum Laude"
                                    />
                                    <InputError :message="form.errors.gpa" />
                                </div>
                            </div>

                            <div>
                                <Label for="description">Description</Label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="3"
                                    placeholder="Brief description of your education experience..."
                                ></textarea>
                                <InputError :message="form.errors.description" />
                            </div>

                            <div>
                                <Label>Achievements & Honors</Label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex space-x-2">
                                        <Input
                                            v-model="achievementInput"
                                            placeholder="Add achievement"
                                            @keyup.enter="addAchievement"
                                        />
                                        <Button type="button" @click="addAchievement">Add</Button>
                                    </div>
                                    <ul class="space-y-1">
                                        <li
                                            v-for="(achievement, index) in form.achievements"
                                            :key="index"
                                            class="flex items-center justify-between bg-gray-50 p-2 rounded"
                                        >
                                            <span class="text-sm">{{ achievement }}</span>
                                            <button
                                                type="button"
                                                @click="removeAchievement(index)"
                                                class="text-red-600 hover:text-red-800"
                                            >
                                                Remove
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <InputError :message="form.errors.achievements" />
                            </div>

                            <div class="flex items-center space-x-6">
                                <div class="flex items-center space-x-2">
                                    <Checkbox
                                        id="is_current"
                                        v-model="form.is_current"
                                    />
                                    <Label for="is_current">Currently Studying</Label>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <Checkbox
                                        id="is_active"
                                        v-model="form.is_active"
                                    />
                                    <Label for="is_active">Active</Label>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <Link :href="route('admin.educations.index')">
                                    <Button variant="outline">Cancel</Button>
                                </Link>
                                <Button type="submit" :disabled="form.processing">
                                    Update Education
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

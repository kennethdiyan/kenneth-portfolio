<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';

const form = useForm({
    degree: '',
    field_of_study: '',
    institution: '',
    location: '',
    start_date: '',
    end_date: '',
    gpa: '',
    description: '',
    achievements: '',
    is_current: false,
    is_active: true,
});

const submit = () => {
    form.post(route('admin.educations.store'));
};
</script>

<template>
    <Head title="Create Education - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.educations.index')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Education
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Create Education</h1>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <form @submit.prevent="submit" class="space-y-6">
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
                                    placeholder="e.g., Computer Science"
                                />
                                <InputError :message="form.errors.field_of_study" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                        placeholder="e.g., New York, NY"
                                    />
                                    <InputError :message="form.errors.location" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                                    <Label for="gpa">GPA</Label>
                                    <Input
                                        id="gpa"
                                        v-model="form.gpa"
                                        type="text"
                                        class="mt-1"
                                        placeholder="e.g., 3.8/4.0"
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
                                    placeholder="Brief description of the program or studies..."
                                ></textarea>
                                <InputError :message="form.errors.description" />
                            </div>

                            <div>
                                <Label for="achievements">Achievements</Label>
                                <textarea
                                    id="achievements"
                                    v-model="form.achievements"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="3"
                                    placeholder="Awards, honors, notable achievements (one per line or comma-separated)..."
                                ></textarea>
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
                                    Create Education
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

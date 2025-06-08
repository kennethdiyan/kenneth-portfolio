<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';

const form = useForm({
    name: '',
    url: '',
    icon: '',
    is_active: true,
    sort_order: 0,
});

const submit = () => {
    form.post(route('admin.social-links.store'));
};
</script>

<template>
    <Head title="Create Social Link - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.social-links.index')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Social Links
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Create Social Link</h1>
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
                                <Label for="name">Platform Name</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1"
                                    placeholder="e.g., GitHub, LinkedIn, Twitter"
                                    required
                                />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div>
                                <Label for="url">URL</Label>
                                <Input
                                    id="url"
                                    v-model="form.url"
                                    type="url"
                                    class="mt-1"
                                    placeholder="https://github.com/username"
                                    required
                                />
                                <InputError :message="form.errors.url" />
                            </div>

                            <div>
                                <Label for="icon">Icon</Label>
                                <Input
                                    id="icon"
                                    v-model="form.icon"
                                    type="text"
                                    class="mt-1"
                                    placeholder="e.g., github, linkedin, twitter"
                                />
                                <p class="mt-1 text-sm text-gray-500">Icon identifier for the platform (e.g., FontAwesome or Lucide icon names)</p>
                                <InputError :message="form.errors.icon" />
                            </div>

                            <div>
                                <Label for="sort_order">Sort Order</Label>
                                <Input
                                    id="sort_order"
                                    v-model="form.sort_order"
                                    type="number"
                                    class="mt-1"
                                    min="0"
                                />
                                <p class="mt-1 text-sm text-gray-500">Lower numbers appear first</p>
                                <InputError :message="form.errors.sort_order" />
                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox
                                    id="is_active"
                                    v-model="form.is_active"
                                />
                                <Label for="is_active">Active</Label>
                                <InputError :message="form.errors.is_active" />
                            </div>

                            <div class="flex justify-end space-x-4">
                                <Link :href="route('admin.social-links.index')">
                                    <Button variant="outline">Cancel</Button>
                                </Link>
                                <Button type="submit" :disabled="form.processing">
                                    Create Social Link
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';

const form = useForm({
    type: '',
    label: '',
    value: '',
    href: '',
    icon: '',
    is_active: true,
    sort_order: 0,
});

const submit = () => {
    form.post(route('admin.contact-info.store'));
};
</script>

<template>
    <Head title="Create Contact Info - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.contact-info.index')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Contact Information
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Create Contact Info</h1>
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
                                <Label for="type">Contact Type</Label>
                                <select
                                    id="type"
                                    v-model="form.type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option value="">Select contact type</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                    <option value="location">Location</option>
                                    <option value="website">Website</option>
                                    <option value="other">Other</option>
                                </select>
                                <InputError :message="form.errors.type" />
                            </div>

                            <div>
                                <Label for="label">Label</Label>
                                <Input
                                    id="label"
                                    v-model="form.label"
                                    type="text"
                                    class="mt-1"
                                    placeholder="e.g., Work Email, Mobile Phone"
                                    required
                                />
                                <InputError :message="form.errors.label" />
                            </div>

                            <div>
                                <Label for="value">Value</Label>
                                <Input
                                    id="value"
                                    v-model="form.value"
                                    type="text"
                                    class="mt-1"
                                    placeholder="e.g., contact@example.com, +1 (555) 123-4567"
                                    required
                                />
                                <InputError :message="form.errors.value" />
                            </div>

                            <div>
                                <Label for="href">Link (optional)</Label>
                                <Input
                                    id="href"
                                    v-model="form.href"
                                    type="text"
                                    class="mt-1"
                                    placeholder="e.g., mailto:contact@example.com, tel:+15551234567"
                                />
                                <p class="mt-1 text-sm text-gray-500">For emails use mailto:, for phones use tel:</p>
                                <InputError :message="form.errors.href" />
                            </div>

                            <div>
                                <Label for="icon">Icon</Label>
                                <Input
                                    id="icon"
                                    v-model="form.icon"
                                    type="text"
                                    class="mt-1"
                                    placeholder="e.g., envelope, phone, map-pin"
                                />
                                <p class="mt-1 text-sm text-gray-500">Icon name for display (e.g., Heroicons or Lucide icon names)</p>
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
                                <Link :href="route('admin.contact-info.index')">
                                    <Button variant="outline">Cancel</Button>
                                </Link>
                                <Button type="submit" :disabled="form.processing">
                                    Create Contact Info
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

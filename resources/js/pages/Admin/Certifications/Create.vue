<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';

const form = useForm({
    name: '',
    issuer: '',
    issue_date: '',
    expiry_date: '',
    credential_id: '',
    credential_url: '',
    description: '',
    is_active: true,
});

const submit = () => {
    form.post(route('admin.certifications.store'));
};
</script>

<template>
    <Head title="Create Certification - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.certifications.index')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Certifications
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Create Certification</h1>
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
                                <Label for="name">Certification Name</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1"
                                    placeholder="e.g., AWS Certified Solutions Architect"
                                    required
                                />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div>
                                <Label for="issuer">Issuing Organization</Label>
                                <Input
                                    id="issuer"
                                    v-model="form.issuer"
                                    type="text"
                                    class="mt-1"
                                    placeholder="e.g., Amazon Web Services"
                                    required
                                />
                                <InputError :message="form.errors.issuer" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <Label for="issue_date">Issue Date</Label>
                                    <Input
                                        id="issue_date"
                                        v-model="form.issue_date"
                                        type="date"
                                        class="mt-1"
                                        required
                                    />
                                    <InputError :message="form.errors.issue_date" />
                                </div>

                                <div>
                                    <Label for="expiry_date">Expiry Date</Label>
                                    <Input
                                        id="expiry_date"
                                        v-model="form.expiry_date"
                                        type="date"
                                        class="mt-1"
                                    />
                                    <p class="mt-1 text-sm text-gray-500">Leave empty if certification doesn't expire</p>
                                    <InputError :message="form.errors.expiry_date" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <Label for="credential_id">Credential ID</Label>
                                    <Input
                                        id="credential_id"
                                        v-model="form.credential_id"
                                        type="text"
                                        class="mt-1"
                                        placeholder="e.g., ABC123DEF456"
                                    />
                                    <InputError :message="form.errors.credential_id" />
                                </div>

                                <div>
                                    <Label for="credential_url">Credential URL</Label>
                                    <Input
                                        id="credential_url"
                                        v-model="form.credential_url"
                                        type="url"
                                        class="mt-1"
                                        placeholder="https://example.com/verify/123"
                                    />
                                    <InputError :message="form.errors.credential_url" />
                                </div>
                            </div>

                            <div>
                                <Label for="description">Description</Label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="3"
                                    placeholder="Brief description of the certification and what it validates..."
                                ></textarea>
                                <InputError :message="form.errors.description" />
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
                                <Link :href="route('admin.certifications.index')">
                                    <Button variant="outline">Cancel</Button>
                                </Link>
                                <Button type="submit" :disabled="form.processing">
                                    Create Certification
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

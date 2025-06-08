<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';

interface Certification {
    id: number;
    name: string;
    issuer: string;
    issue_date: string;
    expiry_date: string;
    credential_id: string;
    credential_url: string;
    description: string;
    is_active: boolean;
}

const props = defineProps<{
    certification: Certification;
}>();

const form = useForm({
    name: props.certification.name,
    issuer: props.certification.issuer,
    issue_date: props.certification.issue_date,
    expiry_date: props.certification.expiry_date,
    credential_id: props.certification.credential_id,
    credential_url: props.certification.credential_url,
    description: props.certification.description,
    is_active: props.certification.is_active,
});

const submit = () => {
    form.put(route('admin.certifications.update', props.certification.id));
};
</script>

<template>
    <Head title="Edit Certification - Admin" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.certifications.index')" class="text-gray-500 hover:text-gray-700 mr-4">
                            ← Back to Certifications
                        </Link>
                        <h1 class="text-xl font-semibold text-gray-900">Edit Certification</h1>
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
                                <div class="md:col-span-2">
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
                                    <Label for="issuer">Issuer</Label>
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

                                <div>
                                    <Label for="credential_id">Credential ID</Label>
                                    <Input
                                        id="credential_id"
                                        v-model="form.credential_id"
                                        type="text"
                                        class="mt-1"
                                        placeholder="Certificate ID or Badge ID"
                                    />
                                    <InputError :message="form.errors.credential_id" />
                                </div>

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
                                    <p class="text-sm text-gray-500 mt-1">Leave empty if certification doesn't expire</p>
                                    <InputError :message="form.errors.expiry_date" />
                                </div>

                                <div class="md:col-span-2">
                                    <Label for="credential_url">Credential URL</Label>
                                    <Input
                                        id="credential_url"
                                        v-model="form.credential_url"
                                        type="url"
                                        class="mt-1"
                                        placeholder="https://verify.certificate.com/..."
                                    />
                                    <InputError :message="form.errors.credential_url" />
                                </div>

                                <div class="md:col-span-2">
                                    <Label for="description">Description</Label>
                                    <textarea
                                        id="description"
                                        v-model="form.description"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        rows="3"
                                        placeholder="Brief description of what this certification covers..."
                                    ></textarea>
                                    <InputError :message="form.errors.description" />
                                </div>
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
                                    Update Certification
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

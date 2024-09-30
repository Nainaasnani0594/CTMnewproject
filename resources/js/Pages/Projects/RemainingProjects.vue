<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps } from 'vue';

defineProps({
    projects: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Remaining Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Remaining Projects Without Tasks or Groups
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="projects.length === 0" class="text-center py-4">
                            No remaining projects without tasks or groups.
                        </div>
                        <div v-else class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Project Name</th>
                                        <th>Sponsor Name</th>
                                        <th>Project Manager</th>
                                        <th>Contract Holder Country</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(project, index) in projects" :key="project.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ project.project_name }}</td>
                                        <td>{{ project.sponsor_name }}</td>
                                        <td>{{ project.project_manager }}</td>
                                        <td>{{ project.contract_holder_country }}</td>
                                        <td>
                                            <Link :href="route('projects.show', project.id)" class="btn btn-sm btn-primary">View</Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

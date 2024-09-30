<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { hasRole, to_roman_numerical } from "@/util";
import { ref } from "vue"; 
defineProps({
    projects: {
        type: Array,
        required: true,
    },
    auth: {
        type: Object,
        required: true,
    },
});
const showFilteredProjects = ref(false);
const deleteProject = (id) => {
    if (confirm("Are you sure you want to delete this project?")) {
        router.delete(route("projects.destroy", id));
    }
};
const toggleFilter = () => {
    showFilteredProjects.value = !showFilteredProjects.value;
};
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
                <Link
                    v-if="hasRole(['Admin', 'Super Admin'], auth.user)"
                    :href="route('projects.create')"
                    class="bg-gray-300 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Create Project</Link>
            </div>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="projects.length === 0" class="text-center py-4">No projects exist.</div>
                        <div v-else class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Sponsor Name</th>
                                        <th @click="toggleFilter" class="cursor-pointer">Project Name</th>
                                        <th>Contract Holder Country</th>
                                        <th>Project Manager</th>
                                        <th>Status</th>
                                        <th>Phase</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(project, index) in projects.filter(p => !showFilteredProjects || p.groups.length === 0)" 
                                        :key="project.id" 
                                        :class="{'bg-gray-100': project.groups.length === 0}">
                                        <th>{{ index + 1 }}</th>
                                        <td>{{ project.sponsor_name }}</td>
                                        <td>{{ project.project_name }}</td>
                                        <td>{{ project.contract_holder_country }}</td>
                                        <td>{{ project.project_manager }}</td>
                                        <td>{{ project.status ? "Active" : "Inactive" }}</td>
                                        <td>{{ to_roman_numerical(project.phase) }}</td>
                                        <td class="flex gap-2">
                                            <Link :href="route('projects.show', project.id)" class="btn btn-sm btn-primary">View</Link>
                                            <button v-if="hasRole(['Admin', 'Super Admin'], auth.user)" 
                                                @click="deleteProject(project.id)" class="btn btn-sm btn-error">Delete</button>
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


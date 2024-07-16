<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

import { to_roman_numerical } from "@/util";

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Sponsor Name</th>
                                        <th>Project Name</th>
                                        <th>Contract Holder Country</th>
                                        <th>Project Manager</th>
                                        <th>Status</th>
                                        <th>Phase</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr v-for="(project, index) in projects">
                                        <th>{{ index + 1 }}</th>
                                        <td>{{ project.sponsor_name }}</td>
                                        <td>{{ project.project_name }}</td>
                                        <td>
                                            {{
                                                project.contract_holder_country
                                            }}
                                        </td>
                                        <td>{{ project.project_manager }}</td>
                                        <td>
                                            {{
                                                project.status
                                                    ? "Active"
                                                    : "Inactive"
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                to_roman_numerical(
                                                    project.phase
                                                )
                                            }}
                                        </td>
                                        <td class="flex gap-2">
                                            <Link
                                                :href="
                                                    route(
                                                        'projects.show',
                                                        project.id
                                                    )
                                                "
                                                class="btn btn-sm btn-primary"
                                                >View</Link
                                            >
                                            <Link
                                                class="btn btn-sm btn-error"
                                                >Delete</Link
                                            >
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

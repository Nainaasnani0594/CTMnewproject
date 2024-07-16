<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";


const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const group_dropdowns = {};

props.project.groups.forEach((group) => {
    group_dropdowns[group.id] = ref(false);
});


import ProjectDetails from "@/Components/ProjectDetails.vue";
import GroupsList from "@/Components/GroupsList.vue";

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Project
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ProjectDetails :project="project" />
                    </div>
                </div>
                <div
                    class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <GroupsList :project="project" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

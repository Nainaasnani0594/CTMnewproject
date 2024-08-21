<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddGroupForm from "@/Components/AddGroupForm.vue";
import AddTaskForm from "@/Components/AddTaskForm.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";
// axios
import axios from "axios";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const project = ref(props.project);

const group_dropdowns = {};

project.value.groups.forEach((group) => {
    group_dropdowns[group.id] = ref(false);
});

import ProjectDetails from "@/Components/ProjectDetails.vue";
import GroupsList from "@/Components/GroupsList.vue";

const creation_form_is_visible = ref(false);
const project_details_is_visible = ref(false);
const file_input = ref(null);
const import_file = () => {
    const options = {
        method: "POST",
        headers: { "Content-Type": "multipart/form-data" },
        url: route("import", project.value.id),
        data: {
            file: file_input.value.files[0],
        },
    };

    axios
        .request(options)
        .then((response) => {
            project.value = response.data.project;
        })
        .catch((error) => {
            console.error(error);
        });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between gap-4 items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ project.project_name }}
                </h2>
                <button
                    @click="
                        project_details_is_visible = !project_details_is_visible
                    "
                    class="btn btn-primary"
                >
                    {{ project_details_is_visible ? "Hide" : "Show" }} Details
                </button>
                <button
                    @click="
                        creation_form_is_visible = !creation_form_is_visible
                    "
                    class="btn btn-primary"
                >
                    {{ creation_form_is_visible ? "Hide" : "Show" }}
                    Creation Form
                </button>
                <input
                    type="file"
                    accept=".csv,.xlsx,.xls"
                    class="hidden"
                    ref="file_input"
                    @change="import_file"
                />
                <button
                    @click="$refs.file_input.click()"
                    class="btn btn-primary"
                >
                    Import
                </button>
                <a
                    target="_blank"
                    :href="route('project_export', project.id)"
                    class="btn btn-primary"
                    >Export</a
                >
                <a
                    target="_blank"
                    :href="route('sample_export', project.id)"
                    class="btn btn-secondary"
                    >Sample</a
                >
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    v-if="project_details_is_visible"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <ProjectDetails :project="project" />
                    </div>
                </div>
                <div
                    v-if="creation_form_is_visible"
                    class="mt-8 p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="flex justify-between items-center">
                        <h2
                            class="font-semibold text-xl text-gray-800 leading-tight"
                        >
                            Creation Form
                        </h2>
                    </div>
                    <div class="p-6 text-gray-900">
                        <AddGroupForm :project-id="project.id" />
                        <hr />
                        <AddTaskForm :groups="project.groups" />
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

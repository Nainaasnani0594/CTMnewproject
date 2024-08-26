<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddGroupForm from "@/Components/AddGroupForm.vue";
import AddTaskForm from "@/Components/AddTaskForm.vue";
import { Head } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";
import ProjectDetails from "@/Components/ProjectDetails.vue";
import GroupsList from "@/Components/GroupsList.vue";
import axios from "axios";
import { watch } from "vue";
import Multiselect from "vue-multiselect";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    users: {
        type: Array,
        required: true,
    },
    teams: {
        type: Array,
        required: true,
    },
});

const project = ref(props.project);
const selected_users = ref([]);
const selected_teams = ref([]);

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

watch(
    () => props.project,
    (_) => {
        refresh();
    },
    { deep: true }
);

const refresh = () => {
    console.log("refreshing");
    project.value = props.project;
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
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2
                            class="font-semibold text-xl text-gray-800 leading-tight"
                        >
                            Assign Users and Teams
                        </h2>
                        <div class="flex gap-4 mt-4">
                            <label class="w-full" for="users"
                                >Users
                                <multiselect
                                    v-model="selected_users"
                                    :options="users"
                                    label="name"
                                    track-by="id"
                                    :multiple="true"
                                ></multiselect>
                            </label>
                            <label class="w-full" for="teams"
                                >Teams
                                <multiselect
                                    v-model="selected_teams"
                                    :options="teams"
                                    label="name"
                                    track-by="id"
                                    :multiple="true"
                                ></multiselect>
                            </label>
                        </div>
                    </div>
                </div>
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
                        <AddGroupForm
                            :project-id="project.id"
                            @refresh="refresh"
                        />
                        <hr />
                        <AddTaskForm
                            @refresh="refresh"
                            :groups="project.groups"
                        />
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

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddGroupForm from "@/Components/AddGroupForm.vue";
import AddTaskForm from "@/Components/AddTaskForm.vue";
import { Head } from "@inertiajs/vue3";
import { ref, defineProps, watch } from "vue";
import ProjectDetails from "@/Components/ProjectDetails.vue";
import GroupsList from "@/Components/GroupsList.vue";
import axios from "axios";
import Multiselect from "vue-multiselect";
import { hasRole } from "@/util";
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
    auth: {
        type: Object,
        required: true,
    },
});
const project = ref(props.project);
const selected_users = ref(project.value.users);
const selected_teams = ref(project.value.teams);
const creation_form_is_visible = ref(false);
const project_details_is_visible = ref(false);
const file_input = ref(null);
const errorMessage = ref(null);
const duplicates = ref([]);
const updatedAssignments = (type) => {
    const options = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        url: route("assignments", project.value.id),
        data: {
            assignable_type: type,
            assignable_id:
                type == "user"
                    ? selected_users.value.map((u) => u.id)
                    : selected_teams.value.map((t) => t.id),
        },
    };
    console.log(options);
    axios
        .request(options)
        .then((response) => {
            project.value = response.data.project;
        })
        .catch((error) => {
            console.error(error);
        });
};
console.log(props.auth.user);
const import_file = () => {
    const formData = new FormData();
    formData.append("file", file_input.value.files[0]);
    axios.post(route("import", project.value.id), formData, {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    })
    .then((response) => {
        project.value = response.data.project;
        selected_users.value = response.data.project.users;
        selected_teams.value = response.data.project.teams;
        errorMessage.value = null; 
        duplicates.value = response.data.duplicates; 
        console.log('Response data:', response.data);
        console.log('Duplicates:', response.data.duplicates);
    })
    .catch((error) => {
        errorMessage.value = error.response?.data?.error || "An unexpected error occurred.";
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
            <div v-if="errorMessage" class="bg-red-500 text-white p-4 rounded">
                {{ errorMessage }}
            </div>
    <div v-if="duplicates.length" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg w-11/12 max-w-lg">
            <h3 class="font-semibold text-xl text-gray-800">Duplicate Entries</h3>
            <ul>
            <li v-for="task in duplicates" :key="task" class="text-gray-700">{{ task }}</li>
        </ul>
        <button
            @click="duplicates = []"
            class="mt-4 bg-gray-400 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded"
>
            Close
          </button>
    </div>
    </div>
            <div class="flex justify-between gap-4 items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ project.project_name }}
                </h2>
                <button @click="
        project_details_is_visible = !project_details_is_visible"
    class="bg-gray-400 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded">
    {{ project_details_is_visible ? "Hide" : "Show" }} Details
</button>
                <button
                    v-if="hasRole(['Admin', 'Super Admin'], props.auth.user)"
                    @click="
                        creation_form_is_visible = !creation_form_is_visible"
                class="bg-gray-400 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded">
                    {{ creation_form_is_visible ? "Hide" : "Show" }}
                    Creation Form
                </button>
                <input
                    type="file"
                    accept=".csv,.xlsx,.xls"
                    class="hidden"
                    ref="file_input"
                    @change="import_file"/>
                <button
                    v-if="hasRole(['Admin', 'Super Admin'], props.auth.user)"
                    @click="$refs.file_input.click()"
                    class="bg-gray-400 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded">
                    Import
                </button>
                <a target="_blank"
                    :href="route('project_export', project.id)"
                    class="bg-gray-400 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded">Export</a>
                <a v-if="hasRole(['Admin', 'Super Admin'], props.auth.user)"
                    target="_blank"
                    :href="route('sample_export', project.id)"
                    class="bg-gray-400 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded">Sample</a>
            </div>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div v-if="errorMessage" class="bg-red-500 text-white p-4 rounded">
                    {{ errorMessage }}
                </div>
                <div v-if="hasRole(['Admin', 'Super Admin'], auth.user)" class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900">
                        <h2
                            class="font-semibold text-xl text-gray-800 leading-tight">
                            Assign Users and Teams
                        </h2>
                        <div class="flex gap-4 mt-4">
                            <label class="w-full" for="users">Users
                                <multiselect
                                    v-model="selected_users"
                                    :options="users"
                                    label="name"
                                    track-by="id"
                                    :multiple="true"
                                    @update:modelValue="
                                        updatedAssignments('user')"> 
                            </multiselect>
                            </label>
                            <label class="w-full" for="teams"
                                >Teams
                                <multiselect
                                    v-model="selected_teams"
                                    :options="teams"
                                    label="name"
                                    track-by="id"
                                    :multiple="true"
                                    @update:modelValue="
                                        updatedAssignments('team')
                                    "
                                ></multiselect>
                            </label>
                        </div>
                    </div>
                </div>
                <div
                    v-if="project_details_is_visible"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ProjectDetails :project="project" :role="props.auth.user.role" :isEditable="hasRole(['Admin', 'Super Admin'], props.auth.user)" />
                    </div>
                </div>
                <div v-if="creation_form_is_visible"
                    class="mt-2 p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-center">
                        <h2
                            class="font-semibold text-xl text-gray-800 leading-tight">
                            Creation Form
                        </h2>
                    </div>
                    <div class="p-6 text-gray-900">
                        <AddGroupForm
                            :project-id="project.id"
                            @refresh="refresh"/>
                        <hr />
                        <AddTaskForm
                            @refresh="refresh"
                            :groups="project.groups"
                        />
                    </div>
                </div>
                <div
                    class="mt-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <GroupsList :auth="auth" :project="project" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

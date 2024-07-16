<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, onBeforeUpdate, onMounted } from "vue";

import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const groups_form = useForm({
    name: "",
    project_id: props.project.id,
});

const group_dropdowns = {};

props.project.groups.forEach((group) => {
    group_dropdowns[group.id] = ref(false);
});

const tasks_forms = {};
props.project.groups.forEach((group) => {
    tasks_forms[group.id] = useForm({
        name: "",
        group_id: group.id,
        unit: "",
        quantity: 0,
        price: 0,
    });
});

import CustomView from "@/Components/CustomView.vue";
import CustomInput from "@/Components/CustomInput.vue";
import ProjectDetails from "@/Components/ProjectDetails.vue";
import TasksList from "@/Components/TasksList.vue";
import GroupsList from "@/Components/GroupsList.vue";
import AddGroupForm from "@/Components/AddGroupForm.vue";
import AddTaskForm from "@/Components/AddTaskForm.vue";

onBeforeUpdate(() => {
    props.project.groups.forEach((group) => {
        tasks_forms[group.id] = useForm({
            name: "",
            group_id: group.id,
            unit: "",
            quantity: 0,
            price: 0,
        });
    });
});
onMounted(() => {});
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
                        Groups
                        <GroupsList :project="project" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import CustomView from "@/Components/CustomView.vue";
import TasksList from "./TasksList.vue";
import AddTaskForm from "./AddTaskForm.vue";
import _ from "lodash";

const props = defineProps({
    group: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <tr>
        <th>
            {{ group.name }}
        </th>
    </tr>
    <TasksList :tasks="group.tasks" />
    <tr>
        <th colspan="100%">
            <AddTaskForm :group-id="group.id" />
        </th>
    </tr>
    <tr>
        <th colspan="4">{{ group.name }} Total</th>
        <th>
            {{ Intl.NumberFormat("en-US").format(
                _.sumBy(group.tasks, (task) => task.price * task.quantity)
            ) }}
        </th>
    </tr>
</template>

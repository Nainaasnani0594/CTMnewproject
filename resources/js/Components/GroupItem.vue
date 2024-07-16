<script setup>
import CustomView from "@/Components/CustomView.vue";
import TasksList from "./TasksList.vue";
import AddTaskForm from "./AddTaskForm.vue";

const props = defineProps({
    group: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <tr>
        <td>
            <CustomView _label="Group Name" :_value="group.name" />
        </td>
    </tr>
    <TasksList :tasks="group.tasks" />
    <tr>
        <th colspan="100%">
            <AddTaskForm :group-id="group.id" />
        </th>
    </tr>
</template>
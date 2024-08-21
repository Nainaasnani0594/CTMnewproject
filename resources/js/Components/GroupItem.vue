<script setup>
import TasksList from "./TasksList.vue";
import _ from "lodash";
import { defineProps, ref, watch } from "vue";

const props = defineProps({
    group: {
        type: Object,
        required: true,
    },
    locks: {
        type: Array,
        required: true,
    },
    min: {
        type: String,
        required: true,
    },
    max: {
        type: String,
        required: true,
    },
});

const tasks = ref(props.group.tasks);
watch(() => props.group.tasks, (_) => {
    tasks.value = props.group.tasks;
});
</script>

<template>
    <tr>
        <th>
            {{ group.name }}
        </th>
    </tr>
    <TasksList :tasks="tasks" :locks="locks" :min="min" :max="max" />
    <tr>
        <th colspan="6">{{ group.name }} Total</th>
        <th>
            {{
                Intl.NumberFormat("en-US").format(
                    _.sumBy(group.tasks, (task) => task.price * task.quantity)
                )
            }}
        </th>
    </tr>
</template>

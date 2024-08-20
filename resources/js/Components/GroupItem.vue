<script setup>
import TasksList from "./TasksList.vue";
import _ from "lodash";

const props = defineProps({
    group: {
        type: Object,
        required: true,
    },
    locks: {
        type: Array,
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
    <TasksList :tasks="group.tasks" :locks="locks" />
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

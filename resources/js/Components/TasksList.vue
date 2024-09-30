<script setup>
import ActivitiesList from "@/Components/ActivitiesList.vue";
import { defineProps, watch, ref } from "vue";
import dayjs from "dayjs";
import _ from "lodash";
import { hasRole } from "@/util";
const props = defineProps({
    tasks: {
        type: Array,
        required: true,
    },
    locks: {
        type: Array,
        required: true,
    },
    auth: {
        type: Object,
        required: true,
    },
});
const tasks = ref(props.tasks);
watch(
    () => props.tasks,
    (_) => {
        tasks.value = props.tasks;
    }
);
const on_activity_updated = (updated_activity) => {
    const task_index = tasks.value.findIndex(
        (task) => task.id === updated_activity.task_id
    );
    const activity_index = tasks.value[task_index].activities.findIndex(
        (activity) => activity.id === updated_activity.id
    );
    tasks.value[task_index].activities[activity_index].value = Number(
        updated_activity.value
    );
};
const isLocked = (date) => {
    const lockEntry = props.locks.find((lock) =>
        dayjs(lock.date).isSame(dayjs(date), "month")
    );
    return lockEntry ? lockEntry.is_locked : false;
};
const sumActual = (activities) => {
    return _.sumBy(activities, (activity) =>
        isLocked(activity.date) ? activity.value : 0
    );
};
const sumTotal = (activities) => {
    return _.sumBy(activities, "value");
};
</script>
<template>
    <tr v-for="task in tasks" :key="task.id">
        <th>
            {{ task.name }}
        </th>
        <td>
            {{ task.unit }}
        </td>
        <td>
            {{ task.quantity }}
        </td>
        <td>
            {{ Intl.NumberFormat("en-US").format(task.price) }}
        </td>
        <td>
            {{ Intl.NumberFormat("en-US").format(task.price * task.quantity) }}
        </td>
        <ActivitiesList
            @updated="on_activity_updated($event)"
            :task="task"
            :locks="locks"/>
        <td>
            {{ sumActual(task.activities) }}
        </td>
        <td>
            {{task.quantity}}
        </td>
        <td>
            {{
                Intl.NumberFormat("en-US").format(
                    sumActual(task.activities) * task.price
                )
            }}
        </td>
        <td>
            {{
                sumActual(task.activities) >= task.quantity
                    ? "Task Done"
                    : "WIP"
            }}
        </td>
    </tr>
</template>

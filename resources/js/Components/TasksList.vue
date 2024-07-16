<script setup>
import CustomView from "@/Components/CustomView.vue";
import ActivitiesList from "@/Components/ActivitiesList.vue";
import { defineProps, onMounted } from "vue";
import dayjs from "dayjs";
import _ from "lodash";

const props = defineProps({
    tasks: {
        type: Array,
        required: true,
    },
});
onMounted(() => {
    console.log(props.tasks);
});
</script>

<template>
    <tr v-for="task in tasks" :key="task.id">
        <td>
            {{ task.name }}
        </td>
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
        <ActivitiesList :task="task" />
        <td>
            {{
                _.sumBy(task.activities, (activity) =>
                    dayjs(activity.date) < dayjs().startOf("month")
                        ? activity.value
                        : 0
                )
            }}
        </td>
        <td>
            {{ _.sumBy(task.activities, (activity) => activity.value) }}
        </td>
        <td>
            {{
                Intl.NumberFormat("en-US").format(
                    _.sumBy(task.activities, (activity) =>
                        dayjs(activity.date) < dayjs().startOf("month")
                            ? activity.value
                            : 0
                    ) * task.price
                )
            }}
        </td>
        <td>
            {{
                _.sumBy(task.activities, (activity) =>
                    dayjs(activity.date) < dayjs().startOf("month")
                        ? activity.value
                        : 0
                ) >= task.quantity
                    ? "Task Done"
                    : "WIP"
            }}
        </td>
    </tr>
</template>

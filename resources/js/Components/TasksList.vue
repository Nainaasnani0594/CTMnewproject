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
    min: {
        type: String,
        required: true,
    },
    max: {
        type: String,
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
    // update the value of activity using updated_activity in props.tasks
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

const updated_date = (task_id, start_or_end) => {
    const options = {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        url: route("tasks.update", task_id),
        data: {},
    };

    if (start_or_end === "start") {
        options.data.start_date = tasks.value.find(
            (task) => task.id === task_id
        ).start_date;
    } else {
        options.data.end_date = tasks.value.find(
            (task) => task.id === task_id
        ).end_date;
    }
    const task = tasks.value.find((task) => task.id === task_id);
    axios
        .request(options)
        .then((response) => {
            task = response.data.task;
        })
        .catch((error) => {
            console.error(error);
        });
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
            <input v-if="hasRole(['Admin', 'Super Admin'], auth.user)"
                type="date"
                class="input-primary input"
                v-model="task.start_date"
                @change="updated_date(task.id, 'start')"
                :min="min"
                :max="max"
            />
        </td>
        <td>
            <input v-if="hasRole(['Admin', 'Super Admin'], auth.user)"
                type="date"
                class="input-primary input"
                v-model="task.end_date"
                @change="updated_date(task.id, 'end')"
                :min="min < task.start_date ? task.start_date : min"
                :max="max"
            />
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
            :locks="locks"
        />
        <td>
            {{ sumActual(task.activities) }}
        </td>
        <td>
            {{ sumTotal(task.activities) }}
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

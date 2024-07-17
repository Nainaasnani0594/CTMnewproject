<script setup>
import CustomView from "@/Components/CustomView.vue";
import dayjs from "dayjs";
import { defineProps, defineEmits, ref } from "vue";
const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["updated"]);


const updated_activity = (activity_id) => {
    const options = {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        url: route("activities.update", activity_id),
        data: {
            value: activities.value[activity_id],
        },
    };

    axios
        .request(options)
        .then((response) => {
            console.log(response.data);
            emit("updated", response.data);
        })
        .catch((error) => {
            console.error(error);
        });
};

const activities = ref({});
props.task.activities.forEach((activity) => {
    activities.value[activity.id] = activity.value;
});
</script>
<template>
    <td class="p-0" v-for="activity in task.activities" :key="activity.id">
        <input
            type="text"
            v-model="activities[activity.id]"
            class="w-10 p-0 text-right pr-1"
            @change="updated_activity(activity.id)"
        />
    </td>
</template>

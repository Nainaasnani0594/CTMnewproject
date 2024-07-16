<script setup>
import GroupItem from "./GroupItem.vue";
import AddGroupForm from "./AddGroupForm.vue";
import dayjs from "dayjs";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th>Deliverables &amp; Tasks</th>
                    <th>UNIT</th>
                    <th>No. of Units</th>
                    <th>Unit Price</th>
                    <th>Total Task Value</th>
                    <th class="p-0" v-for="month in project.months" :key="month">
                        {{ dayjs(month).format("MMM-YY") }}
                    </th>
                    <th>Units Done</th>
                    <th>Units incl Forecast</th>
                    <th>Amount Done</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td class="px-0.5 text-xs" v-for="month in project.months" :key="month">
                        {{ dayjs(month) > dayjs().startOf('month') ? "Forecast" : "Actual" }}
                    </td>
                </tr>
                <GroupItem
                    v-for="group in project.groups"
                    :key="group.id"
                    :group="group"
                />
                <tr>
                    <th colspan="100%">
                        <AddGroupForm :project-id="project.id" />
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</template>

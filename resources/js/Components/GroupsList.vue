<script setup>
import GroupItem from "./GroupItem.vue";
import AddGroupForm from "./AddGroupForm.vue";

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
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
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

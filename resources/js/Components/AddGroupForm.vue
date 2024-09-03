<script setup>
import { useForm } from "@inertiajs/vue3";
import CustomInput from "@/Components/CustomInput.vue";
import { defineEmits, defineProps } from "vue";

const emit = defineEmits(["refresh"]);

const props = defineProps({
    projectId: {
        type: Number,
        required: true,
    },
});

const form = useForm({
    name: "",
    project_id: props.projectId,
});

const submit = () => {
    form.post(route("groups.store"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            form.reset();
            emit("refresh");
        },
    });
};
</script>

<template>
    <form class="mb-4 w-full max-w-xs" @submit.prevent="submit">
        <CustomInput
            _id="name"
            _label="Group Name"
            v-model="form.name"
            :error="form.errors.name"
            class="focus:border-blue-700 rounded"
            inputClass="w-full px-3 py-2"
        />
        <input type="hidden"
         name="project_id" 
        v-model="form.project_id"
         class="border-2 border-blue-500 rounded" 
        style="display: block;" />
        <input
            type="submit"
            class="bg-gray-400 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded max-w-xs w-full mt-4"
            value="Add Group"
        />

    </form>
</template>

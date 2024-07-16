<script setup>
import { useForm } from "@inertiajs/vue3";
import CustomInput from "@/Components/CustomInput.vue";

const props = defineProps({
    groupId: {
        type: Number,
        required: true,
    },
});

const form = useForm({
    name: "",
    group_id: props.groupId,
    unit: "",
    quantity: 0,
    price: 0,
});

const submit = () => {
    form.post(route("tasks.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <form class="flex items-center gap-2" @submit.prevent="submit">
        <CustomInput
            _id="name"
            _label="Task Name"
            v-model="form.name"
            :error="form.errors.name"
        />
        <CustomInput
            _id="unit"
            _label="Unit"
            v-model="form.unit"
            :error="form.errors.unit"
        />
        <CustomInput
            _id="quantity"
            _label="Quantity"
            v-model="form.quantity"
            :error="form.errors.quantity"
            _type="number"
        />
        <CustomInput
            _id="price"
            _label="Price"
            v-model="form.price"
            :error="form.errors.price"
            _type="number"
        />
        <input type="hidden" name="group_id" v-model="form.group_id" />
        <button class="btn btn-primary">Add Task</button>
    </form>
</template>

<script setup>
defineProps({
    _id: {
        type: String,
        required: true,
    },
    _label: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Number],
        required: true,
    },
    error: {
        type: String,
        required: false,
        default: "",
    },
    _type: {
        type: String,
        required: false,
        default: "text",
    },
});
</script>

<template>
    <label :for="_id" class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">{{ _label }}</span>
        </div>
        <input
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :id="_id"
            :name="_id"
            :type="_type"
            :placeholder="_label"
            class="input input-bordered input-primary w-full max-w-xs"
            :class="{
                'input-error': error,
            }"
        />
        <div class="label">
            <span v-if="error" class="label-text-alt text-error">{{
                error
            }}</span>
        </div>
    </label>
</template>

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
        type: String,
        required: true,
    },
    error: {
        type: String,
        required: false,
        default: "",
    },
});
</script>

<template>
    <label :for="_id" class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">
                {{ _label }}
            </span>
        </div>
        <select
            class="select select-primary select-bordered"
            :id="_id"
            :name="_id"
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            :class="{ 'border-red-500': error }"
        >
            <option value="" disabled selected>
                {{ _label }}
            </option>
            <slot />
        </select>
        <div class="label">
            <span v-if="error" class="label-text-alt text-error">{{
                error
            }}</span>
        </div>
    </label>
</template>

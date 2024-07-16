<script setup>
defineProps({
    _label: {
        type: String,
        required: true,
    },
    _value: {
        type: [String, Number],
        required: true,
    },
    _type: {
        type: String,
        required: false,
        default: "text",
    },
});
</script>

<template>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">{{ _label }}</span>
        </div>
        <input
            :value="_value"
            readonly
            :type="_type"
            class="input input-bordered input-primary w-full max-w-xs"
        />
    </label>
</template>

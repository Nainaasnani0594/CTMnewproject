<script setup>
const props = defineProps({
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
    isEditable: {
        type: Boolean,
        required: true,
        default: false,
    },
});
const emit = defineEmits(['update-value']); // Define an emit event for updating the value

const handleInput = (event) => {
  emit('update-value', event.target.value); // Emit the new value when the input changes
};

</script>
<template>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">{{ _label }}</span>
        </div>
        <input
            :value="_value"
            :readonly="!isEditable"
            :type="_type"
            @input="handleInput" 
      class="input input-bordered input-primary w-full max-w-xs"
        />
    </label>
</template>

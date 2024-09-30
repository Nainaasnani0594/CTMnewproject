<script setup>
import { computed, defineProps, defineEmits } from 'vue';

const props = defineProps({
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
    maxLength: {
        type: Number,
        required: false,
        default: null,
    },
});
const emit = defineEmits(['update:modelValue']);
const internalValue = computed({
get() {
        return props.modelValue;
    },
    set(value) {
        if (props._type === 'number') {
            value = value.replace(/[^0-9]/g, '');
            if (props.maxLength && value.length > props.maxLength) {
                value = value.slice(0, props.maxLength);
            }
            emit('update:modelValue', value);
        } else {
            emit('update:modelValue', value);
        }
    }
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
            }"/>
        <div class="label">
            <span v-if="error" class="label-text-alt text-error">{{
                error
            }}</span>
        </div>
    </label>
</template>

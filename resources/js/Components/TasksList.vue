<script setup>
import CustomView from "@/Components/CustomView.vue";

const props = defineProps({
    tasks: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <tr v-for="task in tasks" :key="task.id">
        <td>
            <CustomView _label="Task Name" :_value="task.name" />
        </td>
        <td>
            <CustomView _label="Unit" :_value="task.unit" />
        </td>
        <td>
            <CustomView
                _label="Quantity"
                :_value="task.quantity"
                _type="number"
            />
        </td>
        <td>
            <CustomView
                _label="Price"
                :_value="Intl.NumberFormat('en-US').format(task.price)"
            />
        </td>
        <td>
            <CustomView
                _label="Total Task Value"
                :_value="
                    Intl.NumberFormat('en-US').format(
                        task.price * task.quantity
                    )
                "
            />
        </td>
    </tr>
</template>

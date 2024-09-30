<script setup>
import { to_roman_numerical } from "@/util";
import CustomView from "@/Components/CustomView.vue";
import { defineProps, defineEmits } from "vue";
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    role: {
        type: String,
        required: true, 
    },
    isEditable: {
        type: Boolean,
        required: true,
        default: false,
    },
});
const emit = defineEmits(['update:project']);
const updatedProject = ref({ ...props.project });
const canEdit = ref(props.role === 'Admin');
// Function to emit an update event
const notifyChange = async () => {
    try {
        const response = await axios.put(`/projects/${updatedProject.value.id}`, updatedProject.value);
        emit('update:project', response.data.project);
        alert('Project updated successfully.');
    } catch (error) {
        console.error(error);
        alert('Failed to update project.');
    }
};
const handleInput = (field, value) => {
    updatedProject.value[field] = value;
};
</script>
<template>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Project Details
        </h2>
        <button v-if="canEdit" @click="notifyChange" class="btn btn-primary">Save</button>
    </div>
    <div class="grid grid-cols-3 gap-4">
        <CustomView _label="Sponsor Name" :_value="updatedProject.sponsor_name" :isEditable="isEditable" @input="handleInput('sponsor_name', $event.target.value)"/>
        <CustomView _label="Project Name" :_value="updatedProject.project_name" :isEditable="isEditable" @input="handleInput('project_name', $event.target.value)"/>
        <CustomView
            _label="Contract Holder Country"
            :_value="updatedProject.contract_holder_country"
            :isEditable="isEditable"
            @input="handleInput('contract_holder_country', $event.target.value)"/>
        <CustomView
            _label="Project Manager"
            :_value="project.project_manager"
            :isEditable="isEditable"
        />
        <CustomView _label="Currency" :_value="project.currency"/>
        <CustomView
            v-if="role !== 'Executive'"
            _label="Contract Value"
            :_value="Intl.NumberFormat('en-US').format(project.contract_value)"
            :isEditable="isEditable"/>
        <CustomView
            _label="Contract Signed"
            :_value="project.contract_signed ? 'Yes' : 'No'"/>
        <CustomView _label="Billing Type" 
        :_value="project.billing_type"
        :isEditable="isEditable"/>
        <CustomView
            _label="Activity Start Date"
            :_value="project.activity_start_date"
            _type="date"
            :isEditable="isEditable"/>
        <CustomView
            _label="Billing Start Date"
            :_value="project.billing_start_date"
            _type="date"
            :isEditable="isEditable"/>
        <CustomView
            _label="Clinical Duration"
            :_value="project.clinical_duration"
            _type="number"
            :isEditable="isEditable"/>
        <CustomView
            _label="Study Duration"
            :_value="project.study_duration"
            _type="number"
            :isEditable="isEditable"/>
        <CustomView
            _label="Patients"
            :_value="project.patients"
            _type="number"
            :isEditable="isEditable"/>
        <CustomView _label="Sites" 
        :_value="project.sites"
         _type="number"
         :isEditable="isEditable"/>
        <CustomView
            _label="Status"
            :_value="project.status ? 'Active' : 'Inactive'"/>
        <CustomView
            _label="Phase"
            :_value="to_roman_numerical(project.phase)"/>
        <CustomView
            _label="Therapeutic Area"
            :_value="project.therapeutic_area"/>
        <CustomView
            _label="Sponsor Country"
            :_value="project.sponsor_country"/>
    </div>
</template>

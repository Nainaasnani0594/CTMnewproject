<script setup>
import { to_roman_numerical } from "@/util";
import CustomView from "@/Components/CustomView.vue";
defineProps({
    project: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="grid grid-cols-3 gap-4">
        <CustomView _label="Sponsor Name" :_value="project.sponsor_name" />
        <CustomView _label="Project Name" :_value="project.project_name" />

        <CustomView
            _label="Contract Holder Country"
            :_value="project.contract_holder_country"
        />
        <CustomView
            _label="Project Manager"
            :_value="project.project_manager"
        />
        <CustomView _label="Currency" :_value="project.currency" />
        <CustomView
            _label="Contract Value"
            :_value="Intl.NumberFormat('en-US').format(project.contract_value)"
        />
        <CustomView
            _label="Contract Signed"
            :_value="project.contract_signed ? 'Yes' : 'No'"
        />
        <CustomView _label="Billing Type" :_value="project.billing_type" />
        <CustomView
            _label="Activity Start Date"
            :_value="project.activity_start_date"
            _type="date"
        />
        <CustomView
            _label="Billing Start Date"
            :_value="project.billing_start_date"
            _type="date"
        />
        <CustomView
            _label="Clinical Duration"
            :_value="project.clinical_duration"
            _type="number"
        />
        <CustomView
            _label="Study Duration"
            :_value="project.study_duration"
            _type="number"
        />
        <CustomView
            _label="Patients"
            :_value="project.patients"
            _type="number"
        />
        <CustomView _label="Sites" :_value="project.sites" _type="number" />
        <CustomView
            _label="Status"
            :_value="project.status ? 'Active' : 'Inactive'"
        />

        <CustomView
            _label="Phase"
            :_value="to_roman_numerical(project.phase)"
        />
        <CustomView
            _label="Therapeutic Area"
            :_value="project.therapeutic_area"
        />
        <CustomView
            _label="Sponsor Country"
            :_value="project.sponsor_country"
        />
    </div>
</template>

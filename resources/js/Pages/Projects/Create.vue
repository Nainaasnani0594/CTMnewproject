<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

import CustomInput from "@/Components/CustomInput.vue";
import CustomSelect from "@/Components/CustomSelect.vue";

import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

// List of countries
const countries = [
"Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Argentina", "India",
    "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City",
    "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"];

  // List of currencies
  const currencies = [
    { value: 'AFN', label: 'AFN' },
    { value: 'ALL', label: 'ALL' },
    { value: 'DZD', label: 'DZD' },
    { value: 'EUR', label: 'EUR' },
    { value: 'AOA', label: 'AOA' },
    { value: 'ARS', label: 'ARS' },
    { value: 'INR', label: 'INR'},
    { value: 'USD', label: 'USD'},
    { value: 'UYU', label: 'UYU' },
    { value: 'UZS', label: 'UZS' },
    { value: 'VUV', label: 'VUV' },
    { value: 'EUR', label: 'EUR' },
    { value: 'VES', label: 'VES' },
    { value: 'VND', label: 'VND' },
    { value: 'YER', label: 'YER' },
    { value: 'ZMW', label: 'ZMW' },
    { value: 'ZWL', label: 'ZWL' },

    // Add more currencies as needed
];
const billing_type = [
    { value: 'Activity Based', label: 'Activity Based' },
    { value: 'Monthly', label: 'Monthly' },
    { value: 'Milestone', label: 'Milestone' },
    { value: 'Monthly & Milestone', label: 'Monthly & Milestone' },
];
const form = useForm({
    sponsor_name: "",
    project_name: "",
    contract_holder_country: "",
    project_manager: "",
    currency: "",
    contract_value: "",
    contract_signed: "",
    billing_type: "",
    activity_start_date: "",
    billing_start_date: "",
    clinical_duration: "",
    study_duration: "",
    patients: "",
    sites: "",
    status: "",
    phase: "",
    therapeutic_area: "",
    sponsor_country: "",
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Project
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="form.post('/projects')"
                            class="grid grid-cols-3 gap-4"
                        >
                            <CustomInput
                                _id="sponsor_name"
                                _label="Sponsor Name"
                                v-model="form.sponsor_name"
                                :error="form.errors.sponsor_name"
                                @update:modelValue="form.sponsor_name = $event"
                            />
                            <CustomInput
                                _id="project_name"
                                _label="Project Name"
                                v-model="form.project_name"
                                :error="form.errors.project_name"
                                @update:modelValue="form.project_name = $event"
                            />


                            <!-- Contract Holder Country Dropdown -->
                        <div class="col-span-1">
                            <label for="contract_holder_country" class="block text-sm font-medium text-gray-500 line-height:1.25rem">
                                Contract Holder Country
                            </label>
                            <select
                                id="contract_holder_country"
                                v-model="form.contract_holder_country"
                                class= "input input-bordered input-primary w-full max-w-xs mt-4"
                                    >
                                <option disabled value="">Select Country</option>
                                <option v-for="country in countries" :key="country" :value="country">
                                    {{ country }}
                                </option>
                            </select>
                            <div v-if="form.errors.contract_holder_country" class="text-red-600 text-sm mt-1">
                                {{ form.errors.contract_holder_country }}
                            </div>
                        </div>

                            <CustomInput
                                _id="project_manager"
                                _label="Project Manager"
                                v-model="form.project_manager"
                                :error="form.errors.project_manager"
                                @update:modelValue="
                                    form.project_manager = $event
                                "
                            />


                            <!-- Currency Dropdown -->
                            <div class="col-span-1">
                                <label for="currency" class="block text-sm font-medium text-gray-500 line-height:1.25rem">
                                    Currency
                                </label>
                                <select
                                    id="currency"
                                    v-model="form.currency"
                                    class="input input-bordered input-primary w-full max-w-xs mt-4"
                                >
                                    <option disabled value="">Select Currency</option>
                                    <option v-for="currency in currencies" :key="currency.value" :value="currency.value">
                                        {{ currency.label }}
                                    </option>
                                </select>
                                <div v-if="form.errors.currency" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.currency }}
                                </div>
                            </div>


                            <CustomInput
                                _id="contract_value"
                                _label="Contract Value"
                                v-model="form.contract_value"
                                :error="form.errors.contract_value"
                                @update:modelValue="
                                    form.contract_value = $event
                                "
                                _type="number"
                            />
                            <CustomSelect
                                _id="contract_signed"
                                _label="Contract Signed"
                                v-model="form.contract_signed"
                                :error="form.errors.contract_signed"
                                @update:modelValue="
                                    form.contract_signed = $event
                                "
                            >
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </CustomSelect>
                            <div class="col-span-1">
                                <label for="billing_type" class="block text-sm font-medium text-gray-500">
                                    Billing Type
                                </label>
                                <select
                                    id="billing_type"
                                    v-model="form.billing_type"
                                    class="input input-bordered input-primary w-full max-w-xs mt-4"
                                >
                                    <option disabled value="">Select Billing Type</option>
                                    <option v-for="type in billing_type" :key="type.value" :value="type.value">
                                        {{ type.label }}
                                    </option>
                                </select>
                                <div v-if="form.errors.billing_type" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.billing_type }}
                                </div>
                            </div>


                            <CustomInput
                                _id="activity_start_date"
                                _label="Activity Start Date"
                                v-model="form.activity_start_date"
                                :error="form.errors.activity_start_date"
                                @update:modelValue="
                                    form.activity_start_date = $event
                                "
                                _type="date"
                            />
                            <CustomInput
                                _id="billing_start_date"
                                _label="Billing Start Date"
                                v-model="form.billing_start_date"
                                :error="form.errors.billing_start_date"
                                @update:modelValue="
                                    form.billing_start_date = $event
                                "
                                _type="date"
                            />
                            <CustomInput
                                _id="clinical_duration"
                                _label="Clinical Duration"
                                v-model="form.clinical_duration"
                                :error="form.errors.clinical_duration"
                                @update:modelValue="
                                    form.clinical_duration = $event
                                "
                                _type="number"
                            />
                            <CustomInput
                                _id="study_duration"
                                _label="Study Duration"
                                v-model="form.study_duration"
                                :error="form.errors.study_duration"
                                @update:modelValue="
                                    form.study_duration = $event
                                "
                                _type="number"
                            />
                            <CustomInput
                                _id="patients"
                                _label="Patients"
                                v-model="form.patients"
                                :error="form.errors.patients"
                                @update:modelValue="form.patients = $event"
                                _type="number"
                            />
                            <CustomInput
                                _id="sites"
                                _label="Sites"
                                v-model="form.sites"
                                :error="form.errors.sites"
                                @update:modelValue="form.sites = $event"
                                _type="number"
                            />
                            <CustomSelect
                                _id="status"
                                _label="Status"
                                v-model="form.status"
                                :error="form.errors.status"
                                @update:modelValue="form.status = $event"
                            >
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </CustomSelect>

                            <CustomInput
                                _id="phase"
                                _label="Phase"
                                v-model="form.phase"
                                :error="form.errors.phase"
                                @update:modelValue="form.phase = $event"
                                _type="number"
                            />
                            <CustomInput
                                _id="therapeutic_area"
                                _label="Therapeutic Area"
                                v-model="form.therapeutic_area"
                                :error="form.errors.therapeutic_area"
                                @update:modelValue="
                                    form.therapeutic_area = $event
                                "
                            />
                            <CustomInput
                                _id="sponsor_country"
                                _label="Sponsor Country"
                                v-model="form.sponsor_country"
                                :error="form.errors.sponsor_country"
                                @update:modelValue="
                                    form.sponsor_country = $event
                                "
                            />
                            <button
                                type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :disabled="form.processing"
                            >
                                Create Project
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

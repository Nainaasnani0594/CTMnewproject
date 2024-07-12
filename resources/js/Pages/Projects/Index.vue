<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

const to_roman_numerical = (number) => {
    const roman_numerals = {
        M: 1000,
        CM: 900,
        D: 500,
        CD: 400,
        C: 100,
        XC: 90,
        L: 50,
        XL: 40,
        X: 10,
        IX: 9,
        V: 5,
        IV: 4,
        I: 1,
    };

    let result = "";

    for (const key in roman_numerals) {
        const value = roman_numerals[key];
        result += key.repeat(Math.floor(number / value));
        number %= value;
    }

    return result;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Sponsor Name</th>
                                        <th>Project Name</th>
                                        <th>Contract Holder Country</th>
                                        <th>Project Manager</th>
                                        <th>Status</th>
                                        <th>Phase</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr v-for="(project, index) in projects">
                                        <th>{{ index + 1 }}</th>
                                        <td>{{ project.sponsor_name }}</td>
                                        <td>{{ project.project_name }}</td>
                                        <td>
                                            {{
                                                project.contract_holder_country
                                            }}
                                        </td>
                                        <td>{{ project.project_manager }}</td>
                                        <td>
                                            {{
                                                project.status
                                                    ? "Active"
                                                    : "Inactive"
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                to_roman_numerical(
                                                    project.phase
                                                )
                                            }}
                                        </td>
                                        <td>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-primary"
                                                >Edit</a
                                            >
                                            <a
                                                href="#"
                                                class="ml-2 btn btn-sm btn-error"
                                                >Delete</a
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

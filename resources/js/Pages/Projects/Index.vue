<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
      <template #header>
        <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
          <Link
            v-if="hasRole(['Admin', 'Super Admin'], auth.user)"
            :href="route('projects.create')"
            class="bg-gray-300 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Create Project
          </Link>
        </div>
      </template>
  
      <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <!-- Country dropdown filter -->
              <div class="mb-4">
                <label for="country" class="block text-sm font-medium text-gray-700">Select Country</label>
                <select v-model="selectedCountry" @change="filterProjectsByCountry" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                  <option value="">All Countries</option>
                  <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                </select>
              </div>
  
              <div v-if="filteredProjects.length === 0" class="text-center py-4">No projects exist.</div>
              <div v-else class="overflow-x-auto">
                <table class="table">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Sponsor Name</th>
                      <th @click="toggleFilter" class="cursor-pointer">Project Name</th>
                      <th>Contract Holder Country</th>
                      <th>Project Manager</th>
                      <th>Status</th>
                      <th>Phase</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(project, index) in filteredProjects" :key="project.id" :class="{'bg-gray-100': project.groups.length === 0}">
                      <th>{{ index + 1 }}</th>
                      <td>{{ project.sponsor_name }}</td>
                      <td>{{ project.project_name }}</td>
                      <td>{{ project.contract_holder_country }}</td>
                      <td>{{ project.project_manager }}</td>
                      <td>{{ project.status ? "Active" : "Inactive" }}</td>
                      <td>{{ to_roman_numerical(project.phase) }}</td>
                      <td class="flex gap-2">
                        <Link :href="route('projects.show', project.id)" class="btn btn-sm btn-primary">View</Link>
                        <button v-if="hasRole(['Admin', 'Super Admin'], auth.user)" @click="deleteProject(project.id)" class="btn btn-sm btn-error">Delete</button>
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
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { Head, Link, router } from "@inertiajs/vue3";
  import { ref, computed } from "vue";
  import { hasRole, to_roman_numerical } from "@/util";
  
  defineProps({
    projects: {
      type: Array,
      required: true,
    },
    auth: {
      type: Object,
      required: true,
    },
  });
  
  const selectedCountry = ref("");
  const showFilteredProjects = ref(false);
  
  // Toggle filter for projects without groups
  const toggleFilter = () => {
    showFilteredProjects.value = !showFilteredProjects.value;
  };
  
  // Delete project handler
  const deleteProject = (id) => {
    if (confirm("Are you sure you want to delete this project?")) {
      router.delete(route("projects.destroy", id));
    }
  };
  
  // Compute list of unique countries from projects
  const countries = computed(() => {
    const countrySet = new Set(projects.map(project => project.contract_holder_country));
    return Array.from(countrySet);
  });
  
  // Filter projects by country and project name
  const filteredProjects = computed(() => {
    return projects.filter(project => {
      const matchesCountry = !selectedCountry.value || project.contract_holder_country === selectedCountry.value;
      const matchesProjectName = !showFilteredProjects.value || project.groups.length === 0;
      return matchesCountry && matchesProjectName;
    });
  });
  
  // Filter projects by country using Inertia router
  const filterProjectsByCountry = () => {
    router.get(route('projects.index'), { country: selectedCountry.value }, {
      preserveState: true, // Keeps form data intact
      preserveScroll: true, // Prevents page from jumping to the top
    });
  };
  </script>
  
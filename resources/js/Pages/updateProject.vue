<template>
    <form @submit.prevent="submitForm">
      <!-- Example of using CustomView.vue for project_name -->
      <CustomView
        _label="Project Name"
        :_value="projectData.project_name"
        isEditable="true"
        @update-value="(value) => updateField('project_name', value)" 
      />
      <!-- Add more fields as needed -->
      <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import CustomView from '@/Components/CustomView.vue'; 
  
  const projectData = ref({
    sponsor_name: 'Example Sponsor',
    project_name: 'Example Project',
    // Add other fields here as necessary
  });
  
  const updateField = (field, value) => {
    projectData.value[field] = value;
  };
  
  const submitForm = () => {
    // Submit the form to the server (Laravel backend)
    // You can use axios or Inertia to submit the data to the backend
    // For example, using axios:
    // axios.put('/api/projects/{id}', projectData.value)
    //     .then(response => { ... })
    //     .catch(error => { ... });
  };
  </script>
  
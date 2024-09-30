<template>
  <div class="p-6">
    <div class="flex justify-center items-center">
      <h1 class="text-2xl font-bold mb-4">Sponsors Details</h1> </br>
      <select v-model="selectedSponsor" @change="fetchSponsorDetails" class="px-8 py-2 border rounded">
      <option value="" disabled>Sponsors List</option>
      <option v-for="sponsor in allSponsors" :key="sponsor" :value="sponsor">
        {{ sponsor }}
      </option>
    </select>
    <button @click="fetchSponsorDetails" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded">
      Show Sponsor Details
    </button>
        </div>
    <table v-if="selectedSponsorDetails" class="min-w-full bg-white border mt-6">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b text-left">Project Name</th>
          <th class="py-2 px-4 border-b text-left">Project Manager</th>
          <th class="py-2 px-4 border-b text-left">Contract Value</th>
          <th class="py-2 px-4 border-b text-left">Contract Holder Country</th>
          <th class="py-2 px-4 border-b text-left">Total Task Done</th>
          <th class="py-2 px-4 border-b text-left">Total Task Remain</th>
          <th class="py-2 px-4 border-b text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sponsor in selectedSponsorDetails" :key="sponsor.id">
          <td class="py-2 px-4 border-b">{{ sponsor.project_name }}</td>
          <td class="py-2 px-4 border-b">{{ sponsor.project_manager }}</td>
          <td class="py-2 px-4 border-b">{{ sponsor.contract_value }}</td> 
          <td class="py-2 px-4 border-b">{{(sponsor.contract_holder_country) }}</td>
          <td class="py-2 px-4 border-b">{{(sponsor.task_done)}}</td>
          <td class="py-2 px-4 border-b">{{(sponsor.task_remain)}}</td>
          <td class="py-2 px-4 border-b">
          <span v-if="sponsor.status === 'Done'" class="text-green-500">
            ✅ {{ sponsor.status }}
          </span>
          <span v-else>
            {{ sponsor.status }}
          </span>
        </td>
        </tr>
        <tr v-if="selectedSponsorDetails.length === 0">
          <td colspan="7" class="py-2 px-4 border-b text-center">No project data available</td>
        </tr>
      </tbody>
    </table>
    <SponsorGraph v-if="showChart" :data="graphData" />
  </div>
</template>
<script setup>
import {ref, onMounted } from 'vue';
import SponsorGraph from '../Components/SponsorGraph.vue';
const allSponsors = ref([]); 
const selectedSponsor = ref(''); 
const selectedSponsorDetails = ref([]);
const graphData = ref([]); 
const showChart = ref(false); 
const fetchSponsorDetails = async () => {
  if (selectedSponsor.value) {
    try {
      const response = await fetch(`/api/sponsors/${selectedSponsor.value}`);
      if (!response.ok) {
        throw new Error(`Error: ${response.statusText}`);
      }
      const data = await response.json();
      selectedSponsorDetails.value = data;

      const monthlyTaskData = selectedSponsorDetails.value.flatMap(sponsor => {
        return Object.entries(sponsor.monthly_task_done).map(([month, task_done]) => ({
          month,
          task_done,
          task_remain: sponsor.total_task_remain - task_done 
        }));
      });
      graphData.value = monthlyTaskData;
      showChart.value = true;
    } catch (error) {
      console.error(error);
    }
  }
};
onMounted(() => {
  fetch('/api/sponsors')
    .then(response => response.json())
    .then(data => {
      allSponsors.value = data;
    })
    .catch(error => {
      console.error('Error fetching sponsors:', error);
    });
});
</script>




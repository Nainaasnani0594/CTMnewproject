<template>
  <div class="p-6">
    <div class="flex justify-center items-center">
      <h1 class="text-2xl font-bold mb-4">Project Overview</h1>
      <button @click="showChart = !showChart" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded">
        {{ showChart ? 'Hide Overview Graph' : 'Show Overview Graph' }}
      </button>
        </div>
    <table class="min-w-full bg-white border" v-if="!showChart">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b text-left">Project Name</th>
          <th class="py-2 px-4 border-b text-left">Contract Value</th>
          <th class="py-2 px-4 border-b text-left">Work Done</th>
          <th class="py-2 px-4 border-b text-left">Total Task Done</th>
          <th class="py-2 px-4 border-b text-left">Country</th>
          <th class="py-2 px-4 border-b text-left">Phase</th>
          <th class="py-2 px-4 border-b text-left">Therapeutic Area</th>
          <th class="py-2 px-4 border-b text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="overview in overviews" :key="overview.id">
          <td class="py-2 px-4 border-b">{{ overview.project_name }}</td>
          <td class="py-2 px-4 border-b">{{(overview.contract_value) }}</td>
          <td class="py-2 px-4 border-b">{{(overview.work_done)}}</td>
          <td class="py-2 px-4 border-b">{{(overview.task_done)}}</td>
          <td class="py-2 px-4 border-b">{{ overview.country}}</td>
          <td class="py-2 px-4 border-b">{{ overview.phase}}</td>
          <td class="py-2 px-4 border-b">{{ overview.therapeutic_area}}</td>
          <td class="py-2 px-4 border-b">
            {{ overview.status === 'Done' ? 'Progressed' : 'In Progress'}}
          </td>
        </tr>
        <tr v-if="overviews.length === 0">
          <td colspan="7" class="py-2 px-4 border-b text-center">No project data available</td>
        </tr>
      </tbody>
    </table>
    <OverviewGraph v-if="showChart" :data="overviews" />
  </div>
</template>
<script setup>
import { defineProps, ref, onMounted } from 'vue';
import OverviewGraph from '../Components/OverviewGraph.vue';

const props = defineProps({
  overviews: {
    type: Array,
    required: true,
  },
});
const showChart = ref(false);
function formatCurrency(value) {
  return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(value);
}
onMounted(() => {
  console.log(props.overviews);
});
</script>

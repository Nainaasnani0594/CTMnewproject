<template>
  <div>
    <div id="barchart" style="width: 100%; height: 500px;"></div>
  </div>
</template>
<script setup>
import { ref, onMounted, watch, defineProps, nextTick } from 'vue';
import axios from 'axios';
const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
});
const barData = ref([]);
function loadGoogleCharts() {
  return new Promise((resolve, reject) => {
    if (window.google && window.google.charts) {
      resolve();
      return;
    }
    const script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://www.gstatic.com/charts/loader.js';
    script.onload = () => {
      google.charts.load('current', { packages: ['corechart'] });
      google.charts.setOnLoadCallback(resolve);
    };
    script.onerror = () => reject(new Error('Failed to load Google Charts'));
    document.head.appendChild(script);
  });
}
async function drawBarChart() {
  await nextTick(); 
  if (!window.google) {
    console.error('Google Charts library is not loaded.');
    return;
  }
  const data = google.visualization.arrayToDataTable(barData.value);
  const options = {
    title: 'Project Distribution',
    hAxis: { title: 'Contract Value', titleTextStyle: { color: '#333' } },
    vAxis: { title: 'Project', minValue: 0 },
    legend: { position: 'right', alignment: 'center' },
    tooltip: { trigger: 'selection' },
  };
  const chart = new google.visualization.ColumnChart(document.getElementById('barchart'));
  chart.draw(data, options);
}
watch(
  () => props.data,
  (newData) => {
    barData.value = [
      ['Project', 'Contract Value', 'Work Done', 'Total Task Done'],
      ...newData.map(item => [item.project_name, item.contract_value, item.work_done, item.task_done]),
    ];
    drawBarChart();
  },
  { immediate: true }
);
onMounted(async () => {
  await loadGoogleCharts();
  drawBarChart();
});
</script>
<style scoped>
</style>

<!-- resources/js/Components/OverviewPieChart.vue -->
<template>
    <div>
      <div id="piechart" style="width: 100%; height: 500px;"></div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, nextTick } from 'vue';
  
  const pieData = ref([]);
  
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
  
  async function drawPieChart() {
    await nextTick(); 
    if (!window.google) {
      console.error('Google Charts library is not loaded.');
      return;
    }
  
    const data = google.visualization.arrayToDataTable(pieData.value);
    const options = {
      title: 'Overall Projects Distribution',
      is3D: true,
      legend: { position: 'right', alignment: 'center' },
    };
  
    const chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }
  
  onMounted(async () => {
    await loadGoogleCharts();
    drawPieChart();
  });
  
  watch(
    () => props.data,
    (newData) => {
      pieData.value = [
        ['Category', 'Total'],
        ['Overall Projects', newData.projectsCount],
        ['Overall Contract Value', newData.totalContractValue],
        ['Work Done', newData.totalWorkDone],
      ];
      drawPieChart();
    },
    { immediate: true }
  );
  </script>
  
  <style scoped>
  </style>
  
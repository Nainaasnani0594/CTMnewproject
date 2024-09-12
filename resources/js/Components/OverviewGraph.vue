<template>
    <div>
      <div id="barchart" style="width: 45%; height: 500px; display: inline-block;"></div>
      <div id="piechart" style="width: 45%; height: 500px; display: inline-block;"></div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, watch, defineProps, nextTick } from 'vue';
  import axios from 'axios';
  
  // Define props to accept data from parent component
  const props = defineProps({
    data: {
      type: Array,
      required: true,
    }
  });
  
  // Reactive variables to hold chart data
  const pieData = ref([]);
  const barData = ref([]);
  
  // Function to load Google Charts library
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
  
  // Function to draw charts using the data
  async function drawCharts() {
    await nextTick(); // Ensure DOM is updated before drawing charts
  
    if (!window.google) {
      console.error('Google Charts library is not loaded.');
      return;
    }
  
    drawPieChart();
    drawBarChart();
  }
  
  // Function to draw the pie chart
  function drawPieChart() {
    const data = google.visualization.arrayToDataTable([
      ['Project', 'Contract Value'],
      ...pieData.value.map(item => [item.project_name, item.contract_value]),
    ]);
  
    const options = {
      title: 'Project Contract Values',
      pieSliceText: 'label',
      legend: { position: 'top', alignment: 'center' },
      tooltip: { trigger: 'selection' },
    };
  
    const chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }
  
  // Function to draw the vertical bar chart (Column Chart)
  function drawBarChart() {
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
  
  // Fetch data from API and update charts
  async function fetchData() {
    try {
      const response = await axios.get('/api/overview-data');
      const newData = response.data;
  
      pieData.value = newData.pieData;
      barData.value = [
        ['Project', 'Contract Value', 'Work Done'],
        ...newData.barData,
      ];
  
      drawCharts();
    } catch (error) {
      console.error('Failed to fetch data', error);
    }
  }
  
  // Watch for changes in props and update chart data
  watch(() => props.data, (newData) => {
    pieData.value = newData.map(item => ({
      project_name: item.project_name,
      contract_value: item.contract_value,
      status: item.status,
      phase: item.phase,
      country: item.country,
      work_done: item.work_done,
    }));
  
    barData.value = [
      ['Project', 'Contract Value', 'Work Done'],
      ...newData.map(item => [item.project_name, item.contract_value, item.work_done]),
    ];
  
    drawCharts();
  }, { immediate: true });
  
  // Load charts when component is mounted and fetch data from API
  onMounted(async () => {
    await loadGoogleCharts();
    await fetchData(); // Fetch data from API
  });
  </script>
  
  <style scoped>
  /* Add any styles if needed */
  </style>
  
  
  
  
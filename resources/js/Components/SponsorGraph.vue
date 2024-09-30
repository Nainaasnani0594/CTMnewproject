<template>
  <div id="barchart" style="width: 100%; height: 500px;"></div>
</template>
<script>
export default {
props: {
  data: Array
},
mounted() {
  this.loadGoogleCharts();
},
methods: {
  loadGoogleCharts() {
    if (typeof google !== 'undefined') {
      this.drawChart();
    } else {
      const script = document.createElement('script');
      script.src = 'https://www.gstatic.com/charts/loader.js';
      script.onload = () => {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(this.drawChart);
      };
      document.head.appendChild(script);
    }
  },
  drawChart() {
const data = new google.visualization.DataTable();
data.addColumn('string', 'Month');
data.addColumn('number', 'Task Done');
data.addColumn('number', 'Task Remaining');

this.data.forEach(item => {
  data.addRow([item.month, item.task_done, item.task_remain]);
});
const options = {
  title: 'Monthly Tasks Done and Remaining',
  hAxis: { title: 'Month' },
  vAxis: { title: 'Tasks' },
  legend: { position: 'top' },
  height: 400,
  colors: ['#1b9e77', '#d95f02'], 
};
const chart = new google.visualization.LineChart(document.getElementById('barchart'));
chart.draw(data, options);
}
}
}
</script>

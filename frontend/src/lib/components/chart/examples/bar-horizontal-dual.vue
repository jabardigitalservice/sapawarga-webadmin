<template>
  <e-horizontal-bar-chart
    :chartData="chartData"
    :options="options"
    :height="height"></e-horizontal-bar-chart>
</template>

<script>
  import EHorizontalBarChart from '../types/bar-horizontal'
  import { colors } from '../options'

  export default {
    components: { EHorizontalBarChart },
    props: {
      height: Number
    },
    data: function() {
      return {
        chartData: {
          labels: ['Vue', 'Angular', 'React', 'Ember'],
          datasets: [
            {
              label: 'One',
              backgroundColor: colors.green.string(),
              data: [35, 25, 40, 20]
            },
            {
              label: 'Two',
              backgroundColor: colors.blue.string(),
              data: [40, 15, 35, 30]
            }
          ]
        },
        options: {
          legend: {
            display: false
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true
                },
              }
            ],
            yAxes: [
              {
                categoryPercentage: 0.6,
                barPercentage: 0.8,
              }
            ]
          },
        }
      }
    }
  }
</script>

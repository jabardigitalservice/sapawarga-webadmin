<template>
  <e-bar-chart
    :chartData="data"
    :height="height"
    :options="options"></e-bar-chart>
</template>

<script>
  import EBarChart from '../types/bar'
  import { colors } from '../options'

  export default {
    components: { EBarChart },
    props: {
      height: {
        type: Number
      }
    },
    data: function() {
      return {
        data: {
          labels: ['Mon', 'Tue', 'Wed'],
          datasets: [
            {
              label: 'Bar',
              backgroundColor: colors.green.string(),
              borderColor: '#ffffff',
              data: [7, 10, 13]
            }
          ]
        },
        options: {
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true
                }
              }
            ],
            xAxes: [
              {
                categoryPercentage: 0.6,
                barPercentage: 0.4,
              }
            ]
          },
        }
      }
    }
  }
</script>

<template>
  <e-bar-chart
    :chartData="data"
    :height="height"
    :options="options"></e-bar-chart>
</template>

<script>
  import EBarChart from '../types/bar-horizontal'
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
              label: 'Horizontal Bar',
              backgroundColor: colors.green.string(),
              borderColor: '#ffffff',
              data: [13, 9, 5]
            }
          ]
        },
        options: {
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true
                }
              }
            ],
            yAxes: [
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

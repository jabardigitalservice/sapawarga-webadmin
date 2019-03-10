<template>
  <e-line-chart
    :chartData="data"
    :height="height"
    :options="options"></e-line-chart>
</template>

<script>
  import ELineChart from '../types/line'
  import { colors } from '../options'

  export default {
    components: { ELineChart },
    props: {
      height: {
        type: Number
      }
    },
    data: function() {
      return {
        data: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu'],
          datasets: [
            {
              label: 'Line',
              borderColor: colors.green.string(),
              backgroundColor: 'transparent',
              data: [3, 12, 3, 12]
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
          },
        }
      }
    }
  }
</script>

<template>
  <e-mixed-chart
    :chartData="data"
    :height="height"
    :options="options"></e-mixed-chart>
</template>

<script>
  import EMixedChart from '../types/mixed'
  import { colors } from '../options'

  export default {
    components: { EMixedChart },
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
              type: 'line',
              label: 'Line',
              borderColor: colors.red.string(),
              backgroundColor: 'transparent',
              data: [3, 12, 3, 12]
            },
            {
              type: 'bar',
              label: 'Bar',
              backgroundColor: colors.green.string(),
              borderColor: '#ffffff',
              data: [11, 8, 13, 6]
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

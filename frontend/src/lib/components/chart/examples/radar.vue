<template>
  <e-radar-chart
    :chartData="data"
    :height="height"
    :options="options"></e-radar-chart>
</template>

<script>
  import ERadarChart from '../types/radar'
  import { colors } from '../options'

  export default {
    components: { ERadarChart },
    props: {
      height: {
        type: Number
      }
    },
    data: function() {
      return {
        data: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
          datasets: [
            {
              label: 'Radar',
              borderColor: colors.green.opaquer(0.1).string(),
              backgroundColor: colors.green.fade(0.3).string(),
              data: [12.5, 12.5, 12.5, 12.5, 12.5, 12.5]
            }
          ]
        },
        options: {
          legend: {
            display: false
          },
          scale: {
            ticks: {
              beginAtZero: true
            }
          }
        }
      }
    }
  }
</script>

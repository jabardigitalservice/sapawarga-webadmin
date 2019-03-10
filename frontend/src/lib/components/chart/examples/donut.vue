<template>
  <e-donut-chart
    :chartData="data"
    :options="options"
    :height="height"></e-donut-chart>
</template>

<script>
  import EDonutChart from '../types/donut'
  import { colors } from '../options'

  export default {
    components: { EDonutChart },
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
              label: 'Donut',
              backgroundColor: colors.array(),
              hoverBorderColor: '#fff',
              data: [5, 10, 8]
            }
          ]
        },
        options: {
          legend: {
            position: 'bottom',
            labels: {
              usePointStyle: true,
              padding: 20
            }
          }
        }
      }
    }
  }
</script>

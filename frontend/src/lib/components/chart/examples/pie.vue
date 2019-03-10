<template>
  <e-pie-chart
    :chartData="data"
    :options="options"
    :height="height"></e-pie-chart>
</template>

<script>
  import EPieChart from '../types/pie'
  import { colors } from '../options'

  export default {
    components: { EPieChart },
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
              label: 'Pie',
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

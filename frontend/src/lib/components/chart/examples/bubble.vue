<template>
  <e-bubble-chart
    :chartData="data"
    :height="height"
    :options="options"></e-bubble-chart>
</template>

<script>
  import EBubbleChart from '../types/bubble'
  import { colors } from '../options'

  export default {
    components: { EBubbleChart },
    props: {
      height: {
        type: Number
      }
    },
    data: function() {
      return {
        data: {
          datasets: [
            {
              label: 'Bubble',
              backgroundColor: colors.green.string(),
              borderColor: '#ffffff',
              data: [
                { x: 3, y: 6, r: 5 },
                { x: 8, y: 4, r: 10 },
                { x: 4, y: 8, r: 3 },
                { x: 1, y: 5, r: 8 },
                { x: 2, y: 1, r: 12 },
                { x: 5, y: 3, r: 6 },
                { x: 3, y: 3, r: 5 },
                { x: 6, y: 6, r: 7 },
              ]
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
                ticks: {
                  beginAtZero: true
                }
              }
            ]
          },
        }
      }
    }
  }
</script>

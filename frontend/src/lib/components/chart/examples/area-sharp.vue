<template>
  <e-line-chart
    :chartData="chartData"
    :options="options"
    :height="height"></e-line-chart>
</template>

<script>
  import ELineChart from '../types/line'
  import { colors } from '../options'

  export default {
    components: { ELineChart },
    props: {
      height: Number,
      ticks: {
        type: Boolean,
        default: true
      }
    },
    data: function() {
      return {
        chartData: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
  				datasets: [
            {
              borderWidth: 1,
    					borderColor: colors.red.opaquer(0.1).string(),
    					backgroundColor: colors.red.fade(0.5).string(),
    					pointBackgroundColor: colors.red.opaquer(0.1).string(),
              radius: 0,
    					data: [-60, 20, -40, 40, -20, 60],
    					label: 'Dataset',
    					fill: 'origin'
    				}
          ]
        },
        options: {
          legend: {
            display: false
          },
          maintainAspectRatio: false,
    			spanGaps: false,
    			elements: {
    				line: {
    					tension: 0.000001
    				}
    			},
          scales: {
    				yAxes: [
              {
      					ticks: {
      						min: -80,
      						max: 80,
                  stepSize: 40,
                  padding: 10,
                  display: this.ticks
      					},
                gridLines: {
                  display: true,
                  color: 'rgba(0, 0, 0, 0.05)',
                  zeroLineColor: 'rgba(255, 146, 139, 0.8)',
                  drawTicks: false
                },
      				}
            ],
    				xAxes: [
              {
      					ticks: {
      						autoSkip: false
      					},
                gridLines: {
                  display: true,
                  color: 'rgba(0, 0, 0, 0.05)'
                }
      				}
            ]
    			}
        }
      }
    }
  }
</script>

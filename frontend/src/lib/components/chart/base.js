import { mixins } from 'vue-chartjs'
import { defaults } from 'elements/chart/options'

const baseComponent = {
  mixins: [mixins.reactiveProp],
  props: {
    options: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  mounted: function() {
    this.renderChart(this.chartData, Object.assign({}, defaults, this.options))
  }
}

export default function makeChart(chartType) {
  return Object.assign({}, baseComponent, {
    extends: chartType
  })
}

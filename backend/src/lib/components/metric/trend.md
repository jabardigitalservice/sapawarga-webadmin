# Metric `Trend`

The extension of the default [Metric](/?selectedKind=Components/Metric&selectedStory=Default) component with the chart of previous values.

<!-- STORY -->

### Usage
```html
<e-metric title="Income" :value="data[period][0] | formatNumber('$')" icon="fa-usd" icon-dark>
  <div class="d-flex justify-content-center mt-3">
    <div class="btn-group">
      <button
        v-for="field in Object.keys(data)"
        class="btn btn-sm btn-outline-secondary"
        :class="{ 'active': field == period }"
        @click="period = field">{{ field | capitalize }}</button>
    </div>
  </div>
  <div class="mt-3 position-relative">
    <e-line-chart
      :chart-data="chartData"
      :options="options"
      :height="51"></e-line-chart>
  </div>
</e-metric>
```
```js
import EMetric from 'elements/metric'
import ELineChart from 'elements/chart/types/line'

const data = {
  'day': {
    0: random(),
    1: random(),
    2: random(),
    3: random(),
    4: random(),
    5: random(),
  },
  'week': {
    0: random() * 7,
    1: random() * 7,
    2: random() * 7,
    3: random() * 7,
    4: random() * 7,
    5: random() * 7,
  },
  'month': {
    0: random() * 30,
    1: random() * 30,
    2: random() * 30,
    3: random() * 30,
    4: random() * 30,
    5: random() * 30,
  }
}

function random() {
  return Math.round(Math.random() * 10000)
}

const chartOptions = {
  legend: { display: false },
  tooltips: { enabled: false },
  layout: {
    padding: {
      left: 10,
      right: 10
    }
  },
  scales: {
    xAxes: [
      { display: false }
    ],
    yAxes: [
      { display: false }
    ]
  }
}

export default {
  components: { EMetric, ELineChart },
  data: function() {
    return {
      data,
      options: chartOptions,
      period: Object.keys(data)[0]
    }
  },
  computed: {
    chartData: function() {
      const dataset = this.data[this.period];
      return {
        labels: Object.keys(dataset),
        datasets: [
          {
            label: "Income Trend",
            backgroundColor: '#f5f6f8',
            borderColor: '#686e71',
            data: Object.keys(dataset).map((key) => dataset[key]),
            fill: 'start',
          }
        ]
      }
    }
  },
  filters: {
    capitalize: function(value) {
      // capitalize('abc')  ->  'Abc'
    },
    formatNumber: function(n, currency = '', a) {
      // formatNumber(1000)  ->  '1,000'
      // formatNumber(-1000, '$', 2)  ->  '-$1,000.00'
    }
  }
}
```

### Props

| Name      | Type     | Default      |
|-----------|----------|--------------|
| title     | String   | `'Metric'`   |
| value     | String   | `'0'`        |
| icon      | String   | -            |
| dark-icon | Boolean  | `false`      |

### Dependencies

| Name        | Install    |
|-------------|---------|
| [Chart.js](http://www.chartjs.org/) | `npm install chart.js --save` |
| [vue-chartjs](https://github.com/apertureless/vue-chartjs) | `npm install vue-chartjs --save` |

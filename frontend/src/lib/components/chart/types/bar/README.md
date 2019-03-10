# Chart `Bar`

For complete configuration notes, please, refer to the original [Chart.js - Bar](http://www.chartjs.org/docs/latest/charts/bar.html) documentation.

<!-- STORY -->

### Usage

```javascript
import EBarChart from 'elements/chart/types/bar'

const data = {
  labels: ['Mon', 'Tue', 'Wed'],
  datasets: [
    {
      label: 'Bar',
      backgroundColor: 'green',
      borderColor: 'white',
      data: [7, 10, 13]
    }
  ]
}

const options = {
  scales: {
    yAxes: [
      {
        ticks: {
          beginAtZero: true
        }
      }
    ]
  }
}
```
```html
<e-bar-chart
  :chartData="data"
  :options="options"></e-bar-chart>
```

### Props

| Name        | Type    | Default    |
|-------------|---------|------------|
| chart-data  | Object  | *required* |
| options     | Object  | `{}`       |
| width       | Number  | -          |
| height      | Number  | -          |

### Dependencies

| Name        | Install    |
|-------------|---------|
| [Chart.js](http://www.chartjs.org/) | `npm install chart.js --save` |
| [vue-chartjs](https://github.com/apertureless/vue-chartjs) | `npm install vue-chartjs --save` |

### See Also
- [Chart.js](http://www.chartjs.org/)
- [vue-chartjs](https://github.com/apertureless/vue-chartjs)

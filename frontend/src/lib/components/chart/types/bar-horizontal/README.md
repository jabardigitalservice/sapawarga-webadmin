# Chart `Horizontal Bar`

For complete configuration notes, please, refer to the original [Chart.js - Bar](http://www.chartjs.org/docs/latest/charts/bar.html) documentation.

<!-- STORY -->

### Usage

```javascript
import EHorizontalBarChart from 'elements/chart/types/bar-horizontal'

const data = {
  labels: ['Mon', 'Tue', 'Wed'],
  datasets: [
    {
      label: 'Horizontal Bar',
      backgroundColor: colors.green.string(),
      borderColor: '#ffffff',
      data: [13, 9, 5]
    }
  ]
}

const options = {
  scales: {
    xAxes: [
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
<e-horizontal-bar-chart
  :chartData="data"
  :options="options"></e-horizontal-bar-chart>
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

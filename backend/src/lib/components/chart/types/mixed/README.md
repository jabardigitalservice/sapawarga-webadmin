# Chart `Mixed`

For complete configuration notes, please, refer to the original [Chart.js - Mixed](http://www.chartjs.org/docs/latest/charts/mixed.html) documentation.

<!-- STORY -->

### Usage

```javascript
import EMixedChart from 'elements/chart/types/mixed'

const data = {
  labels: ['Mon', 'Tue', 'Wed', 'Thu'],
  datasets: [
    {
      type: 'line',
      label: 'Line',
      borderColor: 'red',
      backgroundColor: 'transparent',
      data: [3, 12, 3, 12]
    },
    {
      type: 'bar',
      label: 'Bar',
      backgroundColor: 'green',
      borderColor: '#ffffff',
      data: [11, 8, 13, 6]
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
<e-mixed-chart
  :chartData="data"
  :options="options"></e-mixed-chart>
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

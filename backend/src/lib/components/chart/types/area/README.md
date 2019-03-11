# Chart `Area`

Area charts are basically the Line charts with filled backgrounds. For complete configuration notes, please, refer to the original [Chart.js - Line](http://www.chartjs.org/docs/latest/charts/line.html) documentation.

<!-- STORY -->

### Usage

```javascript
import ELineChart from 'elements/chart/types/line'

const data = {
  labels: ['Mon', 'Tue', 'Wed', 'Thu'],
  datasets: [
    {
      label: 'Area',
      borderColor: 'white',
      borderWidth: 2,
      backgroundColor: 'green',
      pointRadius: 3,
      data: [3, 12, 3, 12]
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
<e-line-chart
  :chartData="data"
  :options="options"></e-line-chart>
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

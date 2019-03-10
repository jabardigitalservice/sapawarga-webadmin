# Chart `Pie`

For complete configuration notes, please, refer to the original [Chart.js - Doughnut and Pie](http://www.chartjs.org/docs/latest/charts/doughnut.html) documentation.

<!-- STORY -->

### Usage

```javascript
import EPieChart from 'elements/chart/types/pie'

const data = {
  labels: ['Mon', 'Tue', 'Wed'],
  datasets: [
    {
      label: 'Pie',
      backgroundColor: [ 'red', 'green', 'blue' ],
      hoverBorderColor: 'white',
      data: [5, 10, 8]
    }
  ]
}

const options = {
  legend: {
    position: 'bottom',
    labels: {
      usePointStyle: true,
      padding: 20
    }
  }
}
```
```html
<e-pie-chart
  :chartData="data"
  :options="options"></e-pie-chart>
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

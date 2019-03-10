# Chart `Radar`

For complete configuration notes, please, refer to the original [Chart.js - Radar](http://www.chartjs.org/docs/latest/charts/radar.html) documentation.

<!-- STORY -->

### Usage

```javascript
import ERadarChart from 'elements/chart/types/radar'

const data = {
  labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
  datasets: [
    {
      label: 'Radar',
      borderColor: 'green',
      backgroundColor: 'green',
      data: [12.5, 12.5, 12.5, 12.5, 12.5, 12.5]
    }
  ]
}

const options = {
  legend: {
    display: false
  },
  scale: {
    ticks: {
      beginAtZero: true
    }
  }
}
```
```html
<e-radar-chart
  :chartData="data"
  :options="options"></e-radar-chart>
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

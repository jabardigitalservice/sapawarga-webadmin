# Chart `Bubble`

For complete configuration notes, please, refer to the original [Chart.js - Bubble](http://www.chartjs.org/docs/latest/charts/bubble.html) documentation.

<!-- STORY -->

### Usage

```javascript
import EBubbleChart from 'elements/chart/types/bubble'

const data = {
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
}

const options = {
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
  }
}
```
```html
<e-bubble-chart
  :chartData="data"
  :options="options"></e-bubble-chart>
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

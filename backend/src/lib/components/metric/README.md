# Metric

A tiny component for displaying single values of the important parameters.

<!-- STORY -->

### Usage

```js
import EMetric from 'elements/metric'
```
```html
<e-metric title="Users"  value="3,200" icon="fa fa-users"></e-metric>
<e-metric title="Income" value="8,400" icon="fa fa-usd" dark-icon></e-metric>
```

### Props

| Name      | Type     | Default      |
|-----------|----------|--------------|
| title     | String   | `'Metric'`   |
| value     | String   | `'0'`        |
| icon      | String   | -            |
| dark-icon | Boolean  | `false`      |

### Slots

| Name      | Description |
|-----------|-------------|
| default   | Slot to display under the main content. |

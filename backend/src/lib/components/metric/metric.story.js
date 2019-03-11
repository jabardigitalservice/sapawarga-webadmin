import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import EMetric from 'elements/metric'
import EMetricTrend from 'elements/metric/examples/income-trend'

import defaultDocs from './README.md'
import trendDocs from './trend.md'

storiesOf('Components/Metric', module)
  .addDecorator(withDocsCustom(defaultDocs))
  .add('Default', () => ({
    components: { EMetric },
    template: `
      <div class="d-flex">
        <e-metric class="mr-3" title="Users" value="3,200" icon="fa-user"></e-metric>
        <e-metric class="" title="Income" value="8,400" icon="fa-usd" icon-dark></e-metric>
      </div>
    `
  }))

storiesOf('Components/Metric', module)
  .addDecorator(withDocsCustom(trendDocs))
  .add('With Trend', () => ({
    components: { EMetricTrend },
    template: `
      <div class="row">
        <div class="col-md-3">
          <e-metric-trend></e-metric-trend>
        </div>
      </div>
    `
  }))

import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import ELineChart from 'elements/chart/examples/line'
import EBarChart from 'elements/chart/examples/bar'
import EHorizontalBarChart from 'elements/chart/examples/bar-horizontal'
import EDonutChart from 'elements/chart/examples/donut'
import EPieChart from 'elements/chart/examples/pie'
import ERadarChart from 'elements/chart/examples/radar'
import EMixedChart from 'elements/chart/examples/mixed'
import EAreaChart from 'elements/chart/examples/area'
import EBubbleChart from 'elements/chart/examples/bubble'

import baseDocs from './README.md'
import lineDocs from './types/line/README.md'
import barDocs from './types/bar/README.md'
import horizontalBarDocs from './types/bar-horizontal/README.md'
import areaDocs from './types/area/README.md'
import donutDocs from './types/donut/README.md'
import pieDocs from './types/pie/README.md'
import radarDocs from './types/radar/README.md'
import bubbleDocs from './types/bubble/README.md'
import mixedDocs from './types/mixed/README.md'

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(baseDocs))
  .add('Base', () => ({
    components: { ELineChart, EBarChart, EHorizontalBarChart, EDonutChart, EPieChart, ERadarChart, EMixedChart, EAreaChart, EBubbleChart },
    template: `
      <div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Line Chart</h6>
                <e-line-chart :height="180"></e-line-chart>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Bar Chart</h6>
                <e-bar-chart :height="180"></e-bar-chart>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Donut Chart</h6>
                <e-donut-chart :height="180"></e-donut-chart>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Pie Chart</h6>
                <e-pie-chart :height="180"></e-pie-chart>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Radar Chart</h6>
                <e-radar-chart :height="180"></e-radar-chart>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Horizontal Bar</h6>
                <e-horizontal-bar-chart :height="180"></e-horizontal-bar-chart>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Mixed Chart</h6>
                <e-mixed-chart :height="180"></e-mixed-chart>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Area Chart</h6>
                <e-area-chart :height="180"></e-area-chart>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Bubble Chart</h6>
                <e-bubble-chart :height="180"></e-bubble-chart>
              </div>
            </div>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(lineDocs))
  .add('Line', () => ({
    components: { ELineChart },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-line-chart :height="180"></e-line-chart>
          </div>
        </div>
      </div>
    `
  }))

  storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(areaDocs))
  .add('Area', () => ({
    components: { EAreaChart },
    template: `
    <div class="row">
    <div class="col-md-4">
    <div class="card p-3">
    <e-area-chart :height="180"></e-area-chart>
    </div>
    </div>
    </div>
    `
  }))

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(barDocs))
  .add('Bar', () => ({
    components: { EBarChart },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-bar-chart :height="180"></e-bar-chart>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(horizontalBarDocs))
  .add('Horizontal Bar', () => ({
    components: { EHorizontalBarChart },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-horizontal-bar-chart :height="180"></e-horizontal-bar-chart>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(donutDocs))
  .add('Donut', () => ({
    components: { EDonutChart },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-donut-chart :height="180"></e-donut-chart>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(pieDocs))
  .add('Pie', () => ({
    components: { EPieChart },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-pie-chart :height="180"></e-pie-chart>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(radarDocs))
  .add('Radar', () => ({
    components: { ERadarChart },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-radar-chart :height="180"></e-radar-chart>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(bubbleDocs))
  .add('Bubble', () => ({
    components: { EBubbleChart },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-bubble-chart :height="180"></e-bubble-chart>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Chart', module)
  .addDecorator(withDocsCustom(mixedDocs))
  .add('Mixed', () => ({
    components: { EMixedChart },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-mixed-chart :height="180"></e-mixed-chart>
          </div>
        </div>
      </div>
    `
  }))

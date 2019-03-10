import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import EDatepickerDate from 'elements/datepicker/examples/date'
import EDatepickerInline from 'elements/datepicker/examples/inline'
import EDatepickerDatetime from 'elements/datepicker/examples/datetime'
import EDatepickerTime from 'elements/datepicker/examples/time'
import EDatepickerRange from 'elements/datepicker/examples/range'
import EDatepickerAddons from 'elements/datepicker/examples/addons'

import dateDocs from './README.md'
import inlineDocs from './types/inline/README.md'
import datetimeDocs from './types/datetime/README.md'
import timeDocs from './types/time/README.md'
import rangeDocs from './types/range/README.md'
import addonsDocs from './types/addons/README.md'

storiesOf('Components/Datepicker', module)
  .addDecorator(withDocsCustom(dateDocs))
  .add('Date', () => ({
    components: { EDatepickerDate },
    template: `
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="card p-3">
            <e-datepicker-date></e-datepicker-date>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Datepicker', module)
  .addDecorator(withDocsCustom(datetimeDocs))
  .add('Datetime', () => ({
    components: { EDatepickerDatetime },
    template: `
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="card p-3">
            <e-datepicker-datetime></e-datepicker-datetime>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Datepicker', module)
  .addDecorator(withDocsCustom(timeDocs))
  .add('Time', () => ({
    components: { EDatepickerTime },
    template: `
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="card p-3">
            <e-datepicker-time></e-datepicker-time>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Datepicker', module)
  .addDecorator(withDocsCustom(rangeDocs))
  .add('Range', () => ({
    components: { EDatepickerRange },
    template: `
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="card p-3">
            <e-datepicker-range></e-datepicker-range>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Datepicker', module)
  .addDecorator(withDocsCustom(inlineDocs))
  .add('Inline', () => ({
    components: { EDatepickerInline },
    template: `
      <div class="d-flex">
        <div class="card p-1">
          <e-datepicker-inline></e-datepicker-inline>
        </div>
      </div>
    `
  }))

storiesOf('Components/Datepicker', module)
  .addDecorator(withDocsCustom(addonsDocs))
  .add('Addons', () => ({
    components: { EDatepickerAddons },
    template: `
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="card p-3">
            <e-datepicker-addons></e-datepicker-addons>
          </div>
        </div>
      </div>
    `
  }))

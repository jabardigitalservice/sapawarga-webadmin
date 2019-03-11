import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import BasicTable from 'elements/table/examples/basic-table'
import AdvancedTable from 'elements/table/examples/advanced-table'

import basicDocs from './README.md'
import advancedDocs from './advanced.md'

storiesOf('Components/Table', module)
  .addDecorator(withDocsCustom(basicDocs))
  .add('Basic', () => ({
    components: { BasicTable },
    template: `
      <div class="row">
        <div class="col-md-8 col-lg-7 col-xl-5">
          <basic-table></basic-table>
        </div>
      </div>
    `
  }))

storiesOf('Components/Table', module)
  .addDecorator(withDocsCustom(advancedDocs))
  .add('Advanced', () => ({
    components: { AdvancedTable },
    template: `
      <div class="row">
        <div class="col-lg-10 col-xl-7">
          <advanced-table></advanced-table>
        </div>
      </div>
    `
  }))

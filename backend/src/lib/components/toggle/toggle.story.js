import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import EToggleDefault from 'elements/toggle/examples/default'

import defaultDocs from './README.md'

storiesOf('Components/Toggle', module)
  .addDecorator(withDocsCustom(defaultDocs))
  .add('Default', () => ({
    components: { EToggleDefault },
    template: `
      <div class="d-flex">
        <div class="card p-3">
          <e-toggle-default></e-toggle-default>
        </div>
      </div>
    `
  }))

import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import EPanelDefault from 'elements/panel/examples/default'
import EPanelActions from 'elements/panel/examples/actions'
import EPanelCustomHead from 'elements/panel/examples/custom-head'

import defaultDocs from './README.md'
import actionsDocs from './actions.md'
import customHeadDocs from './custom-head.md'

storiesOf('Components/Panel', module)
  .addDecorator(withDocsCustom(defaultDocs))
  .add('Default', () => ({
    components: { EPanelDefault },
    template: `
      <div class="row">
        <div class="col-md-4">
          <e-panel-default></e-panel-default>
        </div>
      </div>
    `
  }))

storiesOf('Components/Panel', module)
  .addDecorator(withDocsCustom(actionsDocs))
  .add('Actions', () => ({
    components: { EPanelActions },
    template: `
      <div class="row">
        <div class="col-md-4">
          <e-panel-actions></e-panel-actions>
        </div>
      </div>
    `
  }))

storiesOf('Components/Panel', module)
  .addDecorator(withDocsCustom(customHeadDocs))
  .add('Custom Head', () => ({
    components: { EPanelCustomHead },
    template: `
      <div class="row">
        <div class="col-md-4">
          <e-panel-custom-head></e-panel-custom-head>
        </div>
      </div>
    `
  }))

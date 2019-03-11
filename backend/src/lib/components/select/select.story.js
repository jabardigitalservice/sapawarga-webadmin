import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import ESelectSingle from 'elements/select/examples/single'
import ESelectMultiple from 'elements/select/examples/multiple'

import singleDocs from './README.md'
import multipleDocs from './multiple.md'

storiesOf('Components/Select', module)
  .addDecorator(withDocsCustom(singleDocs))
  .add('Single', () => ({
    components: { ESelectSingle },
    template: `
      <div class="row">
        <div class="col-md-4 col-xl-3">
          <e-select-single></e-select-single>
        </div>
      </div>
    `
  }))

storiesOf('Components/Select', module)
  .addDecorator(withDocsCustom(multipleDocs))
  .add('Multiple \\ Tags', () => ({
    components: { ESelectMultiple },
    template: `
      <div class="row">
        <div class="col-md-4 col-xl-3">
          <e-select-multiple></e-select-multiple>
        </div>
      </div>
    `
  }))

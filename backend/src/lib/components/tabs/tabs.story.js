import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import ETabs from 'elements/tabs'
import ETabsDefault from 'elements/tabs/examples/default'
import ETabsNested from 'elements/tabs/examples/nested'

import defaultDocs from './README.md'
import nestedDocs from './nested.md'

storiesOf('Components/Tabs', module)
  .addDecorator(withDocsCustom(defaultDocs))
  .add('Default', () => ({
    components: { ETabsDefault },
    template: `
      <e-tabs-default></e-tabs-default>
    `
  }))

storiesOf('Components/Tabs', module)
  .addDecorator(withDocsCustom(nestedDocs))
  .add('Nested', () => ({
    components: { ETabsNested },
    template: `
      <e-tabs-nested></e-tabs-nested>
    `
  }))

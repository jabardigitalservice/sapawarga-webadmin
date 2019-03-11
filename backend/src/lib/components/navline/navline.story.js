import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import ENavlineDefault from 'elements/navline/examples/default'
import ENavlineArrow from 'elements/navline/examples/arrow'

import defaultDocs from './README.md'
import arrowDocs from './arrow.md'

storiesOf('Components/Navline', module)
  .addDecorator(withDocsCustom(defaultDocs))
  .add('Default', () => ({
    components: { ENavlineDefault },
    template: `
      <e-navline-default></e-navline-default>
    `
  }))

storiesOf('Components/Navline', module)
  .addDecorator(withDocsCustom(arrowDocs))
  .add('Arrow', () => ({
    components: { ENavlineArrow },
    template: `
      <e-navline-arrow></e-navline-arrow>
    `
  }))

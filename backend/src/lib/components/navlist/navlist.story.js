import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import ENavlistDefault from 'elements/navlist/examples/default'
import ENavlistActiveBg from 'elements/navlist/examples/active-bg'
import ENavlistActiveBold from 'elements/navlist/examples/active-bold'

import defaultDocs from './README.md'
import activeBgDocs from './active-bg.md'
import activeBoldDocs from './active-bold.md'

storiesOf('Components/Navlist', module)
  .addDecorator(withDocsCustom(defaultDocs))
  .add('Default', () => ({
    components: { ENavlistDefault },
    template: `
      <e-navlist-default style="max-width: 175px"></e-navlist-default>
    `
  }))

storiesOf('Components/Navlist', module)
  .addDecorator(withDocsCustom(activeBgDocs))
  .add('Active Background', () => ({
    components: { ENavlistActiveBg },
    template: `
      <e-navlist-active-bg style="max-width: 265px"></e-navlist-active-bg>
    `
  }))

storiesOf('Components/Navlist', module)
  .addDecorator(withDocsCustom(activeBoldDocs))
  .add('Active Bold', () => ({
    components: { ENavlistActiveBold },
    template: `
      <e-navlist-active-bold style="max-width: 175px"></e-navlist-active-bold>
    `
  }))

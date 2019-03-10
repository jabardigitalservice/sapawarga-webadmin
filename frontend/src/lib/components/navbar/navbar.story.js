import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import ENavbarDefault from 'elements/navbar/examples/default'
import ENavbarNavCenter from 'elements/navbar/examples/nav-in-center'
import ENavbarBrandCenter from 'elements/navbar/examples/brand-in-center'

import defaultDocs from './README.md'
import navCenterDocs from './nav-in-center.md'
import brandCenterDocs from './brand-in-center.md'

storiesOf('Components/Navbar', module)
  .addDecorator(withDocsCustom(defaultDocs))
  .add('Default', () => ({
    components: { ENavbarDefault },
    template: `
      <e-navbar-default></e-navbar-default>
    `
  }))

storiesOf('Components/Navbar', module)
  .addDecorator(withDocsCustom(navCenterDocs))
  .add('Nav in the Center', () => ({
    components: { ENavbarNavCenter },
    template: `
      <e-navbar-nav-center></e-navbar-nav-center>
    `
  }))

storiesOf('Components/Navbar', module)
  .addDecorator(withDocsCustom(brandCenterDocs))
  .add('Brand in the Center', () => ({
    components: { ENavbarBrandCenter },
    template: `
      <e-navbar-brand-center></e-navbar-brand-center>
    `
  }))

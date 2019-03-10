import Vue from 'vue'
import { storiesOf } from '@storybook/vue'
import { withDocsCustom } from '.storybook/utils/readme'

import ESlider from 'elements/slider'
import ESliderSingle from 'elements/slider/examples/single'
import ESliderDouble from 'elements/slider/examples/double'

import singleDocs from './README.md'
import doubleDocs from './double.md'
import variantsDocs from './variants.md'

storiesOf('Components/Slider', module)
  .addDecorator(withDocsCustom(singleDocs))
  .add('Single', () => ({
    components: { ESliderSingle },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-slider-single></e-slider-single>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Slider', module)
  .addDecorator(withDocsCustom(doubleDocs))
  .add('Double', () => ({
    components: { ESliderDouble },
    template: `
      <div class="row">
        <div class="col-md-4">
          <div class="card p-3">
            <e-slider-double></e-slider-double>
          </div>
        </div>
      </div>
    `
  }))

storiesOf('Components/Slider', module)
  .addDecorator(withDocsCustom(variantsDocs))
  .add('Variants', () => ({
    components: { ESlider },
    template: `
      <div class="row w-100">
        <div class="col-md-3 mb-3">
          <div class="card p-2">
            <e-slider class="e-slider-primary" :value="50"></e-slider>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card p-2">
            <e-slider class="e-silder-secondary" :value="50"></e-slider>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card p-2">
            <e-slider class="e-slider-success" :value="50"></e-slider>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card p-2">
            <e-slider class="e-slider-info" :value="50"></e-slider>
          </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="card p-2">
            <e-slider class="e-slider-warning" :value="50"></e-slider>
          </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="card p-2">
            <e-slider class="e-slider-danger" :value="50"></e-slider>
          </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="card p-2">
            <e-slider class="e-slider-light" :value="50"></e-slider>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-2">
            <e-slider class="e-slider-dark" :value="50"></e-slider>
          </div>
        </div>
      </div>
    `
  }))

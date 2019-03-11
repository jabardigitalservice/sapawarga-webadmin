# Slider `Variants`

Custom slider element based on [vue-slider-component](https://github.com/NightCatSama/vue-slider-component) component.

<!-- STORY -->

### Usage
```js
import ESlider from 'elements/slider'

export default {
  components: { ESlider }
}
```
```html
<e-slider class="e-slider-primary" :value="50"></e-slider>
<e-slider class="e-slider-secondary" :value="50"></e-slider>
<e-slider class="e-slider-success" :value="50"></e-slider>
<e-slider class="e-slider-info" :value="50"></e-slider>
<e-slider class="e-slider-warning" :value="50"></e-slider>
<e-slider class="e-slider-danger" :value="50"></e-slider>
<e-slider class="e-slider-light" :value="50"></e-slider>
<e-slider class="e-slider-dark" :value="50"></e-slider>
```

### Props

| Name    | Type                                                | Default |
|---------|-----------------------------------------------------|---------|
| min     | Number                                              | `0`     |
| max     | Number                                              | `0`     |
| value   | String, Array                                       | `0`     |
| tooltip | String, Boolean. Can be 'hover', 'always' or false. | `hover` |

Please, see the full list of the available props in the original [documentation](https://github.com/NightCatSama/vue-slider-component#props).

### Dependencies

| Name        | Install    |
|-------------|---------|
| [vue-slider-component](https://github.com/NightCatSama/vue-slider-component) | `npm install vue-slider-component --save` |

### See Also
- [vue-slider-component](https://github.com/NightCatSama/vue-slider-component)

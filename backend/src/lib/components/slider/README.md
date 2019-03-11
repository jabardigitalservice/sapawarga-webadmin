# Slider `Single`

Custom slider element based on [vue-slider-component](https://github.com/NightCatSama/vue-slider-component) component.

<!-- STORY -->

### Usage
```js
import ESlider from 'elements/slider'

export default {
  components: { ESlider },
  data: function() {
    return {
      min: 0,
      max: 100,
      value: 50
    }
  }
}
```
```html
<e-slider
  :min="min"
  :max="max"
  :value="value"></e-slider>
```

### Props

| Name    | Type                                                | Default |
|---------|-----------------------------------------------------|---------|
| min     | Number                                              | `0`     |
| max     | Number                                              | `0`     |
| value   | String, Array                                       | `0`      |
| tooltip | String, Boolean. Can be 'hover', 'always' or false. | `hover` |

Please, see the full list of the available props in the original [documentation](https://github.com/NightCatSama/vue-slider-component#props).

### Dependencies

| Name        | Install    |
|-------------|---------|
| [vue-slider-component](https://github.com/NightCatSama/vue-slider-component) | `npm install vue-slider-component --save` |

### See Also
- [vue-slider-component](https://github.com/NightCatSama/vue-slider-component)

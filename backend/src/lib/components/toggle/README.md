# Toggle

Custom toggle element based on [vue-js-toggle-button](https://github.com/euvl/vue-js-toggle-button) component.

<!-- STORY -->

### Usage
```js
import EToggle from 'elements/toggle'

export default {
  components: { EToggle },
  data: function() {
    return {
      value: true
    }
  }
}
```
```html
<e-toggle :value.sync="value"></e-toggle>
```

### Props

| Name     | Type    | Default                                        |
|----------|---------|------------------------------------------------|
| value    | Boolean | `false`                                        |
| disabled | Boolean | `false`                                        |
| color    | Object  | `{ checked: '#59CD90', unchecked: '#adb5bd' }` |
| labels   | Object  | `{ checked: 'On', unchecked: 'Off' }`          |
| width    | Number  | `50`                                           |
| height   | Number  | `21`                                           |

### Dependencies

| Name        | Install    |
|-------------|---------|
| [vue-js-toggle-button](https://github.com/euvl/vue-js-toggle-button) | `npm install vue-js-toggle-button --save` |

### See Also
- [vue-js-toggle-button](https://github.com/euvl/vue-js-toggle-button)

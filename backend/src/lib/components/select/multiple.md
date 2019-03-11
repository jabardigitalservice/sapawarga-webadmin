# Select `Multiple \ Tags`

Custom select element based on [vue-multiselect](https://github.com/shentao/vue-multiselect) component.

<!-- STORY -->

### Usage
```js
import ESelect from 'elements/select'

export default {
  components: { ESelect },
  data: function() {
    return {
      options: ['One', 'Two', 'Three'],
      values: ['One', 'Two']
    }
  }
}
```
```html
<e-select
  :multiple="true"
  :options="options"
  :value.sync="values"
  placeholder="Tags"></e-select>
```

### Props

| Name        | Type    | Default |
|-------------|---------|---------|
| options     | Array   | -       |
| value       | -       | -       |
| placeholder | String  | -       |
| multiple    | Boolean | `false` |

### Dependencies

| Name        | Install    |
|-------------|---------|
| [vue-multiselect](https://github.com/shentao/vue-multiselect)| `npm install vue-multiselect --save` |

### See Also
- [vue-multiselect](https://github.com/shentao/vue-multiselect)

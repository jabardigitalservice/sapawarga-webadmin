# Datepicker `Time`

Date and time picker based on [Vue-flatPickr](https://github.com/ankurk91/vue-flatpickr-component) component. Its recommended to explore the original library [flatpickr](https://github.com/chmln/flatpickr) as well.

<!-- STORY -->

### Usage
```js
import EDatepickerTime from 'elements/datepicker/types/time'

export default {
  components: { EDatepickerTime },
  data: function() {
    return {
      time: null
    }
  }
}
```
```html
<e-datepicker-time :value.sync="time" placeholder="Time"></e-datepicker-time>
```

### Props

| Name        | Type                                                                         | Default |
|-------------|------------------------------------------------------------------------------|---------|
| config      | Object. See the original [Docs](https://chmln.github.io/flatpickr/options/). | -       |
| value       | instanceof Date, [ instanceof Date ], [ ] or null                            | -       |
| placeholder | String                                                                       | -       |

### Events

| Name         | Arguments                                               | Description                         |
|--------------|---------------------------------------------------------|-------------------------------------|
| update:value | `dates` [ instanceof Date ] - Array of selected dates. | Emits when Datepicker value changes. |

### Dependencies

| Name        | Install    |
|-------------|---------|
| [Vue-flatPickr](https://github.com/ankurk91/vue-flatpickr-component) | `npm install vue-flatpickr-component --save` |

### See Also
- [flatpickr](https://github.com/chmln/flatpickr)
- [Vue-flatPickr](https://github.com/ankurk91/vue-flatpickr-component)

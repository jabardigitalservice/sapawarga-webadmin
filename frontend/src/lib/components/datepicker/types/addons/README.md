# Datepicker `Addons`

Date and time picker based on [Vue-flatPickr](https://github.com/ankurk91/vue-flatpickr-component) component. Its recommended to explore the original library [flatpickr](https://github.com/chmln/flatpickr) as well.

<!-- STORY -->

### Usage
```js
import EDatepickerAddons from 'elements/datepicker/types/addons'

export default {
  components: { EDatepickerAddons },
  data: function() {
    return {
      date: new Date()
    }
  }
}
```
```html
<e-datepicker-addons
  :value.sync="date"
  prepend="fa fa-fw fa-calendar"
  placeholder="Addons"
  clear></e-datepicker-addons>
```

### Props

| Name        | Type                                                                         | Default |
|-------------|------------------------------------------------------------------------------|---------|
| config      | Object. See the original [Docs](https://chmln.github.io/flatpickr/options/). | -       |
| value       | instanceof Date, [ instanceof Date ], [ ] or null                            | -       |
| placeholder | String                                                                       | -       |
| prepend     | String                                                                       | -       |
| append      | String                                                                       | -       |
| clear       | Boolean                                                                      | -       |

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

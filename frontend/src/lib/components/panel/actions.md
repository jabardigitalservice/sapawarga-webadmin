# Panel `Actions`

A simple content container with some built-in options. Basically, the wrapper on the [Bootstrap - Card](http://getbootstrap.com/docs/4.0/components/card/) component.

<!-- STORY -->

### Usage

```js
import EPanel from 'elements/panel'
```
```html
<e-panel title="Panel Actions">
  <template slot="actions">
    <i class="fa fa-fw fa-edit"></i>
  </template>
  <p class="card-text">
    Some quick example text to build
    on the card title and make up the
    bulk of the card's content.
  </p>
</e-panel>
```

### Props

| Name     | Type    | Default |
|----------|---------|---------|
| title    | String  | -       |
| subtitle | String  | -       |
| no-head  | Boolean | `false` |

### Slots

| Name     | Description |
|----------|-------------|
| default  | The content to display. |
| title    | Custom content that replaces `title` and `subtitle` elements. |
| subtitle | Custom content that replaces `subtitle` element. |
| head     | The whole custom `.card-title` element that overrides `slot="actions"` too. |
| actions  | An optional content to place in the end of panel head. |

### See Also
- [Bootstrap - Card](http://getbootstrap.com/docs/4.0/components/card/)
- [Bootstrap-Vue - Card](https://bootstrap-vue.js.org/docs/components/card)

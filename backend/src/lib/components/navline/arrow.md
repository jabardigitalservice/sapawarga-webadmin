# Navline `arrow`

A variant of the [Navline](/?selectedKind=Components/Navline&selectedStory=Default) component with the decorative arrow.

<!-- STORY -->

### Usage

```js
import ENavline from 'elements/navline'
```
```html
<e-navline class="card px-2" arrow>
  <ul class="nav">
    <li class="nav-item active">
      <a href="" class="nav-link">
        <span>Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="" class="nav-link">
        <span>Bookmarks</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="" class="nav-link">
        <span>Messages</span>
      </a>
    </li>
  </ul>
</e-navline>
```

### Props

| Name  | Type    | Default |
|-------|---------|---------|
| arrow | Boolean | `false` |

### Slots

| Name    | Description |
|---------|-------------|
| default | The list of nav links. Should be a `.nav` element. |

### See Also
- [Navline - Default](/?selectedKind=Components/Navline&selectedStory=Default)

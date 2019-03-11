# Navlist

Vertical navigation component.

<!-- STORY -->

### Usage

```js
import ENavlist from 'elements/navlist'
```
```html
<div class="card px-3">
  <e-navlist>
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
      <li class="nav-item">
        <a href="" class="nav-link">
          <span>Settings</span>
        </a>
      </li>
    </ul>
  </e-navlist>
</div>
```

### Props

| Name        | Type    | Default |
|-------------|---------|---------|
| active-bg   | Boolean | `false` |
| active-bold | Boolean | `false` |

### Slots

| Name    | Description |
|---------|-------------|
| default | The list of nav links. Should be a `.nav` element. |

### See Also
- [Navlist - Active Background](/?selectedKind=Components/Navlist&selectedStory=Active Background)
- [Navlist - Active Bold](/?selectedKind=Components/Navlist&selectedStory=Active Bold)

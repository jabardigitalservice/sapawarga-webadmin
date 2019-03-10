# Navlist `active-bold`

A variant of the [Navlist](/?selectedKind=Components/Navlist&selectedStory=Default) component, whose active items has a bold font weight.

<!-- STORY -->

### Usage

```js
import ENavlist from 'elements/navlist'
```
```html
<div class="card p-3">
  <e-navlist active-bold>
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
- [Navlist - Default](/?selectedKind=Components/Navlist&selectedStory=Default)

# Navlist `active-bg`

A variant of the [Navlist](/?selectedKind=Components/Navlist&selectedStory=Default) component, whose active items has a colored background.

<!-- STORY -->

### Usage

```js
import ENavlist from 'elements/navlist'
```
```html
<!-- Icons & Labels -->
<div class="card p-3">
  <e-navlist active-bg>
    <ul class="nav">
      <li class="nav-item">
        <a href="" class="nav-link">
          <i class="fa fa-fw fa-home mr-1"></i>
          <span>Home</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="" class="nav-link">
          <i class="fa fa-fw fa-bookmark mr-1"></i>
          <span>Bookmarks</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="" class="nav-link">
          <i class="fa fa-fw fa-envelope mr-1"></i>
          <span>Messages</span>
          <span class="badge badge-light ml-1">4</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="" class="nav-link">
          <i class="fa fa-fw fa-cog mr-1"></i>
          <span>Settings</span>
        </a>
      </li>
    </ul>
  </e-navlist>
</div>
```
```html
<!-- Icons & Tooltips -->
<div class="card px-3">
  <e-navlist active-bg>
    <ul class="nav">
      <li class="nav-item" v-b-tooltip.hover.right="'Home'">
        <a href="" class="nav-link">
          <i class="fa fa-fw fa-home"></i>
        </a>
      </li>
      <li class="nav-item" v-b-tooltip.hover.right="'Bookmarks'">
        <a href="" class="nav-link">
          <i class="fa fa-fw fa-bookmark"></i>
        </a>
      </li>
      <li class="nav-item" v-b-tooltip.hover.right="'Messages'">
        <a href="" class="nav-link">
          <i class="fa fa-fw fa-envelope"></i>
        </a>
      </li>
      <li class="nav-item" v-b-tooltip.hover.right="'Settings'">
        <a href="" class="nav-link">
          <i class="fa fa-fw fa-cog"></i>
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
- [Navlist - Active Bold](/?selectedKind=Components/Navlist&selectedStory=Active Bold)
- [Navlist - Default](/?selectedKind=Components/Navlist&selectedStory=Default)

# Navbar `nav-in-center`

Variant of the [Navbar](/?selectedKind=Components/Navbar&selectedStory=Default) component with the centrally located navigation.

<!-- STORY -->

### Usage

```js
import ENavbar from 'elements/navbar'
```
```html
<e-navbar class="px-lg-4" :title="'TITLE'" nav-in-center>
  <div slot="brand">
    <router-link to="" class="e-logo mx-4">
      <span>Elements <small>stay simple</small></span>
    </router-link>
  </div>

  <div slot="collapse">
    <ul class="navbar-nav pt-3 pt-md-0">
      <li class="nav-item">
        <router-link to="" class="nav-link">Overview</router-link>
      </li>
      <li class="nav-item">
        <router-link to="" class="nav-link">Bootstrap</router-link>
      </li>
      <li class="nav-item">
        <router-link to="" class="nav-link">Pages</router-link>
      </li>
    </ul>
  </div>

  <div slot="actions">
    <router-link to="" class="btn btn-success">
      <i class="fa fa-user-circle"></i>
      <span class="d-none d-md-inline-block">Morty Smith</span>
    </router-link>
  </div>
</e-navbar>
```

### Props

| Name            | Type    | Default |
|-----------------|---------|---------|
| title           | String  |         |
| nav-in-center   | Boolean | `false` |
| brand-in-center | Boolean | `false` |

### Slots

| Name     | Description |
|----------|-------------|
| brand    | App brand (logo). |
| collapse | Content that hides on the small screens (usually, nav links). |
| actions  | Place for the additional active elements. |

### See Also
- [Bootstrap - Navbar](http://getbootstrap.com/docs/4.0/components/navbar/)

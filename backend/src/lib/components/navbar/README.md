# Navbar

The main navigation component. Based on and extended from the Bootstrap [Navbar](http://getbootstrap.com/docs/4.0/components/navbar/) component.

<!-- STORY -->

### Usage

```js
import ENavbar from 'elements/navbar'
```
```html
<e-navbar class="px-lg-4" :title="'TITLE'">
  <div slot="brand">
    <router-link to="" class="e-logo mx-4">
      <span>Elements <small>stay simple</small></span>
    </router-link>
  </div>

  <div slot="collapse" class="d-md-flex">
    <ul class="navbar-nav mr-auto py-3 py-md-0">
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
    <form class="form-inline d-md-none d-lg-flex">
      <div class="input-with-ico">
        <i class="input-ico fa fa-fw fa-search"></i>
        <input class="form-control form-control-rounded" type="search" placeholder="Search">
      </div>
    </form>
  </div>

  <div slot="actions">
    <ul class="navbar-nav flex-nowrap flex-row">
      <li class="nav-item d-none d-md-inline-block">
        <a class="nav-link" href="">
          <i class="fa fa-bell"></i>
        </a>
      </li>
      <b-nav-item-dropdown right>
        <template slot="text">
          <span class="d-none d-md-inline">Morty Smith</span>
          <span class="d-md-none fa fa-user-circle"></span>
        </template>
        <a class="dropdown-item d-md-none" href="">
          <div class="d-flex justify-content-between align-items-center">
            <span>Alerts</span>
            <span class="badge badge-danger">3</span>
          </div>
        </a>
        <a class="dropdown-item" href="">Profile</a>
        <a class="dropdown-item" href="">Settings</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="">Logout</a>
      </b-nav-item-dropdown>
    </ul>
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

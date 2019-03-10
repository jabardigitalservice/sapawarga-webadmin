# Tabs

Redesigned Bootstrap's [Tabs](http://getbootstrap.com/docs/4.0/components/navs/#tabs) component.

<!-- STORY -->

### Usage

```js
import ETabs from 'elements/tabs'
```
```html
<!-- As Tabs -->
<div class="card">
  <div class="card-body pt-2">
    <e-tabs>
      <b-tabs no-fade>
        <b-tab title="Home" active></b-tab>
        <b-tab title="Inbox <span class='badge badge-light ml-1'>2</span>"></b-tab>
        <b-tab title="Settings"></b-tab>
      </b-tabs>
    </e-tabs>
  </div>
</div>
```
```html
<!-- As Links -->
<div class="card">
  <div class="card-body pt-2">
    <e-tabs>
      <ul class="nav nav-tabs">
        <li class="nav-item active">
          <router-link to="" class="nav-link">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link to="" class="nav-link">
            Inbox <span class='badge badge-light ml-1'>2</span>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="" class="nav-link">Settings</router-link>
        </li>
      </ul>
    </e-tabs>
  </div>
</div>
```

### Props

| Name   | Type    | Default |
|--------|---------|---------|
| nested | Boolean | `false` |

### Slots

| Name    | Description |
|---------|-------------|
| default | Bootstrap's [`.nav-tab`](http://getbootstrap.com/docs/4.0/components/navs/#tabs) element or Bootstrap-Vue's [b-tabs](https://bootstrap-vue.js.org/docs/components/tabs) component. |

### See Also
- [Bootstrap - Tabs](http://getbootstrap.com/docs/4.0/components/navs/#tabs)
- [Bootstrap-Vue - b-tabs](https://bootstrap-vue.js.org/docs/components/tabs)

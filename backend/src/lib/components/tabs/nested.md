# Tabs `nested`

A variant of the [Tabs](/?selectedKind=Components/Tabs&selectedStory=Default) component with nested sub-navigation.

<!-- STORY -->

### Usage

```js
import ETabs from 'elements/tabs'
```
```html
<div class="card px-3">
  <e-tabs nested>
    <b-tabs no-fade>
      <b-tab title="Home" active>
        <ul class="nav">
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>My Profile</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>Friends</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>News</span>
            </router-link>
          </li>
        </ul>
      </b-tab>
      <b-tab title="Bookmarks">
        <ul class="nav">
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>Posts</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>People</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>Documents</span>
            </router-link>
          </li>
        </ul>
      </b-tab>
      <b-tab :title="`Messages <span class='badge badge-light ml-1'>2</span>`">
        <ul class="nav">
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>Inbox</span>
              <span class="badge badge-light">2</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>Sent</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="" class="nav-link">
              <span>Drafts</span>
            </router-link>
          </li>
        </ul>
      </b-tab>
    </b-tabs>
  </e-tabs>
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

<template>
  <div class="card p-3">
    <e-navlist>
      <ul class="nav">
        <li class="nav-item active">
          <a href="" class="nav-link" @click.prevent>
            <span>Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link" @click.prevent>
            <span>Bookmarks</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link" @click.prevent>
            <span>Messages</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link" @click.prevent>
            <span>Settings</span>
          </a>
        </li>
      </ul>
    </e-navlist>
  </div>
</template>

<script>
  import ENavlist from '../index'

  export default {
    components: { ENavlist }
  }
</script>

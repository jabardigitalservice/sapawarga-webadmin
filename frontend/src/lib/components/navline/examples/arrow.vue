<template>
  <div class="card px-2">
    <e-navline arrow>
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
      </ul>
    </e-navline>
  </div>
</template>

<script>
  import ENavline from '../index'

  export default {
    components: { ENavline }
  }
</script>

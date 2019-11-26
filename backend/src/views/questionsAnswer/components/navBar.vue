<template>
  <div>
    <nav style="padding: 0 20px; !important">
      <div class="nav-left-section">
        <img :src="avatar" class="avatar">&nbsp;
        <span class="welcome-message"><b>{{ name }}</b> </span>&nbsp;
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },
    avatar: {
      type: String,
      required: true
    }
  }
}
</script>

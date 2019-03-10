<template>
  <div class="e-panel card">
    <div class="card-body">
      <slot name="head">
        <div class="card-title" v-if="!noHead">
          <slot name="title">
            <h6 class="mr-2">
              <span>{{ title }}</span>
              <slot name="subtitle">
                <small class="px-1">{{ subtitle }}</small>
              </slot>
            </h6>
          </slot>
          <slot name="actions"></slot>
        </div>
      </slot>
      <slot></slot>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      title: {
        type: String
      },
      subtitle: {
        type: String
      },
      noHead: {
        type: Boolean,
        default: false
      }
    }
  }
</script>

<style lang="scss">
  @import "../../scss/bootstrap/variables";

  .e-panel {

    .card-title {
      display: flex;
      justify-content: space-between;

      h1, h2, h3, h4, h5, h6,
      .h1, .h2, .h3, .h4, .h5, .h6 {
        font-weight: bold;
        margin: 0;
      }

      small:empty {
        display: none;
      }
    }
  }
</style>

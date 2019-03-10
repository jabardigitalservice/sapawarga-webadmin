<template>
  <div class="e-metric card">
    <div class="card-body">
      <div class="e-metric__main">
        <span class="e-metric__ico fa-stack">
          <i class="fa fa-circle fa-stack-2x" :class="{ 'text-light': !iconDark }"></i>
          <i class="fa fa-stack-1x" :class="[ icon, iconDark ? 'fa-inverse' : '' ]"></i>
        </span>
        <div class="e-metric__text px-2">
          <span class="e-metric__value h5 m-0">{{ value }}</span>
          <div class="e-metric__title">
            <small class="text-muted">{{ title }}</small>
          </div>
        </div>
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        default: 'Metric'
      },
      value: {
        type: String,
        default: '0'
      },
      icon: {
        type: String
      },
      iconDark: {
        type: Boolean,
        default: false
      }
    }
  }
</script>

<style lang="scss">
  @import "../../scss/bootstrap/variables";

  .e-metric {
    &__main {
      display: flex;
      flex-flow: row nowrap;
      justify-content: center;
      align-items: center;
    }

    &__text {
      line-height: 1;
    }
  }
</style>

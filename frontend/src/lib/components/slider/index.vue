<script>
  import VSlider from 'vue-slider-component'

  export default {
    extends: VSlider,
    props: {
      tooltip: {
        default: 'hover'
      },
      height: {
        default: 4
      },
      width: {
        default: '100%'
      },
      dotSize: {
        default: 12
      }
    },
    data: function() {
      return {}
    }
  }
</script>

<style lang="scss">
  @import "../../scss/bootstrap/variables";

  .vue-slider-component {
    display: inline-block;
    vertical-align: middle;
    z-index: 2;

    .vue-slider {
      background: $gray-300;
    }

    .vue-slider-dot {
      background: map-get($theme-colors, 'secondary');
      box-shadow: 0 0 0px 3px rgb(255, 255, 255);
      z-index: 3;
    }

    .vue-slider-process {
      background-color: map-get($theme-colors, 'secondary');
      z-index: 0;
    }

    .vue-slider-tooltip {
      font-size: 75%;
      line-height: 1.2;
      padding: 2px 4px;
      border-radius: 2px;
      border: 1px solid map-get($theme-colors, 'secondary');
      background-color: map-get($theme-colors, 'secondary');
    }

    .vue-slider-tooltip-wrap.vue-slider-tooltip-top {
      top: -8px;

      .vue-slider-tooltip {
        &:before {
          border-width: 4px;
          bottom: -8px;
        }
      }
    }
    .vue-slider-tooltip-wrap.vue-slider-tooltip-bottom {
      bottom: -8px;

      .vue-slider-tooltip {
        &:before {
          border-width: 4px;
          top: -8px;
        }
      }
    }
  }

  @each $color, $value in $theme-colors {
    .e-slider-#{$color}.vue-slider-component {
      .vue-slider-dot {
        background: $value;
      }

      .vue-slider-process {
        background-color: $value;
      }

      .vue-slider-tooltip {
        border: 1px solid $value;
        background-color: $value;
      }
    }
  }
</style>

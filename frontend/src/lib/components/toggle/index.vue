<template>
  <toggle-button
    :value="state"
    :sync="true"
    :color="color"
    :labels="labels"
    :disabled="disabled"
    :speed="150"
    :width="width"
    :height="height"
    @change="update"></toggle-button>
</template>

<script>
  import Vue from 'vue'
  import ToggleButton from 'vue-js-toggle-button'
  Vue.use(ToggleButton)

  export default {
    props: {
      value: {
        type: Boolean,
        default: false
      },
      disabled: {
        type: Boolean,
        default: false
      },
      color: {
        type: Object,
        default: () => {
          return {
            checked: '#59CD90',
            unchecked: '#adb5bd'
          }
        }
      },
      labels: {
        type: Object,
        default: () => {
          return {
            checked: 'On',
            unchecked: 'Off'
          }
        }
      },
      width: {
        type: Number,
        default: 50
      },
      height: {
        type: Number,
        default: 21
      }
    },
    data: function() {
      return {
        state: this.value
      }
    },
    methods: {
      update: function(toggle) {
        this.$emit('update:value', toggle.value)
      }
    }
  }
</script>

<style lang="scss">
  .vue-js-switch {
    z-index: 0;
    margin: 0;
  }
</style>

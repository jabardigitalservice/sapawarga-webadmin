<template>
  <e-slider
    :min="min"
    :max="max"
    :value="value"></e-slider>
</template>

<script>
  import ESlider from '../index'

  export default {
    components: { ESlider },
    data: function() {
      return {
        min: 0,
        max: 100,
        value: 50
      }
    }
  }
</script>

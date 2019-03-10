<template>
  <e-slider
    :min="min"
    :max="max"
    :value="values"></e-slider>
</template>

<script>
  import ESlider from '../index'

  export default {
    components: { ESlider },
    data: function() {
      return {
        min: 0,
        max: 100,
        values: [25, 75]
      }
    }
  }
</script>

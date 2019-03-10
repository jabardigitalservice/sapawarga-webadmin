<template>
  <e-toggle :value.sync="value"></e-toggle>
</template>

<script>
  import EToggle from '../index'

  export default {
    components: { EToggle },
    data: function() {
      return {
        value: true
      }
    }
  }
</script>

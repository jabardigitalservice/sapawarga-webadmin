<template>
  <flat-pickr class="d-none" :config="options" :value.sync="date"></flat-pickr>
</template>

<script>
  import EDatepicker from '../../index'

  export default {
    extends: EDatepicker,
    data: function() {
      return {
        localDefaults: {
          inline: true
        }
      }
    }
  }
</script>

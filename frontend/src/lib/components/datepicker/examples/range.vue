<template>
  <e-datepicker-range :value.sync="dates" placeholder="Range"></e-datepicker-range>
</template>

<script>
  import EDatepickerRange from '../types/range'

  export default {
    components: { EDatepickerRange },
    data: function() {
      return {
        dates: []
      }
    }
  }
</script>

<template>
  <e-datepicker-datetime :value.sync="date" placeholder="Datetime"></e-datepicker-datetime>
</template>

<script>
  import EDatepickerDatetime from '../types/datetime'

  export default {
    components: { EDatepickerDatetime },
    data: function() {
      return {
        date: null
      }
    }
  }
</script>

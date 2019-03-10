<template>
  <e-datepicker :value.sync="date" placeholder="Date"></e-datepicker>
</template>

<script>
  import EDatepicker from '../index'

  export default {
    components: { EDatepicker },
    data: function() {
      return {
        date: null
      }
    }
  }
</script>

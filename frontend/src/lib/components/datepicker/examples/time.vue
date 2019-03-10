<template>
  <e-datepicker-time :value.sync="time" placeholder="Time"></e-datepicker-time>
</template>

<script>
  import EDatepickerTime from '../types/time'

  export default {
    components: { EDatepickerTime },
    data: function() {
      return {
        time: null
      }
    }
  }
</script>

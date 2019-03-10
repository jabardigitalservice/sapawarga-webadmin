<template>
  <e-datepicker-addons
    :value.sync="date"
    prepend="fa fa-fw fa-calendar"
    clear
    placeholder="Addons"></e-datepicker-addons>
</template>

<script>
  import EDatepickerAddons from '../types/addons'

  export default {
    components: { EDatepickerAddons },
    data: function() {
      return {
        date: new Date()
      }
    }
  }
</script>

<template>
  <e-select
    :options="options"
    :value.sync="value"
    placeholder="Single"
    ></e-select>
</template>

<script>
  import ESelect from '../index'

  export default {
    components: { ESelect },
    data: function() {
      return {
        options: ['One', 'Two', 'Three'],
        value: 'One'
      }
    }
  }
</script>

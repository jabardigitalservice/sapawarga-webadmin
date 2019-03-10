<template>
  <e-select
    :multiple="true"
    :options="options"
    :value.sync="values"
    placeholder="Tags"
    ></e-select>
</template>

<script>
  import ESelect from '../index'

  export default {
    components: { ESelect },
    data: function() {
      return {
        options: ['One', 'Two', 'Three'],
        values: ['One']
      }
    }
  }
</script>

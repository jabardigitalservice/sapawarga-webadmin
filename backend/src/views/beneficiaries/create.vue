<template>
  <detail :is-create="true" />
</template>
<script>
import detail from './detail'

export default {
  name: 'CreateForm',
  components: { detail }
}
</script>

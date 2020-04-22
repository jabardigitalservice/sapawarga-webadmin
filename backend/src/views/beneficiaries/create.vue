<template>
  <verification :is-create="true" />
</template>
<script>
import verification from './verification'

export default {
  name: 'CreateForm',
  components: { verification }
}
</script>

<template>
  <FormBroadcast :is-edit="false" />
</template>
<script>
import FormBroadcast from './components/FormBroadcast'

export default {
  name: 'CreateForm',
  components: { FormBroadcast }
}
</script>

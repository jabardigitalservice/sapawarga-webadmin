<template>
  <FormBroadcast :is-edit="true" />
</template>
<script>
import FormBroadcast from './components/FormBroadcast'

export default {
  name: 'EditForm',
  components: { FormBroadcast }
}
</script>

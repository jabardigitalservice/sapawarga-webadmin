<template>
  <FormPolling :is-edit="true" />
</template>
<script>
import FormPolling from './components/FormPolling'

export default {
  name: 'CreateForm',
  components: { FormPolling }
}
</script>

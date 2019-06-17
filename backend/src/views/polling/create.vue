<template>
  <FormPolling :is-edit="false" />
</template>
<script>
import FormPolling from './components/FormPolling'

export default {
  name: 'CreateForm',
  components: { FormPolling }
}
</script>

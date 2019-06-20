<template>
  <FormNotification :is-edit="false" />
</template>
<script>
import FormNotification from './components/FormNotification'

export default {
  name: 'CreateForm',
  components: { FormNotification }
}
</script>

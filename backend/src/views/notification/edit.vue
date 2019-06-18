<template>
  <FormNotification :is-edit="true" />
</template>
<script>
import FormNotification from './components/FormNotification'

export default {
  name: 'EditForm',
  components: { FormNotification }
}
</script>

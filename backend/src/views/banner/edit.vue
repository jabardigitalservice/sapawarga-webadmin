<template>
  <FormBanner :is-edit="true" />
</template>
<script>
import FormBanner from './components/FormBanner'

export default {
  name: 'CreateForm',
  components: { FormBanner }
}
</script>

<template>
  <FormBanner :is-edit="false" />
</template>
<script>
import FormBanner from './components/FormBanner'

export default {
  name: 'CreateForm',
  components: { FormBanner }
}
</script>

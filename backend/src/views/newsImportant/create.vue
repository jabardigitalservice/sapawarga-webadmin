<template>
  <FormNewsImportant :is-edit="false" />
</template>
<script>
import FormNewsImportant from './components/FormNewsImportant'

export default {
  name: 'CreateForm',
  components: { FormNewsImportant }
}
</script>

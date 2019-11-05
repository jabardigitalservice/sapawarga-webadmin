<template>
  <FormNewsImportant :is-edit="true" />
</template>
<script>
import FormNewsImportant from './components/FormNewsImportant'

export default {
  name: 'CreateForm',
  components: { FormNewsImportant }
}
</script>

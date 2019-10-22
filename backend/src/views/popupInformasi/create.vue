<template>
  <FormPopUp :is-edit="false" />
</template>
<script>
import FormPopUp from './components/FormPopUp'

export default {
  name: 'CreateForm',
  components: { FormPopUp }
}
</script>

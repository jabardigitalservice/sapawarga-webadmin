<template>
  <FormPopUp :is-edit="true" />
</template>
<script>
import FormPopUp from './components/FormPopUp'

export default {
  name: 'EditForm',
  components: { FormPopUp }
}
</script>

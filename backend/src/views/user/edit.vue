<template>
  <div>
    <FormUser :is-edit="true" />
  </div>

</template>

<script>
import FormUser from './components/FormUser'

export default {
  name: 'EditForm',
  components: { FormUser }
}
</script>


<template>
  <div>
    <FormUser :is-edit="true" :is-profile="true" />
  </div>

</template>

<script>
import FormUser from '../user/components/FormUser'

export default {
  name: 'EditForm',
  components: { FormUser }
}
</script>


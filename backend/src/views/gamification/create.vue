<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">{{ $t('route.gamification-create') }}</a></p>
    <Form />
  </div>
</template>

<script>
import Form from './components/FormGamification'

export default {
  components: { Form }
}
</script>

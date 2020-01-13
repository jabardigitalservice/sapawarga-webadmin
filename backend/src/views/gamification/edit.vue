<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">Ubah Gamification</a></p>
    <Form :is-edit="true" />
  </div>
</template>

<script>
import Form from './components/FormGamification'

export default {
  components: { Form }
}
</script>

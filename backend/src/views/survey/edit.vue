<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">Edit Survei</a></p>
    <Form :is-edit="true" />
  </div>
</template>

<script>
import Form from './components/FormSurvey'

export default {
  components: { Form }
}
</script>

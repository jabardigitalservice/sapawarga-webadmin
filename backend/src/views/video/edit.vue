<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">Edit Video</a></p>
    <Form :is-edit="true" />
  </div>
</template>

<script>
import Form from './components/FormVideo'

export default {
  components: { Form }
}
</script>

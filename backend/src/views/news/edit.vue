<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">Edit Berita</a></p>
    <Form :is-edit="true" />
  </div>
</template>

<script>
import Form from './components/FormNews'

export default {
  components: { Form }
}
</script>

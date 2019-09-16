<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">Tambah Kategori</a></p>
    <Form :is-edit="true" />
  </div>
</template>

<script>
import Form from './components/Form'

export default {
  components: { Form }
}
</script>

<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">{{ $t('label.add-news-counter-hoax') }}</a></p>
    <Form />
  </div>
</template>

<script>
import Form from './components/Form'

export default {
  components: { Form }
}
</script>

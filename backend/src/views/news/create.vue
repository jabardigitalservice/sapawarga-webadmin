<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">{{ $t('news.news-add-header') }}</a></p>
    <Form />
  </div>
</template>

<script>
import Form from './components/FormNews'

export default {
  components: { Form }
}
</script>

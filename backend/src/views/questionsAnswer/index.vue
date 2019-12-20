<template>
  <div>
    <QuestionsList />
  </div>
</template>

<script>

import QuestionsList from './components/questionsList'

export default {
  components: {
    QuestionsList
  },
  props: {
    roleId: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      listMessage: [],
      message: ''
    }
  },
  async created() {
    //
  },
  methods: {
    //
  }
}
</script>

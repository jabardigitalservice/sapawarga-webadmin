<template>
  <div>
    <QuestionsList
      :list-user="listUser"
    />
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
      listUser: null,
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

<template>
  <div>
    <el-row :gutter="20">
      <QuestionsList
        :list-user="listUser"
      />
    </el-row>
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

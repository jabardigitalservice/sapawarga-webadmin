<template>
  <div class="app-container">
    <el-row :gutter="20">
      <QuestionsList
        :list-user="listUser"
      />
    </el-row>
  </div>
</template>

<script>
// import UserList from './components/userList'
// import MessageInput from './components/messageInput'
// import MessageBox from './components/messageBox'
import QuestionsList from './components/questionsList'

export default {
  components: {
    // MessageInput,
    // MessageBox,
    // UserList,
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

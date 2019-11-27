<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :lg="8" :sm="8" :xs="8">
        <UserList
          :list-user="listUser"
        />
      </el-col>
      <el-col :lg="16" :sm="16" :xs="16">
        <MessageBox />
        <MessageInput :value="message" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import UserList from './components/userList'
import MessageInput from './components/messageInput'
import MessageBox from './components/messageBox'

export default {
  components: {
    MessageInput,
    MessageBox,
    UserList
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

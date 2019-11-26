<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :lg="8" :sm="8" :xs="8" >
        <UserList :list-user="listUser"/>
      </el-col>
      <el-col :lg="16" :sm="16" :xs="16" >
        <MessageBox />
        <MessageInput :value="this.message" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import UserList from './components/userList'
import MessageInput from './components/messageInput'
import MessageBox from './components/messageBox'
import request from '@/utils/request'

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
      listUser: [],
      listMessage: [],
      message: '',
    }
  },

  created() {
    //
  },

  methods: {
    getInitialUsers () {
      for (var i = 0; i < 10; i++) {
        return request({
          url: 'https://randomuser.me/api/',
          method: 'get'
        })
        .then(response => {
          this.listUser.push(response.results[0])
        });
      }
    }
  },
  beforeMount() {
    this.getInitialUsers();
  }
}
</script>

<template>
  <div>
    <el-row :gutter="20">
      <div>
        <MessageBox
          :list-message="listMessage"
        />
        <MessageInput
          :value="message"
        />
      </div>
    </el-row>
  </div>
</template>

<script>

import MessageBox from './components/messageBox'
import MessageInput from './components/messageInput'
import router from '@/router'

export default {
  components: {
    MessageBox,
    MessageInput
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

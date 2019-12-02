<template>
  <div>
    <el-row :gutter="20" class="container">
      <nav-bar :name="name" :avatar="avatar" />
      <div class="chat">
        <div class="chat-page">
          <div class="msg-inbox">
            <div id="chats" class="chats">
              <div id="msg-page" class="msg-page">
                <div
                  v-if="loadingMessages"
                  class="loading-messages-container"
                >
                  <spinner :size="100" />
                  <span class="loading-text">
                    Loading Messages
                  </span>
                </div>
                <div v-else-if="!listMessage.length" class="text-center img-fluid empty-chat">
                  <div>
                    <img src="@/assets/emptyMessage.svg" class="img-res" alt="empty chat image">
                  </div>
                </div>
                <div v-else>
                  <div v-for="message in listMessage" :key="message.id">
                    <MessageItem :message="message" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </el-row>
  </div>
</template>

<script>
import navBar from './navBar'
import MessageItem from './messageItem'
import { mapGetters } from 'vuex'

export default {
  components: {
    MessageItem,
    navBar
  },
  props: {
    listMessage: {
      type: Array,
      required: false,
      default: function() { return [] }
    },
    loadingMessages: {
      type: Boolean,
      required: false
    }
  },
  data() {
    return {
      message: '',
      name: 'Isi Dengan Pertanyaan'
    }
  },
  computed: {
    ...mapGetters(['avatar'])
  }
}
</script>

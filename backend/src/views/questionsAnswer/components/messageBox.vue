<template>
  <div>
    <nav-bar
      :title="detailQuestions"
      :avatar="avatar"
    />
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
                  <MessageItem
                    :message="message"
                    :userId="user_id"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
    detailQuestions: {
      type: String,
      required: false,
    },
    loadingMessages: {
      type: Boolean,
      required: false
    }
  },
  data() {
    return {
      message: '',
    }
  },
  async created() {
    //
  },
  computed: {
    ...mapGetters(['user_id','avatar'])
  }
}
</script>

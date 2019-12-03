<template>
  <div>
    <nav-bar
      :avatar="avatar"
    />
    <el-card shadow="always">
      <el-row class="message-containers">
        <el-col :lg="2" :sm="2" :xs="2">
          <div>
            <div class="img-container">
              <img src="@/assets/user.png" alt="" class="avatar">&nbsp;
            </div>
          </div>
        </el-col>
        <el-col :lg="22" :sm="22" :xs="22" class="message-content">
          <div class="message-containers" style="margin-top: 16px;">
            <div class="username">
              <span class="user-name">Budi, RW 002 Desa Kertayasa Cijulang</span>
            </div>
            <div class="datetime">
              <span class="date-last-message">22/06/2019</span>
              <div class="img-like">
                <span class="el-tag el-tag--primary el-tag--medium" style="height: 25px;">{{ totalLikesQuestions }}</span>
                <img src="@/assets/like.svg" alt="" class="like-icon">
              </div>
            </div>
            <div class="last-messages">
              <span>{{ detailQuestions }}</span>
            </div>
          </div>
        </el-col>
      </el-row>
    </el-card>
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
                    :user-id="user_id"
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
      required: true
    },
    totalLikesQuestions: {
      type: Number,
      required: true
    },
    loadingMessages: {
      type: Boolean,
      required: false
    }
  },
  computed: {
    ...mapGetters(['user_id', 'avatar'])
  },
  async created() {
    //
  }
}
</script>

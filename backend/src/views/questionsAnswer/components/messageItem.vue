<template>
  <div>
    <div v-if="message.created_by != userId" class="received-chats">
      <div class="received-chats-img">
        <img src="@/assets/user.png" alt="" class="avatar">
      </div>
      <div class="received-msg">
        <div class="received-msg-inbox">
          <p><span>{{ message.user_name }}</span><br>{{ message.text }}</p>
        </div>
      </div>
    </div>
    <div v-else class="outgoing-chats">
      <div class="outgoing-chats-msg">
        <p>{{ message.text }}</p>
      </div>
      <div class="outgoing-chats-img">
        <img src="@/assets/user.png" alt="" class="avatar">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: Object,
      required: true
    },
    userId: {
      type: Number,
      required: true
    }
  },
}
</script>

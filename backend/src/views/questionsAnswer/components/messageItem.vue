<template>
  <div>
    <div v-if="message.sender.uid != uid" class="received-chats">
      <div class="received-chats-img">
        <img :src="message.sender.avatar" alt="" class="avatar">
      </div>
      <div class="received-msg">
        <div class="received-msg-inbox">
          <p><span>{{ message.sender.uid }}</span><br>{{ message.data.text }}</p>
        </div>
      </div>
    </div>
    <div v-else class="outgoing-chats">
      <div class="outgoing-chats-msg">
        <p>{{ message.data.text }}</p>
      </div>
      <div class="outgoing-chats-img">
        <img :src="message.sender.avatar" alt="" class="avatar">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: Array,
      required: true
    }
  },
  methods: {

  }
}
</script>

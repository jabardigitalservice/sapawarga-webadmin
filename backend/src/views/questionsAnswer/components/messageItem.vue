<template>
  <div>
    <div class="received-chats" v-if="message.sender.uid != uid">
      <div class="received-chats-img">
        <img v-bind:src="message.sender.avatar" alt="" class="avatar">
      </div>
      <div class="received-msg">
        <div class="received-msg-inbox">
          <p><span>{{ message.sender.uid }}</span><br>{{ message.data.text }}</p>
        </div>
      </div>
    </div>
    <div class="outgoing-chats" v-else>
      <div class="outgoing-chats-msg">
        <p>{{ message.data.text }}</p>
      </div>
      <div class="outgoing-chats-img">
        <img v-bind:src="message.sender.avatar" alt="" class="avatar">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: Array,
      required: false
    }
  },
  methods: {

  }
}
</script>

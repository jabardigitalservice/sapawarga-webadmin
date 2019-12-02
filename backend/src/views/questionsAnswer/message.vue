<template>
  <div>
      <MessageBox
        :list-message="listMessage"
        :detail-questions="detailQuestions"
      />
      <MessageInput
        :value="message"
        @changeMessageInput="message = $event"
      />
  </div>
</template>

<script>

import MessageBox from './components/messageBox'
import MessageInput from './components/messageInput'
import {
  postAnswer,
  fetchListAnswer,
  fetchDetailQuestions
} from '@/api/questionsAnswer'
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
      userPhoto: '',
      idQuestions: '',
      detailQuestions: '',
      message: ''
    }
  },

  async created() {
    const id = this.$route.params && this.$route.params.id
    this.getListAnswer(id)
  },
  watch: {
    async 'message'() {
      // postAnswer(this.idQuestions, {text: this.message})
    },
  },
  methods: {
    async getListAnswer(id) {
      const res = await fetchDetailQuestions(id)
      this.userPhoto = res.data.user_photo_url
      this.detailQuestions = res.data.text
      this.idQuestions = res.data.id
      const response = await fetchListAnswer(id)
      this.listMessage.push(...response.data.items)
    },
  }
}
</script>

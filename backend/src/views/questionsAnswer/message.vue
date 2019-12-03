<template>
  <div>
    <MessageBox
      :list-message="listMessage"
      :detail-questions="detailQuestions"
      :total-likes-questions="totalLikesQuestions"
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
      totalLikesQuestions: '',
      message: ''
    }
  },
  watch: {
    async 'message'() {
      postAnswer(this.idQuestions, { text: this.message })
    }
  },

  async created() {
    const id = this.$route.params && this.$route.params.id
    this.getListAnswer(id)
  },
  methods: {
    async getListAnswer(id) {
      const res = await fetchDetailQuestions(id)
      this.userPhoto = res.data.user_photo_url
      this.detailQuestions = res.data.text
      this.totalLikesQuestions = res.data.likes_count
      this.idQuestions = res.data.id
      const response = await fetchListAnswer(id)
      this.listMessage.push(...response.data.items)
    }
  }
}
</script>

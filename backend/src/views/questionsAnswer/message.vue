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
      detailQuestions: {
        user: {
          name: ''
        }
      },
      message: ''
    }
  },
  watch: {
    async 'message'() {
      const response = await postAnswer(this.detailQuestions.id, {
        'question_id': this.detailQuestions.id,
        'text': this.message,
        'status': this.detailQuestions.status,
        'is_flagged': this.detailQuestions.is_flagged !== 0
      })
      if (response.success) {
        this.listMessage = []
        const listAnswer = await fetchListAnswer(this.detailQuestions.id)
        this.listMessage.push(...listAnswer.data.items)
      }
    }
  },

  async created() {
    const id = this.$route.params && this.$route.params.id
    this.getListAnswer(id)
  },
  methods: {
    async getListAnswer(id) {
      const res = await fetchDetailQuestions(id)
      this.detailQuestions = res.data
      const response = await fetchListAnswer(id)
      this.listMessage.push(...response.data.items)
    }
  }
}
</script>

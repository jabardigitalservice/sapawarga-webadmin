<template>
  <div>
    <el-row>
      <el-col :lg="24" :sm="24" :xs="24">
        <el-form
          ref="messageInput"
          :model="messageInput"
          :rules="rules"
          :status-icon="true"
          @submit.prevent.native="onSubmitMessage"
        >
          <el-form-item class="message-input" prop="message">
            <el-input
              v-model="messageInput.message"
              name="message"
              placeholder="Tulis Pesan"
            >
              <el-button
                slot="append"
                @click="onSubmitMessage"
              >
                <img src="@/assets/sentMessage.svg">
              </el-button>
            </el-input>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { isContainHtmlTags } from '@/utils/validate'

export default {
  props: {
    value: {
      type: String,
      required: true
    }
  },
  data() {
    const validatorHTMLTitle = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('errors.input-message')))
      }

      callback()
    }
    return {
      messageInput: {
        message: null
      },
      rules: {
        message: [
          {
            validator: validatorHTMLTitle,
            trigger: 'blur'
          }
        ]
      }
    }
  },
  watch: {
    value: {
      handler: function(value) {
        this.message = value
      },
      immediate: true
    }
  },
  methods: {
    async onSubmitMessage() {
      const valid = await this.$refs.messageInput.validate()
      if (!valid) {
        return
      }
      this.$emit('changeMessageInput', this.messageInput.message)
    }
  }
}
</script>

<template>
  <div>
    <el-row>
      <el-col :lg="23" :sm="23" :xs="23">
        <el-form>
          <el-form-item class="message-input">
            <el-input v-model="message" placeholder="Tulis Pesan">
              <el-button slot="append" @click="onSubmitMessage"><img src="@/assets/sentMessage.svg" /></el-button>
            </el-input>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      message: null
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
    onSubmitMessage() {
      this.$emit('input', this.message)
    }
  }
}
</script>

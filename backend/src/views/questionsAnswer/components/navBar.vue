<template>
  <div>
    <nav style="padding: 0 20px; !important">
      <div class="nav-left-section">
        <!-- <el-button slot="append" @click="onSubmitMessage"><img src="@/assets/sentMessage.svg"></el-button> -->
        <el-button
          type="info"
          icon="el-icon-back"
          circle
          @click="onBackPage"
        />
        <span class="welcome-message"><b>{{ name }}</b> </span>&nbsp;
      </div>
      <div class="nav-right-section">
        <!-- <img :src="avatar" class="avatar">&nbsp; -->
        <img src="@/assets/user.png" alt="" class="avatar">&nbsp;
      </div>
    </nav>
  </div>
</template>

<script>
import router from '@/router'

export default {
  props: {
    name: {
      type: String,
      required: true
    },
    avatar: {
      type: String,
      required: true
    }
  },
  methods: {
    onBackPage() {
      router.push(`/question-answer`)
    },
  }
}
</script>

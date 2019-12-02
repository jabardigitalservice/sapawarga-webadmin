<template>
  <div>
    <nav style="padding: 0 20px; !important">
      <div class="nav-left-section">
        <el-button
          type="info"
          icon="el-icon-back"
          circle
          @click="onBackPage"
        />
        <span class="questions-details"><b>{{ title }}</b> </span>&nbsp;
      </div>
      <div class="nav-right-section">
        <img src="@/assets/user.png" alt="" class="avatar">&nbsp;
      </div>
    </nav>
  </div>
</template>

<script>
import router from '@/router'

export default {
  props: {
    title: {
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
    }
  }
}
</script>

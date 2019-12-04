<template>
  <div>
    <nav style="padding: 0 20px;background-color: #ebf5fd;">
      <div class="nav-left-section">
        <i
          class="el-icon-back"
          style="padding: 10px;"
          @click="onBackPage"
        />
        <span>Detail</span>
        <!-- <img src="@/assets/user.png" alt="" class="avatar">&nbsp; -->
      </div>
    </nav>
  </div>
</template>

<script>
import router from '@/router'

export default {
  props: {
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

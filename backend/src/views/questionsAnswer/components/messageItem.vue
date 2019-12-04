<template>
  <div>
    <el-col>
      <el-card shadow="always">
        <el-row class="message-containers" name="message">
          <el-col :lg="2" :sm="2" :xs="2">
            <div>
              <div class="img-container">
                <img src="@/assets/user.png" alt="" class="avatar">&nbsp;
              </div>
            </div>
          </el-col>
          <el-col :lg="22" :sm="22" :xs="22" class="message-content">
            <div class="message-details" style="margin-top: 16px;">
              <div class="username">
                <span class="user-name">{{ message.user_name }}</span>
              </div>
              <div class="datetime">
                <span class="date-last-message">{{ formatDatetime(message.created_at, 'DD/MM/YYYY') }}</span>
              </div>
              <div class="last-messages">
                <span>{{ message.text }}</span>
              </div>
            </div>
          </el-col>
        </el-row>
      </el-card>
    </el-col>
  </div>
</template>

<script>
import { formatDatetime } from '@/utils/datetimeToString'

export default {
  props: {
    message: {
      type: Object,
      required: true
    },
    userId: {
      type: Number,
      required: true
    }
  },
  methods: {
    formatDatetime
  }
}
</script>

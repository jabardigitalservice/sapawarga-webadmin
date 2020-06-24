<template>
  <el-row :gutter="24">
    <el-col v-for="(data, name) in summary" :key="name" :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">{{ name }}</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ data ? formatNumber(data) : '-' }}</div>
      </div>
    </el-col>
  </el-row>
</template>

<script>
import { formatNumber } from '@/utils/formatNumber'
export default {
  props: {
    summary: {
      type: Object,
      default: () => {}
    },
    isLoading: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    formatNumber
  }
}
</script>

<style lang="scss" scoped>
.icon-loading {
  position: absolute;
  padding-top: 20px;
}
.el-col {
  padding-top: 10px;
  border-radius: 8px;
  padding-bottom: 30px;
}
.grid-content {
  position: relative;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.04);
  padding: 15px;
  background: #ffff;
  border: 1px solid #E1E5EE;
  box-sizing: border-box;
  border-radius: 8px;
}
.stat-title {
  margin-bottom: 13px;
  font-weight: bold;
  font-size: 14px;
  width: 100%;
}
.stat-count {
  width: 60%;
  font-size: 16px;
  font-weight: bolder;
}
.color-sw-green {
  color: #27AE60;
}
.color-sw-orange {
  color: #F2994A;
}
.color-sw-red {
  color: #EB5757;
}
.color-sw-blue {
  color: #2D9CDB;
}
</style>

<template>
  <el-row :gutter="20">
    <el-col :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">TERVERIFIKASI</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count">{{ summery.APPROVED ? formatNumber(summery.APPROVED) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title shadow">BELUM TERVERIFIKASI</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count">{{ summery.PENDING ? formatNumber(summery.PENDING) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">DITOLAK</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count">{{ summery.REJECT ? formatNumber(summery.REJECT) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">SEMUA DATA PENERIMA BANTUAN</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count">2555</div>
      </div>
    </el-col>
    <div> {{ summery }} </div>
  </el-row>
</template>

<script>
import { formatNumber } from '@/utils/formatNumber'
export default {
  props: {
    summery: {
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
}
.stat-count {
  color: #27AE60;
  font-size: 28px;
  font-weight: bolder;
}
</style>

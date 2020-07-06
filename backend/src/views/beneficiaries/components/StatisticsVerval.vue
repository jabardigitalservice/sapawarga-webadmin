<template>
  <el-row :gutter="20">
    <el-col v-if="isVerval && (isVerval && listType === 'pending')" :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">BELUM DISETUJUI</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-orange">{{ summery.pending ? formatNumber(summery.pending) : '-' }}</div>
      </div>
    </el-col>
    <el-col v-if="isVerval && (isVerval && listType === 'approved')" :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">DISETUJUI</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved ? summery.approved : '-' }}</div>
      </div>
    </el-col>
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
    },
    listType: {
      type: String,
      default: null
    },
    isVerval: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    getTotalBenefeciaries() {
      const approved = parseInt(this.summery.APPROVED)
      const pending = parseInt(this.summery.PENDING)
      const reject = parseInt(this.summery.REJECT)
      return approved + pending + reject
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
  font-size: 15px;
}
.stat-count {
  font-size: 28px;
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

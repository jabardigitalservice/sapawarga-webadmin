<template>
  <el-row :gutter="24">
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">APPROVAL KAB/KOTA</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved_kabkota ? formatNumber(summery.approved_kabkota) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summery.approved_kabkota)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">APPROVAL KEC</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved_kec ? formatNumber(summery.approved_kec) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summery.approved_kec)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">TERVERIFIKASI KEL/DESA</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved_kel ? formatNumber(summery.approved_kel) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summery.approved_kel)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">TERVERIFIKASI RW</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved ? formatNumber(summery.approved) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summery.approved)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title shadow">BELUM TERVERIFIKASI</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-orange">{{ summery.pending ? formatNumber(summery.pending) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-orange">{{ formatNumber(percentage(summery.pending)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">DITOLAK</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-red">{{ getReject ? formatNumber(getReject) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-red">{{ formatNumber(percentage(getReject)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">SEMUA DATA PENERIMA BANTUAN</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-blue">{{ getTotalBenefeciaries ? formatNumber(getTotalBenefeciaries) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">DATA BARU</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-blue">{{ summery.baru && summery.baru.total ? formatNumber(summery.baru.total) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-blue">{{ summery.baru ? formatNumber(percentage(summery.baru.total)) : '' }} %</div>
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
    summeryBaru: {
      type: Object,
      default: () => {}
    },
    filter: {
      type: Object,
      default: () => {}
    },
    isLoading: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    getApproved() {
      return this.summery.approved_kabkota + this.summery.approved_kec + this.summery.approved_kel + this.summery.approved
    },
    getPending() {
      return this.summery.pending
    },
    getReject() {
      return this.summery.rejected_kabkota + this.summery.rejected_kec + this.summery.rejected_kel + this.summery.rejected
    },
    getTotalBenefeciaries() {
      return this.getApproved + this.getPending + this.getReject
    }
  },
  methods: {
    percentage(val) {
      if (this.getTotalBenefeciaries && val) {
        return val / this.getTotalBenefeciaries * 100
      }
      return 0
    },
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

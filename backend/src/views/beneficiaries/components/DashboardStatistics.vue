<template>
  <el-row :gutter="24">
    <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4">
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
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4">
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
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4">
      <div class="grid-content">
        <div class="stat-title">TERVERIFIKASI KEL/DESA/RW</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved ? formatNumber(summery.approved) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4">
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
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4">
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
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4">
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
      if (this.filter.type === 'provinsi' || this.filter.type === 'kabkota') {
        return this.summery.approved_kabkota
      }
      if (this.filter.type === 'kec') {
        return this.summery.approved_kabkota + this.summery.approved_kec
      }
      if (this.filter.type === 'kel') {
        return this.summery.approved_kabkota + this.summery.approved_kec + this.summery.approved
      }
      return this.summery.approved_kabkota + this.summery.approved_kec + this.summery.approved
    },
    getPending() {
      if (this.filter.type === 'provinsi' || this.filter.type === 'kabkota') {
        return this.summery.approved_kec + this.summery.approved + this.summery.pending
      }
      if (this.filter.type === 'kec') {
        return this.summery.approved + this.summery.pending
      }
      if (this.filter.type === 'kel') {
        return this.summery.pending
      }
      return this.summery.pending
    },
    getReject() {
      return this.summery.rejected_kabkota + this.summery.rejected_kec + this.summery.rejected
    },
    getTotalBenefeciaries() {
      return this.getApproved + this.getPending + this.getReject
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

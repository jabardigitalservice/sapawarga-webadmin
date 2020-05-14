<template>
  <el-row :gutter="24">
    <!-- <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">APPROVAL KAB/KOTA</div>

        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />

        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved_kabkota ? formatNumber(summery.approved_kabkota) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summery.approved_kabkota)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">APPROVAL KEC</div>

        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />

        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved_kec ? formatNumber(summery.approved_kec) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summery.approved_kec)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">APPROVAL KEL/DESA</div>

        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />

        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved_kel ? formatNumber(summery.approved_kel) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summery.approved_kel)) }} %</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">TERVERIFIKASI RW</div>

        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />

        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved ? formatNumber(summery.approved) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summery.approved)) }} %</div>
      </div>
    </el-col> -->
    <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
      <div class="grid-content">
        <div class="stat-title">TOTAL PENERIMA</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="total color-sw-blue">{{ getTotalBenefeciaries ? formatNumber(getTotalBenefeciaries) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="5" :xl="5">
      <div class="grid-content">
        <div class="stat-title shadow">TERVERIFIKASI</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <span v-if="!isLoading" class="stat-count color-sw-green">{{ summery.approved ? formatNumber(summery.approved) : '-' }}</span>
        <span v-if="!isLoading" class="stat-count color-sw-green" style="float: right">{{ formatNumber(percentage(summery.approved)) }} %</span>
        <el-progress class="progress" :text-inside="true" color="#F2994A" :stroke-width="18" :percentage="summery && summery.approved ? parseFloat(formatNumber(percentage(summery.approved))) : 0" />
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="5" :xl="5">
      <div class="grid-content">
        <div class="stat-title shadow">BELUM TERVERIFIKASI</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <span v-if="!isLoading" class="stat-count color-sw-orange">{{ summery.pending ? formatNumber(summery.pending) : '-' }}</span>
        <span v-if="!isLoading" class="stat-count color-sw-orange" style="float: right">{{ formatNumber(percentage(summery.pending)) }} %</span>
        <el-progress class="progress" :text-inside="true" color="#F2994A" :stroke-width="18" :percentage="summery && summery.pending ? parseFloat(formatNumber(percentage(summery.pending))) : 0" />
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="5" :xl="5">
      <div class="grid-content">
        <div class="stat-title">DITOLAK</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <span v-if="!isLoading" class="stat-count color-sw-red">{{ getReject ? formatNumber(getReject) : '-' }}</span>
        <span v-if="!isLoading" class="stat-count color-sw-red" style="float: right">{{ formatNumber(percentage(getReject)) }} %</span>
        <el-progress class="progress" :text-inside="true" color="#EB5757" :stroke-width="18" :percentage="summery && summery.rejected ? parseFloat(formatNumber(percentage(summery.rejected))) : 0" />
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="5" :xl="5">
      <div class="grid-content">
        <div class="stat-title">DATA USULAN BARU</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <span v-if="!isLoading" class="stat-count color-sw-blue">{{ summery.baru && summery.baru.total ? formatNumber(summery.baru.total) : '-' }}</span>
        <span v-if="!isLoading" class="stat-count color-sw-blue" style="float: right">{{ summery.baru ? formatNumber(percentage(summery.baru.total)) : '' }} %</span>
        <el-progress class="progress" :text-inside="true" :stroke-width="18" :percentage="summery && summery.baru ? parseFloat(formatNumber(percentage(summery.baru.total))) : 0" />
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
.total {
  font-size: 28px;
  font-weight: bolder;
  padding: 14px 0;
}
.stat-count {
  font-size: 24px;
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

.progress {
  margin-top: 15px;
}
</style>

<template>
  <el-row :gutter="24">
    <!-- untuk sementara di hide -->
    <!-- <el-col :xs="24" :sm="8" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">APPROVAL KAB/KOTA</div>

        <div
          v-loading="isLoading"
          class="icon-loading"
          element-loading-spinner="el-icon-loading"
        />

        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summary.approved_kabkota ? formatNumber(summary.approved_kabkota) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summary.approved_kabkota)) }} %</div>
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

        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summary.approved_kec ? formatNumber(summary.approved_kec) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summary.approved_kec)) }} %</div>
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

        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summary.approved_kel ? formatNumber(summary.approved_kel) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summary.approved_kel)) }} %</div>
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

        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summary.approved ? formatNumber(summary.approved) : '-' }}</div>
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ formatNumber(percentage(summary.approved)) }} %</div>
      </div>
    </el-col>-->
    <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
      <div class="grid-content">
        <div
          class="stat-title"
        >{{ $t('label.beneficiaries-dashboard-total-recipient').toUpperCase() }}</div>
        <!-- show loading -->
        <div v-loading="isLoading" class="icon-loading" element-loading-spinner="el-icon-loading" />
        <!-- show data -->
        <div
          v-if="!isLoading"
          class="total color-sw-blue"
        >{{ getTotalBenefeciaries ? formatNumber(getTotalBenefeciaries) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="5" :xl="5">
      <div class="grid-content">
        <div
          class="stat-title shadow"
        >{{ $t('label.beneficiaries-dashboard-verified').toUpperCase() }}</div>
        <!-- show loading -->
        <div v-loading="isLoading" class="icon-loading" element-loading-spinner="el-icon-loading" />
        <!-- show data -->
        <span
          v-if="!isLoading"
          class="stat-count color-sw-green"
        >{{ getApproved ? formatNumber(getApproved) : '-' }}</span>
        <!-- untuk sementara di hide -->
        <!-- <span v-if="!isLoading" class="stat-count color-sw-green" style="float: right">{{ formatNumber(percentage(getApproved)) }} %</span> -->
        <!-- <el-progress class="progress" :text-inside="true" color="#27AE60" :stroke-width="18" :percentage="summary && summary.approved ? parseFloat(formatNumber(percentage(getApproved))) : 0" /> -->
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="5" :xl="5">
      <div class="grid-content">
        <div
          class="stat-title shadow"
        >{{ $t('label.beneficiaries-dashboard-not-verified').toUpperCase() }}</div>
        <!-- show loading -->
        <div v-loading="isLoading" class="icon-loading" element-loading-spinner="el-icon-loading" />
        <!-- show data -->
        <span
          v-if="!isLoading"
          class="stat-count color-sw-orange"
        >{{ getPending ? formatNumber(getPending) : '-' }}</span>
        <!-- untuk sementara di hide -->
        <!-- <span
          v-if="!isLoading"
          class="stat-count color-sw-orange"
          style="float: right"
        >{{ formatNumber(percentage(getPending)) }} %</span>
        <el-progress
          class="progress"
          :text-inside="true"
          color="#F2994A"
          :stroke-width="18"
          :percentage="summary && summary.pending ? parseFloat(formatNumber(percentage(getPending))) : 0"
        />-->
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="5" :xl="5">
      <div class="grid-content">
        <div class="stat-title">{{ $t('label.beneficiaries-dashboard-rejected').toUpperCase() }}</div>
        <!-- show loading -->
        <div v-loading="isLoading" class="icon-loading" element-loading-spinner="el-icon-loading" />
        <!-- show data -->
        <span
          v-if="!isLoading"
          class="stat-count color-sw-red"
        >{{ getReject ? formatNumber(getReject) : '-' }}</span>
        <!-- untuk sementara di hide -->
        <!-- <span
          v-if="!isLoading"
          class="stat-count color-sw-red"
          style="float: right"
        >{{ formatNumber(percentage(getReject)) }} %</span>
        <el-progress
          class="progress"
          :text-inside="true"
          color="#EB5757"
          :stroke-width="18"
          :percentage="summary && summary.rejected ? parseFloat(formatNumber(percentage(getReject))) : 0"
        />-->
      </div>
    </el-col>
    <el-col :xs="24" :sm="8" :md="6" :lg="5" :xl="5">
      <div class="grid-content">
        <div class="stat-title">{{ $t('label.beneficiaries-dashboard-new-proposal').toUpperCase() }}</div>
        <!-- show loading -->
        <div v-loading="isLoading" class="icon-loading" element-loading-spinner="el-icon-loading" />
        <!-- show data -->
        <span
          v-if="!isLoading"
          class="stat-count color-sw-blue"
        >{{ summary.baru && summary.baru.total ? formatNumber(summary.baru.total) : '-' }}</span>
        <!-- untuk sementara di hide -->
        <!-- <span
          v-if="!isLoading"
          class="stat-count color-sw-blue"
          style="float: right"
        >{{ summary.baru ? formatNumber(percentage(summary.baru.total)) : '' }} %</span>
        <el-progress
          class="progress"
          :text-inside="true"
          :stroke-width="18"
          :percentage="summary && summary.baru ? parseFloat(formatNumber(percentage(summary.baru.total))) : 0"
        />-->
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
    summaryBaru: {
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
      return (
        this.summary.approved +
        this.summary.rejected_kel +
        this.summary.approved_kel +
        this.summary.rejected_kec +
        this.summary.approved_kec +
        this.summary.rejected_kabkota +
        this.summary.approved_kabkota
      )
    },
    getPending() {
      return this.summary.pending
    },
    getReject() {
      return this.summary.rejected
    },
    getTotalBenefeciaries() {
      return this.getApproved + this.getPending + this.getReject
    }
  },
  methods: {
    percentage(val) {
      if (this.getTotalBenefeciaries && val) {
        return (val / this.getTotalBenefeciaries) * 100
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
  border: 1px solid #e1e5ee;
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
}
.stat-count {
  font-size: 20px;
  font-weight: bolder;
}
.color-sw-green {
  color: #27ae60;
}
.color-sw-orange {
  color: #f2994a;
}
.color-sw-red {
  color: #eb5757;
}
.color-sw-blue {
  color: #2d9cdb;
}

.progress {
  margin-top: 15px;
}
</style>

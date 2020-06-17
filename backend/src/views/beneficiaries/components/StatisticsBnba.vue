<template>
  <el-row :gutter="24">
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">PKH</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.pkh ? formatNumber(summery.pkh) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">BPNT</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.bpnt ? formatNumber(summery.bpnt) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">BPNT Perluasan</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.bpnt_perluasan ? formatNumber(summery.bpnt_perluasan) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">Bansos Tunai (Kemensos)</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.bansos_tunai_kemensos ? formatNumber(summery.bansos_tunai_kemensos) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">Bansos Presiden Sembako (BODEBEK)</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.bansos_presiden_sembako_bodebek ? formatNumber(summery.bansos_presiden_sembako_bodebek) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">Bansos Provinsi</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.bansos_provinsi ? formatNumber(summery.bansos_provinsi) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">Dana Desa</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.dana_desa ? formatNumber(summery.dana_desa) : '-' }}</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">Bansos Kabupaten/Kota</div>
        <!-- show loading -->
        <div
          v-loading="isLoading"
          class="icon-loading stat-count"
          element-loading-spinner="el-icon-loading"
        />
        <!-- show data -->
        <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.bansos_kabkota ? formatNumber(summery.bansos_kabkota) : '-' }}</div>
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
  font-size: 18px;
  width: 60%;
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

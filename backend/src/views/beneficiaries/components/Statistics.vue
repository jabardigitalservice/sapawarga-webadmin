<template>
  <div>
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
          <div v-if="!isLoading" class="stat-count color-sw-orange">{{ summery.APPROVED ? formatNumber(summery.APPROVED) : '-' }}</div>
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
          <div v-if="!isLoading" class="stat-count color-sw-green">{{ valid ? valid : '-' }}</div>
        </div>
      </el-col>
      <el-col v-if="!isVerval" :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
        <div class="grid-content">
          <div class="stat-title">{{ $t('label.beneficiaries-dashboard-verified').toUpperCase() }}</div>
          <!-- show loading -->
          <div
            v-loading="isLoading"
            class="icon-loading"
            element-loading-spinner="el-icon-loading"
          />
          <!-- show data -->
          <div class="show-explanation color-sw-blue">
            <el-button type="text" class="no-padding underline" @click="openDialog(2)">{{ $t('label.beneficiaries-explanation') }}</el-button>
          </div>
          <div v-if="!isLoading" class="stat-count color-sw-green">{{ summery.APPROVED ? formatNumber(summery.APPROVED) : '-' }}</div>
        </div>
      </el-col>
      <el-col v-if="!isVerval" :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
        <div class="grid-content">
          <div class="stat-title shadow">{{ $t('label.beneficiaries-dashboard-not-verified').toUpperCase() }}</div>
          <!-- show loading -->
          <div
            v-loading="isLoading"
            class="icon-loading"
            element-loading-spinner="el-icon-loading"
          />
          <!-- show data -->
          <div class="show-explanation color-sw-blue">
            <el-button type="text" class="no-padding underline" @click="openDialog(3)">{{ $t('label.beneficiaries-explanation') }}</el-button>
          </div>
          <div v-if="!isLoading" class="stat-count color-sw-orange">{{ summery.PENDING ? formatNumber(summery.PENDING) : '-' }}</div>
        </div>
      </el-col>
      <el-col v-if="!isVerval || (isVerval && listType === 'rejected')" :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
        <div class="grid-content">
          <div class="stat-title">{{ $t('label.beneficiaries-dashboard-rejected').toUpperCase() }}</div>
          <!-- show loading -->
          <div
            v-loading="isLoading"
            class="icon-loading"
            element-loading-spinner="el-icon-loading"
          />
          <!-- show data -->
          <div class="show-explanation color-sw-blue">
            <el-button type="text" class="no-padding underline" @click="openDialog(4)">{{ $t('label.beneficiaries-explanation') }}</el-button>
          </div>
          <div v-if="!isLoading" class="stat-count color-sw-red">{{ summery.REJECT ? formatNumber(summery.REJECT) : '-' }}</div>
        </div>
      </el-col>
      <el-col v-if="!isVerval || (isVerval && listType === null)" :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
        <div class="grid-content">
          <div class="stat-title">{{ $t('label.beneficiaries-dashboard-total-regulations').toUpperCase() }}</div>
          <!-- show loading -->
          <div
            v-loading="isLoading"
            class="icon-loading"
            element-loading-spinner="el-icon-loading"
          />
          <!-- show data -->
          <div class="show-explanation color-sw-blue">
            <el-button type="text" class="no-padding underline" @click="openDialog(1)">{{ $t('label.beneficiaries-explanation') }}</el-button>
          </div>
          <div v-if="!isLoading" class="stat-count color-sw-blue">{{ getTotalBenefeciaries ? formatNumber(getTotalBenefeciaries) : '-' }}</div>
        </div>
      </el-col>
    </el-row>
    <el-dialog width="40%" custom-class="dialog-explanation" :show-close="false" :visible.sync="dialogTableVisible">
      <span slot="title" class="dialog-title-explanation">{{ $t('label.beneficiaries-description-proposal') }}</span>
      <DialogExplanation :id="idexplanationSelected" @close="dialogTableVisible = false" />
    </el-dialog>
  </div>
</template>

<script>
import { formatNumber } from '@/utils/formatNumber'
import DialogExplanation from './DialogExplanation'
export default {
  components: { DialogExplanation },
  props: {
    summery: {
      type: Object,
      default: () => {}
    },
    valid: {
      type: Number,
      default: 0
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
  data() {
    return {
      dialogTableVisible: false,
      idexplanationSelected: null
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
    openDialog(value) {
      this.dialogTableVisible = true
      this.idexplanationSelected = value
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
  margin-bottom: 8px;
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
.show-explanation {
  margin-bottom: 18px;
  font-size: 14px;
}
.underline {
  text-decoration: underline;
}
.no-padding {
  padding: 0px;
}
.dialog-title-explanation {
  font-weight: bold;
}
</style>

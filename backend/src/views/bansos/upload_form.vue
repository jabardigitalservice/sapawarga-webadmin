<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-card class="box-card green body-nopadding">
          <div slot="header">
            <span>{{ `${ $t('label.beneficiaries-upload') } : ${ beneficiariesType }` }}</span>
          </div>
          <div class="text item card-description">
            <p>
              <strong>
                <i class="el-icon-info" />
                {{ $t('label.beneficiaries-upload-option') }}
              </strong>
            </p>
            <p>{{ $t('label.beneficiaries-upload-info') }}</p>
          </div>
        </el-card>
      </el-col>
    </el-row>
    <el-card class="box-card body-nopadding">
      <div slot="header">
        <span>{{ $t('label.beneficiaries-upload-allocation-data') }}</span>
      </div>
      <form-upload-city v-if="isCityComponent" v-loading="loading" />
    </el-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import FormUploadCity from './components/FormUploadCity'
import BeneficiariesType from './statics/beneficiariesType'

export default {
  components: {
    FormUploadCity
  },
  data() {
    return {
      type: this.$route.query.type,
      isCityComponent: true,
      beneficiariesType: null,
      loading: false
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  created() {
    this.getTitle()
  },
  methods: {
    async getTitle() {
      const beneficiariesType = new BeneficiariesType()
      const response = await beneficiariesType.getAll(this.type)
      this.beneficiariesType = `${response.type
        .toUpperCase()
        .replace('_', ' ')} - ${response.name}`
    },
    switchComponent(component) {
      if (component === 'uploadFormCity') {
        this.isCityComponent = true
        this.loading = true
        setTimeout(() => {
          this.loading = false
        }, 1000)
      }
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.panel-group {
  margin-top: 18px;
  text-align: center;
  .card-panel-col {
    margin-bottom: 32px;
  }
  .card-panel-default {
    height: 80px;
    cursor: pointer;
    font-size: 12px;
    position: relative;
    overflow: hidden;
    color: #666;
    background: #fff;
    box-shadow: 4px 4px 40px rgba(0, 0, 0, 0.05);
    border-radius: 5px;
    padding: 10px;
    background-color: #f4f4f5;
    border: 1px solid #e9e9eb;
  }
  .card-panel-text {
    line-height: 18px;
    color: rgba(0, 0, 0, 0.45);
    font-size: 14px;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 10px;
  }
  .el-card {
    margin-bottom: 10px !important;
  }
}
</style>

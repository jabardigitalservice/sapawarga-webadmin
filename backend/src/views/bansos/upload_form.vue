<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-card class="box-card green body-nopadding">
          <div slot="header">
            <span>{{ `${ $t('label.beneficiaries-upload') } : ${ beneficiariesType }` }}</span>
          </div>
          <div class="text item card-description">
            <p><strong><i class="el-icon-info" /> {{ $t('label.beneficiaries-upload-option') }}</strong></p>
            <p>{{ $t('label.beneficiaries-upload-info') }}</p>
          </div>
        </el-card>
      </el-col>
    </el-row>
    <el-card class="box-card">
      <el-row :gutter="40" class="panel-group">
        <el-col :xs="12" :sm="12" :lg="12" class="card-panel-col">
          <div class="card-panel-default" @click="switchComponent('uploadFormCity')">
            <el-row>
              <el-col :span="24">
                <div class="card-panel-text">
                  {{ `Alokasi ${ beneficiariesType } untuk ${user.kabkota.name}` }}
                </div>
              </el-col>
            </el-row>
          </div>
        </el-col>
        <el-col :xs="12" :sm="12" :lg="12" class="card-panel-col">
          <div class="card-panel-default" @click="switchComponent('uploadFormSubdistrict')">
            <el-row>
              <el-col :span="24">
                <div class="card-panel-text">
                  {{ `Alokasi ${ beneficiariesType } Per Kecamatan` }}
                </div>
              </el-col>
            </el-row>
          </div>
        </el-col>
      </el-row>
      <form-upload-sub-district v-if="isSubdistrictComponent" />
      <form-upload-city v-if="isCityComponent" />
    </el-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import FormUploadSubDistrict from './components/FormUploadSubDistrict'
import FormUploadCity from './components/FormUploadCity'
import BeneficiariesType from './statics/beneficiariesType'

export default {
  components: {
    FormUploadSubDistrict,
    FormUploadCity
  },
  data() {
    return {
      type: this.$route.query.type,
      isCityComponent: false,
      isSubdistrictComponent: false,
      beneficiariesType: null
    }
  },
  computed: {
    ...mapGetters([
      'user'
    ])
  },
  created() {
    this.getTitle()
  },
  methods: {
    async getTitle() {
      const beneficiariesType = new BeneficiariesType()
      const response = await beneficiariesType.getAll(this.type)
      this.beneficiariesType = response.name
    },
    switchComponent(component) {
      if (component === 'uploadFormCity') {
        this.isCityComponent = true
        this.isSubdistrictComponent = false
      }

      if (component === 'uploadFormSubdistrict') {
        this.isSubdistrictComponent = true
        this.isCityComponent = false
      }

      if (component === 'uploadFormVillage') {
        this.isSubdistrictComponent = false
        this.isCityComponent = false
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
    margin-top:10px;
    margin-bottom:10px;
  }
  .el-card {
    margin-bottom: 10px !important;
  }
}
</style>

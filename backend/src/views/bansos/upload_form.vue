<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-card class="box-card green body-nopadding">
          <div slot="header">
            <span>{{ `${ $t('label.beneficiaries-upload') } : ${ getTitle() }` }}</span>
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
        <el-col :xs="12" :sm="12" :lg="8" class="card-panel-col">
          <div class="card-panel-default" @click="switchComponent('uploadFormCity')">
            <el-row>
              <el-col :span="24">
                <div class="card-panel-text">
                  {{ `Alokasi ${ getTitle() } untuk ${user.kabkota.name}` }}
                </div>
              </el-col>
            </el-row>
          </div>
        </el-col>
        <el-col :xs="12" :sm="12" :lg="8" class="card-panel-col">
          <div class="card-panel-default" @click="switchComponent('uploadFormSubdistrict')">
            <el-row>
              <el-col :span="24">
                <div class="card-panel-text">
                  {{ `Alokasi ${ getTitle() } Per Kecamatan` }}
                </div>
              </el-col>
            </el-row>
          </div>
        </el-col>
        <el-col :xs="12" :sm="12" :lg="8" class="card-panel-col">
          <div class="card-panel-default" @click="switchComponent('uploadFormVillage')">
            <el-row>
              <el-col :span="24">
                <div class="card-panel-text">
                  {{ $t('label.beneficiaries-upload-village') }}
                </div>
              </el-col>
            </el-row>
          </div>
        </el-col>
      </el-row>
      <form-upload-sub-district v-if="isSubdistrictComponent" />
      <form-upload-city v-if="isCityComponent" />
      <form-upload-village v-if="isVillageComponent" />
    </el-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import FormUploadSubDistrict from './components/FormUploadSubDistrict'
import FormUploadCity from './components/FormUploadCity'
import FormUploadVillage from './components/FormUploadVillage'

export default {
  components: {
    FormUploadSubDistrict,
    FormUploadCity,
    FormUploadVillage
  },
  data() {
    return {
      type: this.$route.query.type,
      isCityComponent: false,
      isSubdistrictComponent: false,
      isVillageComponent: false
    }
  },
  computed: {
    ...mapGetters([
      'user'
    ])
  },
  methods: {
    getTitle() {
      switch (this.type) {
        case '1':
          return 'Bantuan Sosial Provinsi'
        case '2':
          return 'Bantuan Sosial Kota/Kabupaten'
        case '3':
          return 'Bantuan Dana Desa'
        case '4':
          return 'Bantuan Sosial Presiden Sembako (Bodebek)'
        case '5':
          return 'Bantuan Sosial Tunai Kemensos'
        default:
          return 'N/A'
      }
    },
    switchComponent(component) {
      if (component === 'uploadFormCity') {
        this.isCityComponent = true
        this.isSubdistrictComponent = false
        this.isVillageComponent = false
      }

      if (component === 'uploadFormSubdistrict') {
        this.isSubdistrictComponent = true
        this.isCityComponent = false
        this.isVillageComponent = false
      }

      if (component === 'uploadFormVillage') {
        this.isSubdistrictComponent = false
        this.isCityComponent = false
        this.isVillageComponent = false
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

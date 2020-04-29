<template>
  <div class="app-container">
    <el-card class="box-card" :body-style="{ background: '#fff8e6' }">
      <div slot="header">
        <span>{{ $t('label.beneficiaries-upload') }}</span>
      </div>
      <div class="text item">
        <p><strong><i class="el-icon-info" /> {{ $t('label.beneficiaries-upload-option') }}</strong></p>
        <p>{{ $t('label.beneficiaries-upload-info') }}</p>
      </div>
    </el-card>
    <el-card class="box-card">
      <el-row :gutter="40" class="panel-group">
        <el-col :xs="12" :sm="12" :lg="8" class="card-panel-col">
          <div class="card-panel-default" @click="switchComponent('uploadFormCity')">
            <el-row>
              <el-col :span="24">
                <div class="card-panel-text">
                  Upload Data Alokasi Bantuan Kota Bandung
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
                  Upload Data Alokasi Bantuan Per Kecamatan
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
                  Upload Data Alokasi Bantuan Per Desa
                </div>
              </el-col>
            </el-row>
          </div>
        </el-col>
      </el-row>
      <upload-form-subdistrict v-if="isSubdistrictComponent"/>
      <upload-form-city v-if="isCityComponent"/>
      <upload-form-village v-if="isVillageComponent"/>
    </el-card>
  </div>
</template>

<script>
import UploadFormSubdistrict from './components/uploadFormSubdistrict';
import UploadFormCity from './components/uploadFormCity';
import UploadFormVillage from './components/uploadFormVillage';

export default {
  components: { 
    UploadFormSubdistrict,
    UploadFormCity, 
    UploadFormVillage, 
  },
  data() {
    return {
      isCityComponent: false,
      isSubdistrictComponent: true,
      isVillageComponent: false,
    };
  },
  methods: {
    switchComponent(component) {
      if(component === 'uploadFormCity') {
        this.isCityComponent = true,
        this.isSubdistrictComponent = false
      }

      if(component === 'uploadFormSubdistrict') {
        this.isSubdistrictComponent = true,
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

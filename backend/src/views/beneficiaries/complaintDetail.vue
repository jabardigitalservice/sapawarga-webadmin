<template>
  <div class="app-container">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span class="title-detail">{{ $t('label.beneficiaries-complaint-detail-title') }}</span>
      </div>
      <div>
        <span class="title-detail">{{ $t('label.beneficiaries-complaint-detail-sub-title') }}</span>

        <div class="pb-1">
          <div>
            <p class="header-section">{{ $t('label.beneficiaries-complaint-Identity') }}</p>
          </div>

          <el-row :gutter="24">
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.beneficiaries-nik') }}</p>
              <span class="content-data">3200860009249665</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.name') }}</p>
              <span class="content-data">Agus Dadang</span>
            </el-col>
          </el-row>
        </div>

        <div class="pb-1">
          <div>
            <p class="header-section">{{ $t('label.address') }}</p>
          </div>

          <el-row :gutter="24" class="pb-0-5">
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.widget-province') }}</p>
              <span class="content-data">Jawa Barat</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.beneficiaries-domicile-kabkota') }}</p>
              <span class="content-data">Agus Dadang</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.beneficiaries-domicile-kecamatan') }}</p>
              <span class="content-data">Agus Dadang</span>
            </el-col>
          </el-row>

          <el-row :gutter="24">
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.beneficiaries-domicile-kelurahan') }}</p>
              <span class="content-data">Cisaranten Bina Harapan</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.area-rw') }}</p>
              <span class="content-data">001</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.area-rt') }}</p>
              <span class="content-data">012</span>
            </el-col>
          </el-row>
        </div>

        <div class="pb-1">
          <div>
            <p class="header-section">{{ $t('label.beneficiaries-complaint-reason') }}</p>
          </div>

          <span class="content-data">Sudah menerima bantuan lain</span>
        </div>
      </div>

      <!-- data Pelapor -->
      <div class="pt-2">
        <span class="title-detail">{{ $t('label.beneficiaries-complaint-report') }}</span>

        <div class="pb-1">
          <div>
            <p class="header-section">{{ $t('label.beneficiaries-complaint-Identity') }}</p>
          </div>

          <el-row :gutter="24">
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.beneficiaries-nik') }}</p>
              <span class="content-data">3200860009249665</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.name') }}</p>
              <span class="content-data">Agus Dadang</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('users.users-phone') }}</p>
              <span class="content-data">0876562362323</span>
            </el-col>
          </el-row>
        </div>

        <div class="pb-1">
          <div>
            <p class="header-section">Alamat</p>
          </div>

          <el-row :gutter="24" class="pb-0-5">
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.widget-province') }}</p>
              <span class="content-data">Jawa Barat</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.beneficiaries-domicile-kabkota') }}</p>
              <span class="content-data">Agus Dadang</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.beneficiaries-domicile-kecamatan') }}</p>
              <span class="content-data">Agus Dadang</span>
            </el-col>
          </el-row>

          <el-row :gutter="24">
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.beneficiaries-domicile-kelurahan') }}</p>
              <span class="content-data">Cisaranten Bina Harapan</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.area-rw') }}</p>
              <span class="content-data">001</span>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
              <p class="title-input">{{ $t('label.area-rt') }}</p>
              <span class="content-data">012</span>
            </el-col>
          </el-row>
        </div>
      </div>

      <div class="section-footer clearfix">
        <router-link to="/beneficiaries/complaint">
          <el-button class="btn-cancel">{{ $t('crud.back') }}</el-button>
        </router-link>
      </div>
    </el-card>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
  .pb-1 {
    padding-bottom: 1rem;
  }
  .pt-1 {
    padding-top: 1rem;
  }

  .pt-2 {
    padding-top: 2rem;
  }

  .pb-0-5 {
    padding-bottom: 0.5rem;
  }

  .title-detail {
    font-weight: bold;
    font-size: 22px;
  }

  .header-section {
    font-weight: bold;
    font-size: 18px;
    color: #27AE60;
    padding-top: 0.5rem;
    margin-bottom: 0.5rem;
  }

  .title-input {
    color: #828282;
    font-size: 16px;
    line-height: 19px;
  }

  .content-data {
    font-weight: bold;
    font-size: 14px;
    line-height: 20px;
    color: #333333;
  }

  .section-footer {
    width: 100%;
    border-top: 1px solid #e6ebf5;
    margin-top: 1rem;
  }

  .btn-cancel {
    margin-top: 1rem;
    float: right;
  }
</style>

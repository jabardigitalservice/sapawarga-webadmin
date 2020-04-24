<template>
  <div class="app-container">
    <el-row :gutter="40" class="panel-group">
      <el-col :xs="12" :sm="12" :lg="8" class="card-panel-col">
        <div class="card-panel-success">
          <el-row>
            <el-col :span="15">
              <div class="card-panel-text">
                {{ $t('label.beneficiaries-total-pkh') }}
              </div>
            </el-col>
            <el-col :span="9">
              <div class="card-panel-num">
                {{ summaryBeneficiariesPkh.total }}
              </div>
            </el-col>
          </el-row>
        </div>
      </el-col>
      <el-col :xs="12" :sm="12" :lg="8" class="card-panel-col">
        <div class="card-panel-warning">
          <el-row>
            <el-col :span="12">
              <div class="card-panel-text">
                {{ $t('label.beneficiaries-available-pkh') }}
              </div>
            </el-col>
            <el-col :span="12">
              <div class="card-panel-num">
                {{ summaryBeneficiariesPkh.available }}
              </div>
            </el-col>
          </el-row>
        </div>
      </el-col>
      <el-col :xs="12" :sm="12" :lg="8" class="card-panel-col">
        <div class="card-panel-primary">
          <el-row>
            <el-col :span="12">
              <div class="card-panel-text">
                {{ $t('label.beneficiaries-allocated-pkh') }}
              </div>
            </el-col>
            <el-col :span="12">
              <div class="card-panel-num">
                {{ summaryBeneficiariesPkh.allocated }}
              </div>
            </el-col>
          </el-row>
        </div>
      </el-col>
    </el-row>
    <div class="card-panel-text">
      <b>Total Bantuan yang Dialokasikan tanggal 25 April 2020</b>
    </div>
    <el-row>
      <el-col :span="12">
        <h2 style="text-align:left">1900</h2>
      </el-col>
      <el-col :span="12">
        <h2 style="text-align:right">2010</h2>
      </el-col>
    </el-row>
    <el-progress :text-inside="true" :stroke-width="20" :percentage="80" status="success" />
    <br>
    <el-row :gutter="12">
      <el-col :span="6">
        <p>{{ $t('label.name') }}</p>
        <el-input v-model="input" />
      </el-col>
      <el-col :span="6">
        <p>{{ $t('label.beneficiaries-nik') }}</p>
        <el-input v-model="input" />
      </el-col>
      <el-col :span="6">
        <p>{{ $t('label.beneficiaries-no-kk') }}</p>
        <el-input v-model="input" />
      </el-col>
      <el-col :span="6">
        <p>&nbsp;</p>
        <el-button type="primary" icon="el-icon-search" size="small" style="width:100%;">{{ $t('label.beneficiaries-pkh-search') }}</el-button>
      </el-col>
    </el-row>
    <br>
    <el-row :gutter="12">
      <el-col :span="12">
        <el-card shadow="never" style="margin-bottom: 10px">
          <el-row>
            <el-col :span="9">{{ $t('label.beneficiaries-pkh') }}</el-col>
            <el-col :span="9">201 Orang</el-col>
            <el-col :span="6"><el-button type="primary" size="mini" style="width:100%">{{ $t('label.beneficiaries-pkh-detail') }}</el-button></el-col>
          </el-row>
        </el-card>
        <el-card shadow="never" style="margin-bottom: 10px">
          <el-row>
            <el-col :span="9">{{ $t('label.beneficiaries-pkh') }}</el-col>
            <el-col :span="9">201 Orang</el-col>
            <el-col :span="6"><el-button type="primary" size="mini" style="width:100%">{{ $t('label.beneficiaries-pkh-detail') }}</el-button></el-col>
          </el-row>
        </el-card>
        <el-card shadow="never" style="margin-bottom: 10px">
          <el-row>
            <el-col :span="9">{{ $t('label.beneficiaries-pkh') }}</el-col>
            <el-col :span="9">201 Orang</el-col>
            <el-col :span="6"><el-button type="primary" size="mini" style="width:100%">{{ $t('label.beneficiaries-pkh-detail') }}</el-button></el-col>
          </el-row>
        </el-card>
        <el-card shadow="never" style="margin-bottom: 10px">
          <el-row>
            <el-col :span="9">{{ $t('label.beneficiaries-pkh') }}</el-col>
            <el-col :span="9">201 Orang</el-col>
            <el-col :span="6"><el-button type="primary" size="mini" style="width:100%">{{ $t('label.beneficiaries-pkh-detail') }}</el-button></el-col>
          </el-row>
        </el-card>
      </el-col>
      <el-col :span="12">
        <el-card shadow="never" style="margin-bottom: 10px">
          <el-row>
            <el-col :span="9">{{ $t('label.beneficiaries-pkh') }}</el-col>
            <el-col :span="9">201 Orang</el-col>
            <el-col :span="6"><el-button type="primary" size="mini" style="width:100%">{{ $t('label.beneficiaries-pkh-detail') }}</el-button></el-col>
          </el-row>
        </el-card>
        <el-card shadow="never" style="margin-bottom: 10px">
          <el-row>
            <el-col :span="9">{{ $t('label.beneficiaries-pkh') }}</el-col>
            <el-col :span="9">201 Orang</el-col>
            <el-col :span="6"><el-button type="primary" size="mini" style="width:100%">{{ $t('label.beneficiaries-pkh-detail') }}</el-button></el-col>
          </el-row>
        </el-card>
        <el-card shadow="never" style="margin-bottom: 10px">
          <el-row>
            <el-col :span="9">{{ $t('label.beneficiaries-pkh') }}</el-col>
            <el-col :span="9">201 Orang</el-col>
            <el-col :span="6"><el-button type="primary" size="mini" style="width:100%">{{ $t('label.beneficiaries-pkh-detail') }}</el-button></el-col>
          </el-row>
        </el-card>
        <el-card shadow="never" style="margin-bottom: 10px">
          <el-row>
            <el-col :span="9">{{ $t('label.beneficiaries-pkh') }}</el-col>
            <el-col :span="9">201 Orang</el-col>
            <el-col :span="6"><el-button type="primary" size="mini" style="width:100%">{{ $t('label.beneficiaries-pkh-detail') }}</el-button></el-col>
          </el-row>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      input: '',
      summaryBeneficiariesPkh: {
        total: 2010,
        available: 2010,
        allocated: 1900
      }
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.panel-group {
  margin-top: 18px;
  .card-panel-col {
    margin-bottom: 32px;
  }
  .card-panel-success {
    height: 108px;
    cursor: pointer;
    font-size: 12px;
    position: relative;
    overflow: hidden;
    color: #666;
    background: #fff;
    box-shadow: 4px 4px 40px rgba(0, 0, 0, 0.05);
    border-radius: 5px;
    padding: 10px;
    background-color: #bee7cf;
    border: 1px solid #87b49a;
  }
  .card-panel-warning {
    height: 108px;
    cursor: pointer;
    font-size: 12px;
    position: relative;
    overflow: hidden;
    color: #666;
    background: #fff;
    box-shadow: 4px 4px 40px rgba(0, 0, 0, 0.05);
    border-radius: 5px;
    padding: 10px;
    background-color: #fce0b4;
    border: 1px solid #dbba82;
  }
  .card-panel-primary {
    height: 108px;
    cursor: pointer;
    font-size: 12px;
    position: relative;
    overflow: hidden;
    color: #666;
    background: #fff;
    box-shadow: 4px 4px 40px rgba(0, 0, 0, 0.05);
    border-radius: 5px;
    padding: 10px;
    background-color: #b4d4f2;
    border: 1px solid #6e8cb8;
  }
  .card-panel-text {
    line-height: 18px;
    color: rgba(0, 0, 0, 0.45);
    font-size: 14px;
    font-weight: bold;
    margin-top:20px;
    margin-bottom:20px;
  }
  .card-panel-num {
    line-height: 18px;
    color: rgba(0, 0, 0, 0.45);
    font-size: 30px;
    font-weight: bold;
    margin-top:30px;
    margin-bottom:20px;
    text-align:center;
  }
  .el-card {
    margin-bottom: 10px !important;
  }
}
</style>

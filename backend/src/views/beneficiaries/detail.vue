<template>
  <div class="app-container">
    <el-card class="box-card">
      <h3 class="header title">Tambah Calon Penerima Bantuan</h3>
      <el-steps class="steps" :active="active" process-status="process" finish-status="success" align-center>
        <el-step title="Informasi Penerima Bantuan" />
        <el-step title="Informasi Penghasilan" />
        <el-step title="Domisili Saat Ini" />
        <el-step title="Upload Dokumen Pendukung" />
      </el-steps>
      <el-form
        ref="beneficiaries"
        :model="beneficiaries"
        label-width="150px"
        label-position="left"
        :status-icon="true"
      >
        <el-row v-if="active === 0" :gutter="20">
          <el-col :sm="24" :md="17" :lg="17" :xl="17">
            <FormPersonal :beneficiaries.sync="beneficiaries" @nextStep="onClickNextChild" />
          </el-col>
        </el-row>
        <el-row v-if="active === 1" :gutter="20">
          <el-col :sm="24" :md="20" :lg="20" :xl="20">
            <FormIncome :beneficiaries.sync="beneficiaries" @nextStep="onClickNextChild" />
          </el-col>
        </el-row>
        <el-row v-if="active === 2" :gutter="20">
          <el-col :sm="24" :md="17" :lg="17" :xl="17">
            <FormDomicile :beneficiaries.sync="beneficiaries" @nextStep="onClickNextChild" />
          </el-col>
        </el-row>
      </el-form>
      <!-- <el-button style="margin-top: 12px;" @click="next">Next step</el-button> -->
    </el-card>
  </div>
</template>

<script>
import FormPersonal from './components/FormPersonal'
import FormIncome from './components/FormIncome'
import FormDomicile from './components/FormDomicile'

export default {
  components: { 
    FormPersonal,
    FormIncome,
    FormDomicile
  },
  data() {
    return {
      active: 0,
      beneficiaries: {
        nik: null,
        name: null,
        provinsi: null,
        kabkota: null,
        kecamatan: null,
        kelurahan: null,
        rw: null,
        rt: null
      },
      rules: {
      }
    }
  },
  methods: {
    next() {
      if (this.active++ > 4) this.active = 0
    },
    onClickNextChild(value) {
      this.active = this.active + value
    }
  }
}
</script>
<style lang="scss" scoped>
  .header {
    font-size: 20px;
  }
  .steps {
    background-color: #F8F8F9;
    margin: 35px -20px !important;
    padding: 10px 0;
  }
</style>

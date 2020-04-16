<template>
  <div class="app-container">
    <el-card v-if="preview === false" class="box-card">
      <span class="header title">Tambah Calon Penerima Bantuan</span>
      <el-steps class="steps" :active="active" process-status="wait" finish-status="success" align-center>
        <el-step title="Informasi Penerima Bantuan" />
        <el-step title="Domisili Saat Ini" />
        <el-step title="Informasi Penghasilan" />
        <el-step title="Upload Dokumen Pendukung" />
      </el-steps>
      <el-form
        ref="beneficiaries"
        :model="beneficiaries"
        label-width="150px"
        label-position="left"
        :status-icon="true"
      >
        <el-row v-if="active === 1" :gutter="20">
          <el-col :sm="24" :md="17" :lg="17" :xl="17">
            <FormPersonal :beneficiaries.sync="beneficiaries" @nextStep="onClickNextChild" />
          </el-col>
        </el-row>
        <el-row v-if="active === 3" :gutter="20">
          <el-col :sm="24" :md="20" :lg="20" :xl="20">
            <FormIncome :beneficiaries.sync="beneficiaries" @nextStep="onClickNextChild" />
          </el-col>
        </el-row>
        <el-row v-if="active === 2" :gutter="20">
          <el-col :sm="24" :md="17" :lg="17" :xl="17">
            <FormDomicile :beneficiaries.sync="beneficiaries" @nextStep="onClickNextChild" />
          </el-col>
        </el-row>
        <el-row v-if="active === 4" :gutter="20">
          <el-col :sm="24" :md="24" :lg="24" :xl="24">
            <FormUpload :beneficiaries.sync="beneficiaries" @nextStep="onClickNextChild" @getImageKtp="onClickImageKtp" @getImageKk="onClickImageKk" />
          </el-col>
        </el-row>
      </el-form>
      <!-- <el-button style="margin-top: 12px;" @click="next">Next step</el-button> -->
    </el-card>
    <el-card v-if="preview" class="box-card">
      <div slot="header" class="clearfix">
        <span class="header">Ringkasan Calon Penerima Bantuan</span>
      </div>
      <Preview :beneficiaries.sync="beneficiaries" @nextStep="onClickNextChild" />
    </el-card>
  </div>
</template>

<script>
import FormPersonal from './components/FormPersonal'
import FormDomicile from './components/FormDomicile'
import FormIncome from './components/FormIncome'
import FormUpload from './components/FormUpload'
import Preview from './components/Preview'
import { fetchRecord, update } from '@/api/beneficiaries'

export default {
  components: {
    FormPersonal,
    FormIncome,
    FormDomicile,
    FormUpload,
    Preview
  },
  data() {
    return {
      active: 1,
      preview: false,
      beneficiaries: {
        nik: null,
        name: null,
        provinsi: null,
        kabkota: null,
        kecamatan: null,
        kelurahan: null,
        rw: null,
        rt: null,
        image_ktp: null,
        image_kk: null,
        image_path_url: null,
        image_ktp_url: null,
        image_kk_url: null,
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        domicile_province_id: null,
        domicile_kabkota_bps_id: null,
        domicile_kec_id: null,
        domicile_kel_id: null,
        domicile_rt: null,
        domicile_rw: null,
        domicile_address: null
      },
      rules: {
      }
    }
  },
  async created() {
    const id = await this.$route.params && this.$route.params.id
    await this.getDetail(id)
  },
  methods: {
    getDetail(id) {
      fetchRecord(id).then(response => {
        this.beneficiaries = response.data
      })
    },
    async next() {
      if (this.active++ > 3) this.preview = true
    },
    onClickNextChild(value) {
      this.active = this.active + value
      if (this.active > 4) this.active = 1
    },
    onClickImageKtp(value) {
      this.beneficiaries.image_ktp = value
    },
    onClickImageKk(value) {
      this.beneficiaries.image_kk = value
    }
  }
}
</script>
<style lang="scss" scoped>
  .header {
    font-size: 18px;
    font-weight: bold;
  }
  .steps {
    background-color: #F8F8F9;
    margin: 35px -20px !important;
    padding: 10px 0;
  }
</style>

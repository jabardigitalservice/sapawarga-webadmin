<template>
  <div>
    <el-row>
      <el-col :sm="24" :md="8" :lg="8">
        <div>
          <p class="preview-title">Informasi Penerima Bantuan</p>
        </div>
        <div class="preview-content">
          <p>NIK</p>
          <p class="content">{{ beneficiaries.nik }}</p>
        </div>
        <div class="preview-content">
          <p>Nama</p>
          <p class="content">{{ beneficiaries.name }}</p>
        </div>
        <div class="preview-content">
          <p>Kabupaten/Kota</p>
          <p class="content">{{ beneficiaries.kabkota.name }}</p>
        </div>
        <div class="preview-content">
          <p>Kecamatan</p>
          <p class="content">{{ beneficiaries.kecamatan.name }}</p>
        </div>
        <div class="preview-content">
          <p>Kelurahan</p>
          <p class="content">{{ beneficiaries.kelurahan.name }}</p>
        </div>
        <div class="preview-content">
          <p>RW</p>
          <p class="content">{{ beneficiaries.rw }}</p>
        </div>
        <div class="preview-content">
          <p>RT</p>
          <p class="content">{{ beneficiaries.rt }}</p>
        </div>
      </el-col>
      <el-col :sm="24" :md="8" :lg="8">
        <p class="preview-title">Informasi Penghasilan</p>
        <div class="preview-content">
          <p>Pekerjaan</p>
          <p class="content">{{ beneficiaries.job_type_name.title }}</p>
        </div>
        <div class="preview-content">
          <p>Status Kedudukan dalam Pekerjaan</p>
          <p class="content">{{ beneficiaries.job_status_id }}</p>
        </div>
        <div class="preview-content">
          <p>Jumlah Anggota Keluarga</p>
          <p class="content">{{ beneficiaries.total_family_members }}</p>
        </div>
        <div class="preview-content">
          <p>Penghasilan Sebelum COVID-19</p>
          <p class="content">{{ beneficiaries.income_before }}</p>
        </div>
        <div class="preview-content">
          <p>Penghasilan Sesudah COVID-19</p>
          <p class="content">{{ beneficiaries.income_after }}</p>
        </div>
      </el-col>
      </el-col>
      <el-col :sm="24" :md="8" :lg="8">
        <p class="preview-title">Domisili Saat Ini</p>
        <div class="preview-content">
          <p>NIK</p>
          <p class="content">{{ beneficiaries.nik }}</p>
        </div>
        <div class="preview-content">
          <p>Nama</p>
          <p class="content">{{ beneficiaries.name }}</p>
        </div>
        <div class="preview-content">
          <p>Kabupaten/Kota</p>
          <p class="content">{{ beneficiaries.domicile_kabkota_bps_name }}</p>
        </div>
        <div class="preview-content">
          <p>Kecamatan</p>
          <p class="content">{{ beneficiaries.domicile_kec_bps_name }}</p>
        </div>
        <div class="preview-content">
          <p>Kelurahan</p>
          <p class="content">{{ beneficiaries.domicile_kec_kel_name }}</p>
        </div>
        <div class="preview-content">
          <p>RW</p>
          <p class="content">{{ beneficiaries.domicile_rw }}</p>
        </div>
        <div class="preview-content">
          <p>RT</p>
          <p class="content">{{ beneficiaries.domicile_rt }}</p>
        </div>
        <div class="preview-content">
          <p>Alamat</p>
          <p class="content">{{ beneficiaries.domicile_address }}</p>
        </div>
      </el-col>
    </el-row>
    <el-row>
      <p class="preview-title">Dokumen Pendukung</p>
      <el-col :sm="24" :md="12" :lg="12">
        <div class="preview-content">
          <p>Foto KTP</p>
          <img :src="beneficiaries.image_ktp_url || imageNone" alt="" width="350px" height="220px">
        </div>
      </el-col>
      <el-col :sm="24" :md="12" :lg="12">
        <div class="preview-content">
          <p>Foto Kepala Keluarga</p>
          <img :src="beneficiaries.image_kk_url || imageNone" alt="" width="350px" height="220px">
        </div>
      </el-col>
    </el-row>
    <div class="form-button">
      <el-button class="button-action" @click="back">Ubah</el-button>
      <el-button class="button-action" type="danger" @click="update('reject')">Tolak</el-button>
      <el-button class="button-action" type="success" @click="update('varification')">Verifikasi</el-button>
    </div>
  </div>
</template>
<script>
import { update } from '@/api/beneficiaries'

export default {
  props: {
    beneficiaries: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      imageNone: require('@/assets/none.png')
    }
  },
  methods: {
    async update(value) {
      console.log(value)
      if (value === 'reject') {
        this.beneficiaries.status_verification = 2
      } else {
        this.beneficiaries.status_verification = 3
      }
      delete this.beneficiaries.nik
      const id = await this.$route.params && this.$route.params.id
      await update(id, this.beneficiaries)
      this.$router.push('/beneficiaries/index')
    },
    back() {
      this.$emit('nextStep', false)
    }
  }
}
</script>
<style lang="scss" scoped>
  .preview-title {
    font-weight: bold;
    color: #67C23A;
  }
  .preview-content {
    margin-left: 10px;
    padding-top: 5px;
    .content {
      font-weight: bold;
    }
  }
  .form-button {
    margin: 100px 50px 50px 50px;
    display: block;
    float: right;
  }
  .button-action {
    margin: 0 5px;
  }
</style>

<template>
  <div class="app-container">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>Ringkasan Calon Penerima Bantuan</span>
      </div>
      <el-row v-if="beneficiaries">
        <el-col :sm="24" :md="8" :lg="8">
          <div>
            <p class="preview-title">Informasi Penerima Bantuan</p>
          </div>
          <div class="preview-content">
            <p>NIK</p>
            <p class="content">{{ beneficiaries.nik ? beneficiaries.nik : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Nama</p>
            <p class="content">{{ beneficiaries.name ? beneficiaries.name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Kabupaten/Kota</p>
            <p class="content">{{ beneficiaries.kabkota ? beneficiaries.kabkota.name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Kecamatan</p>
            <p class="content">{{ beneficiaries.kecamatan ? beneficiaries.kecamatan.name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Kelurahan</p>
            <p class="content">{{ beneficiaries.kelurahan ? beneficiaries.kelurahan.name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>RW</p>
            <p class="content">{{ beneficiaries.rw ? beneficiaries.rw : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>RT</p>
            <p class="content">{{ beneficiaries.rt ? beneficiaries.rt : '-' }}</p>
          </div>
        </el-col>
        <el-col :sm="24" :md="8" :lg="8">
          <p class="preview-title">Informasi Penghasilan</p>
          <div class="preview-content">
            <p>Pekerjaan</p>
            <p class="content">{{ beneficiaries.job_type_name ? beneficiaries.job_type_name.title : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Status Kedudukan dalam Pekerjaan</p>
            <p class="content">{{ beneficiaries.job_status_id ? beneficiaries.job_status_name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Jumlah Anggota Keluarga</p>
            <p class="content">{{ beneficiaries.total_family_members ? beneficiaries.total_family_members : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Penghasilan Sebelum COVID-19</p>
            <p class="content">{{ beneficiaries.income_before ? beneficiaries.income_before : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Penghasilan Sesudah COVID-19</p>
            <p class="content">{{ beneficiaries.income_after ? beneficiaries.income_after : '-' }}</p>
          </div>
        </el-col>
        <el-col :sm="24" :md="8" :lg="8">
          <p class="preview-title">Domisili Saat Ini</p>
          <div class="preview-content">
            <p>NIK</p>
            <p class="content">{{ beneficiaries.nik ? beneficiaries.nik : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Nama</p>
            <p class="content">{{ beneficiaries.name ? beneficiaries.name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Kabupaten/Kota</p>
            <p class="content">{{ beneficiaries.domicile_kabkota_bps_name ? beneficiaries.domicile_kabkota_bps_name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Kecamatan</p>
            <p class="content">{{ beneficiaries.domicile_kec_bps_name ? beneficiaries.domicile_kec_bps_name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Kelurahan</p>
            <p class="content">{{ beneficiaries.domicile_kec_kel_name ? beneficiaries.domicile_kec_kel_name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>RW</p>
            <p class="content">{{ beneficiaries.domicile_rw ? beneficiaries.domicile_rw : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>RT</p>
            <p class="content">{{ beneficiaries.domicile_rt ? beneficiaries.domicile_rt : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Alamat</p>
            <p class="content">{{ beneficiaries.domicile_address ? beneficiaries.domicile_address : '-' }}</p>
          </div>
        </el-col>
      </el-row>
      <el-row>
        <p class="preview-title">Dokumen Pendukung</p>
        <el-col :sm="24" :md="12" :lg="12">
          <div class="preview-content">
            <p>Foto KTP</p>
            <img :src="beneficiaries.image_ktp_url === null ? imageNone : beneficiaries.image_ktp_url" alt="" width="350px" height="220px">
          </div>
        </el-col>
      </el-row>
      <div class="form-button">
        <el-button class="button-action" @click="back">Ubah</el-button>
        <el-button class="button-action" type="danger" @click="update('reject')">Tolak</el-button>
        <el-button class="button-action" type="success" @click="update('varification')">Verifikasi</el-button>
      </div>
    </el-card>
  </div>
</template>
<script>
import { update, fetchRecord } from '@/api/beneficiaries'

export default {
  // props: {
  //   beneficiaries: {
  //     type: Object,
  //     default: null
  //   }
  // },
  data() {
    return {
      imageNone: require('@/assets/none.png'),
      beneficiaries: {
        image_ktp_url: null
      }
    }
  },
  created() {
    const id = this.$route.params && this.$route.params.id
    this.getDetail(id)
  },
  methods: {
    getDetail(id) {
      fetchRecord(id).then(response => {
        this.beneficiaries = response.data
        this.beneficiaries.image_ktp_url = response.data.image_ktp_url
      })
    },
    async update(value) {
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
    margin: 70px 50px 50px 50px;
    display: block;
    float: right;
  }
  .button-action {
    margin: 0 5px;
  }
</style>

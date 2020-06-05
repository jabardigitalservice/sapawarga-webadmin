<template>
  <div class="app-container">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span><b>Detail Calon Penerima Bantuan</b></span>
      </div>
      <el-row v-if="beneficiaries">
        <div v-if="isVerval === false">
          <p v-if="beneficiaries.status_verification === 3" class="warn-content">Status: {{ beneficiaries.status_verification_label }}</p>
          <p v-else-if="beneficiaries.status_verification === 2" class="warn-content-danger">Status: {{ beneficiaries.status_verification_label }}</p>
          <p v-else-if="beneficiaries.status_verification === 1" class="warn-content-warning">Status: {{ beneficiaries.status_verification_label }}</p>
        </div>
        <el-col :sm="24" :md="8" :lg="8">
          <div>
            <p class="preview-title">Informasi Penerima Bantuan</p>
          </div>
          <div class="preview-content">
            <p>NIK</p>
            <p class="content">{{ beneficiaries.nik ? beneficiaries.nik : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Nomor KK</p>
            <p class="content">{{ beneficiaries.no_kk ? beneficiaries.no_kk : '-' }}</p>
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
            <p class="content">{{ beneficiaries.job_status_id ? beneficiaries.job_status_name.title : '-' }}</p>
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
            <p>Kabupaten/Kota</p>
            <p class="content">{{ beneficiaries.domicile_kabkota_name ? beneficiaries.domicile_kabkota_name.name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Kecamatan</p>
            <p class="content">{{ beneficiaries.domicile_kec_name ? beneficiaries.domicile_kec_name.name : '-' }}</p>
          </div>
          <div class="preview-content">
            <p>Kelurahan</p>
            <p class="content">{{ beneficiaries.domicile_kel_name ? beneficiaries.domicile_kel_name.name : '-' }}</p>
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
        <el-button type="info" class="button-action" @click="back">Kembali</el-button>
        <el-button v-if="isVerval === false && beneficiaries.status_verification !== 1" type="primary" class="button-action" @click="updateForm('edit/' + beneficiaries.id)">Update Data</el-button>
        <el-button v-if="isVerval === false && beneficiaries.status_verification === 1" type="success" class="button-action" @click="updateForm('verification/' + beneficiaries.id)">Verifikasi Data</el-button>
        <el-button v-if="rolesKel && beneficiaries.status_verification === 3 || rolesKec && beneficiaries.status_verification === 5 || rolesKabkota && beneficiaries.status_verification === 7" class="button-action" type="success" @click="validate(beneficiaries.id)">Setujui</el-button>
      </div>
    </el-card>
  </div>
</template>
<script>
import { update, fetchRecord, validateStaffKelBulk } from '@/api/beneficiaries'
import checkPermission from '@/utils/permission'
import { RolesUser } from '@/utils/constantVariable'

export default {
  props: {
    isVerval: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      imageNone: require('@/assets/none.png'),
      id: null,
      rolesKel: checkPermission([RolesUser.STAFFKEL]),
      rolesKec: checkPermission([RolesUser.STAFFKEC]),
      rolesKabkota: checkPermission([RolesUser.STAFFKABKOTA]),
      beneficiaries: {
        image_ktp_url: null
      }
    }
  },
  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail(this.id)
  },
  methods: {
    checkPermission,
    updateForm(value) {
      this.$router.push('/beneficiaries/' + value)
    },
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
      this.$router.go(-1)
    },
    async validate(id) {
      try {
        await this.$confirm(this.$t('crud.approval-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        await validateStaffKelBulk(id)

        this.$message.success(this.$t('crud.approval-success'))

        this.$router.push('/beneficiaries/pending')
      } catch (e) {
        console.log(e)
      }
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
  .warn-content-danger {
    background: #fef0f0;
    border-radius: 2px;
    padding: 16px;
    padding: 1rem;
    line-height: 1.6rem;
    word-spacing: .05rem;
    margin-bottom: 25px;
    color: #f56c6c;
    font-weight: 600;
  }
  .warn-content-warning {
    background: #fdf6ec;
    border-radius: 2px;
    padding: 16px;
    padding: 1rem;
    line-height: 1.6rem;
    word-spacing: .05rem;
    margin-bottom: 25px;
    color: #e6a23c;
    font-weight: 600;
  }
</style>

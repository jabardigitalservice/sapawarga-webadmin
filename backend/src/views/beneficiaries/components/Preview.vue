<template>
  <div v-loading="loading" class="app-container">
    <el-row v-if="beneficiaries">
      <div v-if="isVerval === false">
        <p v-if="beneficiaries.status_verification === 3" class="warn-content">Status: {{ beneficiaries.status_verification_label }}</p>
        <p v-else-if="beneficiaries.status_verification === 2" class="warn-content-danger">Status: {{ beneficiaries.status_verification_label }}</p>
        <p v-else-if="beneficiaries.status_verification === 1" class="warn-content-warning">Status: {{ beneficiaries.status_verification_label }}</p>
      </div>
      <el-col class="side-col" :sm="24" :md="8" :lg="8">
        <div>
          <p class="preview-title">{{ $t('label.beneficiaries-info-personal') }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-nik') }}</p>
          <p class="content">{{ beneficiaries.nik ? beneficiaries.nik : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-kk') }}</p>
          <p class="content">{{ beneficiaries.no_kk ? beneficiaries.no_kk : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-name') }}</p>
          <p class="content">{{ beneficiaries.name ? beneficiaries.name : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-domicile-kabkota') }}</p>
          <p class="content">{{ beneficiaries.kabkota ? beneficiaries.kabkota.name : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-domicile-kecamatan') }}</p>
          <p class="content">{{ beneficiaries.kecamatan ? beneficiaries.kecamatan.name : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-domicile-kelurahan') }}</p>
          <p class="content">{{ beneficiaries.kelurahan ? beneficiaries.kelurahan.name : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-rw') }}</p>
          <p class="content">{{ beneficiaries.rw ? beneficiaries.rw : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-rt') }}</p>
          <p class="content">{{ beneficiaries.rt ? beneficiaries.rt : '-' }}</p>
        </div>
      </el-col>
      <el-col :sm="24" :md="8" :lg="8">
        <p class="preview-title">{{ $t('label.beneficiaries-info-income') }}</p>
        <div class="preview-content">
          <p>{{ $t('label.job') }}</p>
          <p class="content">{{ beneficiaries.job_type_name ? beneficiaries.job_type_name.title : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-job-status') }}</p>
          <p class="content">{{ beneficiaries.job_status_id ? beneficiaries.job_status_name.title : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-total-family') }}</p>
          <p class="content">{{ beneficiaries.total_family_members ? beneficiaries.total_family_members : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-income-before') }}</p>
          <p class="content">{{ beneficiaries.income_before ? formatCurrency(beneficiaries.income_before, 'Rp. ') : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-income-after') }}</p>
          <p class="content">{{ beneficiaries.income_after ? formatCurrency(beneficiaries.income_after, 'Rp. ') : '-' }}</p>
        </div>
      </el-col>
      <el-col class="side-col" :sm="24" :md="8" :lg="8">
        <p class="preview-title">{{ $t('label.beneficiaries-info-domicile') }}</p>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-domicile-kabkota') }}</p>
          <p class="content">{{ beneficiaries.domicile_kabkota_name ? beneficiaries.domicile_kabkota_name.name : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-domicile-kecamatan') }}</p>
          <p class="content">{{ beneficiaries.domicile_kec_name ? beneficiaries.domicile_kec_name.name : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-domicile-kelurahan') }}</p>
          <p class="content">{{ beneficiaries.domicile_kel_name ? beneficiaries.domicile_kel_name.name : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-rw') }}</p>
          <p class="content">{{ beneficiaries.domicile_rw ? beneficiaries.domicile_rw : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-rt') }}</p>
          <p class="content">{{ beneficiaries.domicile_rt ? beneficiaries.domicile_rt : '-' }}</p>
        </div>
        <div class="preview-content">
          <p>{{ $t('label.address') }}</p>
          <p class="content">{{ beneficiaries.domicile_address ? beneficiaries.domicile_address : '-' }}</p>
        </div>
      </el-col>
    </el-row>
    <el-row>
      <el-col class="side-col" :sm="24" :md="12" :lg="12">
        <p class="preview-title">{{ $t('label.beneficiaries-document') }}</p>
        <div class="preview-content">
          <p>{{ $t('label.beneficiaries-image-ktp') }}</p>
          <img :src="beneficiaries.image_ktp_url === null ? imageNone : beneficiaries.image_ktp_url" alt="" width="350px" height="220px">
        </div>
      </el-col>
      <el-col>
        <div class="form-button">
          <el-button type="info" class="button-action" @click="back">{{ $t('crud.back') }}</el-button>
          <el-button v-if="isVerval === false && beneficiaries.status_verification !== 1" type="primary" class="button-action" @click="updateForm('edit/' + beneficiaries.id)">{{ $t('crud.update-data') }}</el-button>
          <el-button v-if="isVerval === false && beneficiaries.status_verification === 1" type="success" class="button-action" @click="updateForm('verification/' + beneficiaries.id)">{{ $t('crud.verified') }}</el-button>
          <el-button v-if="rolesKel && beneficiaries.status_verification === 3 || rolesKec && beneficiaries.status_verification === 5 || rolesKabkota && beneficiaries.status_verification === 7" class="button-action" type="success" @click="validate(beneficiaries.id)">{{ $t('crud.approved') }}</el-button>
        </div>
      </el-col>
    </el-row>
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
    },
    idDetail: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      imageNone: require('@/assets/none.png'),
      id: null,
      loading: false,
      rolesKel: checkPermission([RolesUser.STAFFKEL]),
      rolesKec: checkPermission([RolesUser.STAFFKEC]),
      rolesKabkota: checkPermission([RolesUser.STAFFKABKOTA]),
      beneficiaries: {
        image_ktp_url: null
      }
    }
  },

  watch: {
    idDetail(val1, val2) {
      this.getDetail(this.idDetail)
    }
  },

  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail(this.idDetail)
  },

  methods: {
    checkPermission,
    updateForm(value) {
      this.$router.push('/beneficiaries/' + value)
    },

    getDetail(id) {
      this.loading = true
      fetchRecord(id).then(response => {
        this.beneficiaries = response.data
        this.beneficiaries.image_ktp_url = response.data.image_ktp_url
        this.loading = false
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
      this.$emit('closeDialog', false)
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

        // this.$router.push('/beneficiaries/approved')
        this.$emit('closeDialog', 'reload')
      } catch (e) {
        console.log(e)
      }
    },

    formatCurrency(value, prefix) {
      if (value) {
        const number_string = value.toString()
        const split = number_string.split(',')
        const modulo = split[0].length % 3
        let rupiah = split[0].substr(0, modulo)
        const thousand = split[0].substr(modulo).match(/\d{3}/gi)

        if (thousand) {
          const separator = modulo ? '.' : ''
          rupiah += separator + thousand.join('.')
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah
        return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '')
      } else {
        return 'Rp. 0'
      }
    }
  }
}
</script>
<style lang="scss" scoped>
  .preview-title {
    font-size: 17px;
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
    margin: 70px 50px 20px 50px;
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

  .side-col {
    padding-left: 35px;
  }
</style>

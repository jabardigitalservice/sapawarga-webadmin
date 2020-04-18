<template>
  <div class="components-container">
    <div class="warning">
      <p v-if="isCreate" class="caution">Masukan NIK atau Nomor KTP warga yang akan didaftarkan sebagai calon penerima bantuan sosial terdampak covid di Desa/Kelurahan Anda.</p>
      <p v-else class="caution">Berikut adalah data calon penerima bantuan yang ada di wilayah Desa/Kelurahan <span v-if="beneficiaries.domicile_kel_name !== null">{{ beneficiaries.domicile_kel_name.name }}</span> Kec. <span v-if="beneficiaries.domicile_kec_name !== null">{{ beneficiaries.domicile_kec_name.name }}</span> Kota/Kabupaten <span v-if="beneficiaries.domicile_kabkota_name !== null">{{ beneficiaries.domicile_kabkota_name.name }}</span> </p>
    </div>
    <el-form
      ref="beneficiaries"
      v-loading="loading"
      :model="beneficiaries"
      :rules="rules"
      :status-icon="true"
      label-width="150px"
      label-position="left"
    >
      <el-form-item label="NIK" prop="nik">
        <el-input v-model="beneficiaries.nik" type="number" placeholder="NIK" :disabled="disableField" @input="getNik" />
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik" label="Nama" prop="name">
        <el-input v-model="beneficiaries.name" placeholder="Nama Lengkap" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik && isCreate" label="Kabupaten/Kota" prop="kabkota" class="block">
        <el-select v-model="beneficiaries.kabkota" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kabkotaList"
            :key="item.code_bps"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item v-if=" !isAutomatedNik && isCreate" label="Kecamatan" prop="kecamatan" class="block">
        <el-select v-model="beneficiaries.kecamatan" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kecList"
            :key="item.code_bps"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik && isCreate" label="Kelurahan" prop="kelurahan" class="block">
        <el-select v-model="beneficiaries.kelurahan" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kelList"
            :key="item.code_bps"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik && !isCreate" label="Alamat" prop="domicile_address">
        <el-input v-model="beneficiaries.domicile_address" placeholder="Alamat" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik && !isCreate" label="RW" prop="domicile_rw">
        <el-input v-model="beneficiaries.domicile_rw" type="number" placeholder="RW" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik && !isCreate" label="RT" prop="domicile_rt">
        <el-input v-model="beneficiaries.domicile_rt" type="number" placeholder="RT" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik && isCreate" label="RW" prop="rw">
        <el-input v-model="beneficiaries.rw" type="number" placeholder="RW" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik && isCreate" label="RT" prop="rt">
        <el-input v-model="beneficiaries.rt" type="number" placeholder="RT" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isAutomatedNik && !isCreate" label="Pekerjaan" prop="job_type_id">
        <el-select v-model="beneficiaries.job_type_id" style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in jobList"
            :key="item.id"
            :label="item.title"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item class="ml-min-40 form-button">
        <div v-if="!isCreate">Apakah benar informasi calon penerima bantuan ini berdomisili di desa Anda?</div>
        <el-button v-if="!isCreate" class="button-action" type="primary" plain @click="rejectData">{{ $t('crud.not-valid') }}</el-button>
        <el-button class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { getKecamatanBpsList, getKelurahanBpsList, getKabkotaList } from '@/api/areas'
import { fetchListJob, update, fetchNik } from '@/api/beneficiaries'

export default {
  props: {
    beneficiaries: {
      type: Object,
      default: null
    },
    isCreate: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const checkStartNumber = (rule, value, callback) => {
      const phoneStringFormat = value.toString()
      const checkStringPhone = phoneStringFormat.startsWith('0')
      if (checkStringPhone) {
        callback(new Error(this.$t('errors.rw-start-number')))
      } else {
        callback()
      }
    }
    return {
      loading: false,
      isAutomatedNik: true,
      staticAutomated: true,
      disableField: false,
      jobList: null,
      kabkotaList: null,
      kecList: null,
      kelList: null,
      rules: {
        name: [
          {
            required: true,
            message: 'Nama harus diisi',
            trigger: 'blur'
          }
        ],
        nik: [
          {
            required: true,
            message: 'NIK harus diisi',
            trigger: 'blur'
          },
          {
            max: 16,
            message: 'NIK harus 16 karakter',
            trigger: 'blur'
          },
          {
            min: 16,
            message: 'NIK harus 16 karakter',
            trigger: 'blur'
          }
        ],
        kabkota: [
          {
            required: false,
            message: 'Kabupaten/Kota harus diisi',
            trigger: 'change'
          }
        ],
        kecamatan: [
          {
            required: false,
            message: 'Kecamatan harus diisi',
            trigger: 'change'
          }
        ],
        kelurahan: [
          {
            required: false,
            message: 'Kelurahan harus diisi',
            trigger: 'change'
          }
        ],
        rw: [
          {
            required: true,
            message: 'RW harus diisi',
            trigger: 'blur'
          },
          {
            validator: checkStartNumber,
            trigger: 'blur'
          }
        ],
        rt: [
          {
            required: true,
            message: 'RT harus diisi',
            trigger: 'blur'
          },
          {
            validator: checkStartNumber,
            trigger: 'blur'
          }
        ],
        domicile_address: [
          {
            required: true,
            message: 'Alamat harus diisi',
            trigger: 'blur'
          }
        ],
        job_type_id: [
          {
            required: true,
            message: 'Pekerjaan harus diisi',
            trigger: 'blur'
          }
        ],
        domicile_rw: [
          {
            required: true,
            message: 'RW harus diisi',
            trigger: 'blur'
          }
        ],
        domicile_rt: [
          {
            required: true,
            message: 'RT harus diisi',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  watch: {
    'beneficiaries.kabkota'(value1, value2) {
      if (this.isCreate && !this.staticAutomated) {
        if (value1 !== value2) {
          this.beneficiaries.kecamatan = null
          this.beneficiaries.kelurahan = null
          this.beneficiaries.kabkota_id = value1.id
          this.beneficiaries.kabkota_bps_id = value1.code_bps
          this.getKecamatan(value1.code_bps)
        }
      }
    },
    'beneficiaries.kecamatan'(value1, value2) {
      if (this.isCreate && !this.staticAutomated) {
        if (value1 !== value2) {
          this.beneficiaries.kelurahan = null
          this.getKelurahan(value1.code_bps)
          this.beneficiaries.kec_id = value1.id
          this.beneficiaries.kec_bps_id = value1.code_bps
        }
      }
    },
    'beneficiaries.kelurahan'(value1, value2) {
      if (this.isCreate && !this.staticAutomated) {
        if (value1 !== value2) {
          this.beneficiaries.kel_id = value1.id
          this.beneficiaries.kel_bps_id = value1.code_bps
        }
      }
    }
  },
  async mounted() {
    this.getArea()
    this.getJob()
    if (this.beneficiaries.kabkota_id !== null) this.getKecamatan(this.beneficiaries.kabkota_bps_id)
    if (this.beneficiaries.kec_id !== null) this.getKelurahan(this.beneficiaries.kec_bps_id)
  },
  methods: {
    async next() {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }
      this.$emit('nextStep', 1)
    },
    async rejectData() {
      const id = await this.$route.params && this.$route.params.id
      await this.$confirm(this.$t('message.confirmation-reject-data'), 'Peringatan', {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'warning'
      })
      delete this.beneficiaries.nik
      this.beneficiaries.status_verification = 2
      await update(id, this.beneficiaries)
      this.$message.info('Status berhasil diubah')
      this.$router.push('/beneficiaries/index')
    },
    getJob() {
      fetchListJob().then(response => {
        this.jobList = response.data.items.job_field
      })
    },
    getArea() {
      getKabkotaList().then(response => {
        this.kabkotaList = response.data.items
      })
    },
    getKecamatan(value) {
      getKecamatanBpsList(value).then(response => {
        this.kecList = response.data.items
      })
    },
    getKelurahan(value) {
      getKelurahanBpsList(value).then(response => {
        this.kelList = response.data.items
      })
    },
    getNik(item) {
      this.loading = true
      fetchNik(item).then(response => {
        Object.assign(this.beneficiaries, response.data)
        this.getKecamatan(this.beneficiaries.kabkota_bps_id)
        this.getKelurahan(this.beneficiaries.kec_bps_id)
        this.isAutomatedNik = false
        this.disableField = true
        this.loading = false
      }).catch(err => {
        console.log(err)
        this.isAutomatedNik = true
        this.loading = false
      })
    }
  }
}
</script>
<style lang="scss" scoped>
  .caution {
    font-size: 15px;
    padding: 10px 0;
    margin: 10px 0;
    line-height: 150%;
  }
  .warning {
    margin-bottom: 35px;
  }
  .button-action {
    margin: 0 5px;
  }
  .form-button {
    margin-top: 50px;
  }
</style>

<template>
  <div class="components-container">
    <div class="warning">
      <p v-if="isCreate" class="caution">{{ $t('beneficiaries.guide') }}</p>
      <p v-else class="caution">{{ $t('beneficiaries.verification-area-note') }} {{ $t('beneficiaries.kel') }} <span v-if="beneficiaries.domicile_kel_name !== null">{{ beneficiaries.domicile_kel_name.name }}</span> {{ $t('beneficiaries.kec') }} <span v-if="beneficiaries.domicile_kec_name !== null">{{ beneficiaries.domicile_kec_name.name }}</span> {{ $t('beneficiaries.kabkota') }} <span v-if="beneficiaries.domicile_kabkota_name !== null">{{ beneficiaries.domicile_kabkota_name.name }}</span> </p>
    </div>
    <el-form
      ref="beneficiaries"
      v-loading="loading"
      :model="beneficiaries"
      :rules="rules"
      :status-icon="true"
      label-width="250px"
      label-position="left"
    >
      <el-form-item v-if="isCreate" :label="$t('beneficiaries.is-have-nik')" prop="is_have_ktp">
        <el-radio-group v-model="beneficiaries.is_have_ktp">
          <el-radio class="label-check" :label="1">{{ $t('beneficiaries.nik-yes') }}</el-radio>
          <el-radio class="label-check" :label="0">{{ $t('beneficiaries.nik-no') }}</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="isCreate && beneficiaries.is_have_ktp === 1" :label="$t('beneficiaries.nik')" prop="nik">
        <el-input v-model="beneficiaries.nik" type="number" placeholder="NIK" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isCreate && !isEditDomicile" label="NIK">
        <el-input v-model="beneficiaries.nik" type="number" :placeholder="$t('beneficiaries.nik')" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isCreate || beneficiaries.is_have_ktp === 1" :label="$t('beneficiaries.kk')" prop="no_kk">
        <el-input v-model="beneficiaries.no_kk" type="number" :placeholder="$t('beneficiaries.kk')" />
      </el-form-item>
      <el-form-item :label="$t('beneficiaries.full-name')" prop="name">
        <el-input v-model="beneficiaries.name" :placeholder="$t('beneficiaries.full-name')" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="isCreate && beneficiaries.is_have_ktp === 0" :label="$t('beneficiaries.nik-note')" prop="notes_nik_empty">
        <el-input v-model="beneficiaries.notes_nik_empty" type="textarea" rows="3" :placeholder="$t('beneficiaries.nik-note')" />
      </el-form-item>
      <el-form-item v-if="isAutomatedNik && isCreate" :label="$t('beneficiaries.province')" prop="province_bps_id">
        <el-select v-model="beneficiaries.province_bps_id" style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in proviceList"
            :key="item.code_bps"
            :label="item.name"
            :value="item.code_bps"
          />
        </el-select>
      </el-form-item>
      <el-form-item v-if="isAutomatedNik && isCreate" :label="$t('beneficiaries.kabkota')" prop="kabkota" class="block">
        <el-select v-model="beneficiaries.kabkota" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kabkotaList"
            :key="item.code_bps"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item v-if="isAutomatedNik && isCreate" :label="$t('beneficiaries.kec')" prop="kecamatan" class="block">
        <el-select v-model="beneficiaries.kecamatan" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kecList"
            :key="item.code_bps"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item v-if="isAutomatedNik && isCreate" :label="$t('beneficiaries.kel')" prop="kelurahan" class="block">
        <el-select v-model="beneficiaries.kelurahan" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kelList"
            :key="item.code_bps"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item v-if="!isCreate" :label="$t('beneficiaries.address')" prop="domicile_address">
        <el-input v-model="beneficiaries.domicile_address" placeholder="Alamat" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isCreate && !isEdit" :label="$t('beneficiaries.rw')">
        <el-input v-model="beneficiaries.domicile_rw" type="number" :placeholder="$t('beneficiaries.rw')" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="isEdit" :label="$t('beneficiaries.rw')" prop="domicile_rw">
        <el-input v-model="beneficiaries.domicile_rw" type="number" :placeholder="$t('beneficiaries.rw')" />
      </el-form-item>
      <el-form-item v-if="isEdit" :label="$t('beneficiaries.rt')" prop="domicile_rt">
        <el-input v-model="beneficiaries.domicile_rt" type="number" :placeholder="$t('beneficiaries.rt')" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="!isCreate && !isEdit" :label="$t('beneficiaries.rt')">
        <el-input v-model="beneficiaries.domicile_rt" type="number" :placeholder="$t('beneficiaries.rt')" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="isAutomatedNik && isCreate" :label="$t('beneficiaries.address')" prop="address">
        <el-input v-model="beneficiaries.address" :placeholder="$t('beneficiaries.address')" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="isAutomatedNik && isCreate" :label="$t('beneficiaries.rw')" prop="rw">
        <el-input v-model="beneficiaries.rw" type="number" :placeholder="$t('beneficiaries.rw')" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="isAutomatedNik && isCreate" :label="$t('beneficiaries.rt')" prop="rt">
        <el-input v-model="beneficiaries.rt" type="number" :placeholder="$t('beneficiaries.rt')" :disabled="disableField" />
      </el-form-item>
      <el-form-item v-if="isEditDomicile" class="ml-min-40 form-button">
        <div v-if="!isCreate">{{ $t('beneficiaries.is-data-true') }}</div>
        <el-button class="button-action" type="primary" @click="updateDomicile(beneficiaries.id)"> {{ $t('crud.save-create') }}</el-button>
      </el-form-item>
      <el-form-item v-else class="ml-min-40 form-button">
        <div v-if="!isCreate">{{ $t('beneficiaries.is-data-true') }}</div>
        <el-button v-if="!isCreate" class="button-action" type="danger" @click="rejectData">{{ $t('crud.not-valid') }}</el-button>
        <el-button class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { getKecamatanBpsList, getKelurahanBpsList, getKabkotaList } from '@/api/areas'
import { update, fetchNik, checkNik, validateKK, checkAddress } from '@/api/beneficiaries'

export default {
  props: {
    beneficiaries: {
      type: Object,
      default: null
    },
    isCreate: {
      type: Boolean,
      default: false
    },
    isEdit: {
      type: Boolean,
      default: false
    },
    isEditDomicile: {
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
      isNikChange: false,
      isKKChange: false,
      isAddress: false,
      isAutomatedNik: true,
      staticAutomated: true,
      disableField: false,
      kabkotaList: null,
      kecList: null,
      kelList: null,
      proviceList: [
        {
          name: this.$t('beneficiaries.province-jabar'),
          code_bps: 32
        }
      ],
      rules: {
        name: [
          {
            required: true,
            message: this.$t('beneficiaries.name-required'),
            trigger: 'input'
          },
          {
            min: 3,
            message: this.$t('beneficiaries.name-min'),
            trigger: 'input'
          }
        ],
        nik: [
          {
            required: true,
            message: this.$t('beneficiaries.nik-required'),
            trigger: 'input'
          },
          {
            min: 16,
            message: this.$t('beneficiaries.nik-min'),
            trigger: 'input'
          },
          {
            max: 16,
            message: this.$t('beneficiaries.nik-min'),
            trigger: 'input'
          }
        ],
        no_kk: [
          {
            required: true,
            message: this.$t('beneficiaries.kk-required'),
            trigger: 'input'
          }
        ],
        province_bps_id: [
          {
            required: true,
            message: this.$t('beneficiaries.province-required'),
            trigger: 'change'
          }
        ],
        kabkota: [
          {
            required: true,
            message: this.$t('beneficiaries.kabkota-required'),
            trigger: 'change'
          }
        ],
        kecamatan: [
          {
            required: true,
            message: this.$t('beneficiaries.kec-required'),
            trigger: 'change'
          }
        ],
        kelurahan: [
          {
            required: true,
            message: this.$t('beneficiaries.kel-required'),
            trigger: 'change'
          }
        ],
        rw: [
          {
            required: true,
            message: this.$t('beneficiaries.rw-required'),
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
            message: this.$t('beneficiaries.rt-required'),
            trigger: 'blur'
          },
          {
            validator: checkStartNumber,
            trigger: 'blur'
          }
        ],
        address: [
          {
            required: true,
            message: this.$t('beneficiaries.address-required'),
            trigger: 'blur'
          }
        ],
        domicile_address: [
          {
            required: true,
            message: this.$t('beneficiaries.address-required'),
            trigger: 'blur'
          }
        ],
        domicile_rw: [
          {
            required: true,
            message: this.$t('beneficiaries.rw-required'),
            trigger: 'blur'
          },
          {
            validator: checkStartNumber,
            trigger: 'blur'
          }
        ],
        domicile_rt: [
          {
            required: true,
            message: this.$t('beneficiaries.rt-required'),
            trigger: 'blur'
          },
          {
            validator: checkStartNumber,
            trigger: 'blur'
          }
        ],
        notes_nik_empty: [
          {
            required: true,
            message: this.$t('beneficiaries.excuse-required'),
            trigger: 'input'
          }
        ]
      }
    }
  },
  watch: {
    'beneficiaries.nik'(value1, value2) {
      if (value1) this.isNikChange = true
    },
    'beneficiaries.no_kk'(value1, value2) {
      if (value1) this.isKKChange = true
    },
    'beneficiaries.name'(value1, value2) {
      if (value1) this.isAddress = true
    },
    'beneficiaries.domicile_rt'(value1, value2) {
      if (value1) this.isAddress = true
    },
    'beneficiaries.domicile_rw'(value1, value2) {
      if (value1) this.isAddress = true
    },
    'beneficiaries.domicile_address'(value1, value2) {
      if (value1) this.isAddress = true
    },
    'beneficiaries.kabkota'(value1, value2) {
      if (this.isCreate) {
        this.beneficiaries.kecamatan = null
        this.beneficiaries.kelurahan = null
        this.beneficiaries.kabkota_id = value1.id
        this.beneficiaries.kabkota_bps_id = value1.code_bps
        this.getKecamatan(value1.code_bps)
      }
    },
    'beneficiaries.kecamatan'(value1, value2) {
      if (this.isCreate) {
        this.beneficiaries.kelurahan = null
        this.getKelurahan(value1.code_bps)
        this.beneficiaries.kec_id = value1.id
        this.beneficiaries.kec_bps_id = value1.code_bps
      }
    },
    'beneficiaries.kelurahan'(value1, value2) {
      if (this.isCreate) {
        this.beneficiaries.kel_id = value1.id
        this.beneficiaries.kel_bps_id = value1.code_bps
      }
    }
  },
  async mounted() {
    if (this.isCreate === false && this.isEdit === false) {
      this.disableField = true
    } else if (this.isEdit === true) {
      this.disableField = false
    }
    this.isAutomatedNik = false
    this.getArea()
    if (this.beneficiaries.kabkota_id !== null) this.getKecamatan(this.beneficiaries.kabkota_bps_id)
    if (this.beneficiaries.kec_id !== null) this.getKelurahan(this.beneficiaries.kec_bps_id)
  },
  methods: {
    async updateDomicile(id) {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }

      try {
        await update(id, this.beneficiaries)
      } catch (error) {
        console.log(error)
      }

      this.$emit('closeDialog', false)
    },
    async next() {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }

      if (this.isCreate && this.beneficiaries.is_have_ktp === 1) {
        this.checkValidate(1)
      } else if (this.isEdit && this.isAddress) {
        this.validateAddress(1)
      } else if (this.isEdit && this.beneficiaries.is_nik_valid === 0) {
        if (this.isEdit && this.isNikChange) {
          if (this.beneficiaries.nik && this.beneficiaries.nik.length < 16) {
            this.$message.error(this.$t('beneficiaries.nik-min'))
            return
          }
          this.checkNikSapawarga(2)
        } else if (this.isEdit && this.isKKChange) {
          // konfirmasi tambahin minimal 16 karakter
          this.validateKK(2)
        } else if (this.isEdit && this.isKKChange && this.isNikChange) {
          // konfirmasi tambahin minimal 16 karakter
          this.checkValidate(2)
        } else if (this.isEdit && this.isNikChange && this.isAddress) {
          // ini untuk validasi nik dan address
          this.validateNikAndAddress(2)
        } else if (this.isEdit && this.isKKChange && this.isAddress) {
          // ini untuk validasi kk dan address
          this.validateKKAndAddress(2)
        } else if (this.isEdit && this.isNikChange && this.isKKChange && this.isAddress) {
          // ini untuk validasi nik, kk, address
          this.validateNikAndKKandAddress(2)
        } else {
          this.$emit('nextStep', 1)
        }
      } else if (this.isEdit && this.beneficiaries.is_nik_valid === 1) {
        if (this.isEdit && this.isNikChange) {
          if (this.beneficiaries.nik && this.beneficiaries.nik.length < 16) {
            this.$message.error(this.$t('beneficiaries.nik-min'))
            return
          }
          this.checkNikSapawarga(1)
        } else if (this.isEdit && this.isKKChange) {
          // konfirmasi tambahin minimal 16 karakter
          this.validateKK(1)
        } else if (this.isEdit && this.isKKChange && this.isNikChange) {
          // konfirmasi tambahin minimal 16 karakter
          this.checkValidate(1)
        } else if (this.isEdit && this.isNikChange && this.isAddress) {
          // ini untuk validasi nik dan address
          this.validateNikAndAddress(1)
        } else if (this.isEdit && this.isKKChange && this.isAddress) {
          // ini untuk validasi kk dan address
          this.validateKKAndAddress(1)
        } else if (this.isEdit && this.isNikChange && this.isKKChange && this.isAddress) {
          // ini untuk validasi nik, kk, address
          this.validateNikAndKKandAddress(1)
        } else {
          this.$emit('nextStep', 1)
        }
      } else {
        this.$emit('nextStep', 1)
      }
    },

    validateInput(input) {
      if (_.isEmpty(input)) {
        return this.$t('beneficiaries.note-required')
      }

      return true
    },
    async rejectData() {
      const id = await this.$route.params && this.$route.params.id
      const prompt = await this.$prompt(this.$t('beneficiaries.excuse'), this.$t('beneficiaries.reject-bansos'), {
        confirmButtonText: this.$t('common.send'),
        cancelButtonText: this.$t('common.cancel'),
        inputPlaceholder: this.$t('beneficiaries.notes'),
        inputValidator: this.validateInput
      })

      this.beneficiaries.notes_rejected = prompt.value
      this.beneficiaries.status_verification = 2
      await update(id, this.beneficiaries)
      this.$message.info(this.$t('beneficiaries.status-success'))
      this.$router.push('/beneficiaries/index')
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
    checkNikSapawarga(value) {
      checkNik(this.beneficiaries.nik).then(response => {
        if (response.data === true) {
          this.$message.error('NIK ' + this.beneficiaries.nik + ' sudah terdaftar')
          this.$refs.beneficiaries.resetFields()
          return
        } else {
          this.$emit('nextStep', value)
        }
      })
    },
    validateKK(value) {
      validateKK(this.beneficiaries.no_kk).then(response => {
        if (response.data === true) {
          this.$message.error('Nomor KK ' + this.beneficiaries.no_kk + ' sudah terdaftar')
          this.$refs.beneficiaries.resetFields()
          return
        } else {
          this.$emit('nextStep', value)
        }
      })
    },
    checkValidate(value) {
      checkNik(this.beneficiaries.nik).then(response => {
        if (response.data === true) {
          this.$message.error('NIK ' + this.beneficiaries.nik + ' sudah terdaftar')
          this.$refs.beneficiaries.resetFields()
          return
        } else {
          validateKK(this.beneficiaries.no_kk).then(response => {
            if (response.data === true) {
              this.$message.error('Nomor KK ' + this.beneficiaries.no_kk + ' sudah terdaftar')
              this.$refs.beneficiaries.resetFields()
              return
            } else {
              this.$emit('nextStep', value)
            }
          })
        }
      })
    },
    async validateAddress(value) {
      const data = {
        name: this.beneficiaries.name,
        domicile_province_bps_id: this.beneficiaries.domicile_province_bps_id,
        domicile_kabkota_bps_id: this.beneficiaries.domicile_kabkota_bps_id,
        domicile_kec_bps_id: this.beneficiaries.domicile_kec_bps_id,
        domicile_kel_bps_id: this.beneficiaries.domicile_kel_bps_id,
        domicile_rt: this.beneficiaries.domicile_rt,
        domicile_rw: this.beneficiaries.domicile_rw,
        domicile_address: this.beneficiaries.domicile_address
      }
      try {
        await checkAddress(data)
        this.$emit('nextStep', value)
      } catch {
        this.$message.error(this.$t('beneficiaries.validate-name-address'))
      }
    },
    validateKKAndAddress(value) {
      validateKK(this.beneficiaries.no_kk).then(response => {
        if (response.data === true) {
          this.$message.error('Nomor KK ' + this.beneficiaries.no_kk + ' sudah terdaftar')
          this.$refs.beneficiaries.resetFields()
          return
        } else {
          this.validateAddress(value)
        }
      })
    },
    validateNikAndAddress(value) {
      checkNik(this.beneficiaries.nik).then(response => {
        if (response.data === true) {
          this.$message.error('NIK ' + this.beneficiaries.nik + ' sudah terdaftar')
          this.$refs.beneficiaries.resetFields()
          return
        } else {
          this.validateAddress(value)
        }
      })
    },
    validateNikAndKKandAddress(value) {
      checkNik(this.beneficiaries.nik).then(response => {
        if (response.data === true) {
          this.$message.error('NIK ' + this.beneficiaries.nik + ' sudah terdaftar')
          this.$refs.beneficiaries.resetFields()
          return
        } else {
          validateKK(this.beneficiaries.no_kk).then(response => {
            if (response.data === true) {
              this.$message.error('Nomor KK ' + this.beneficiaries.no_kk + ' sudah terdaftar')
              this.$refs.beneficiaries.resetFields()
              return
            } else {
              this.validateAddress(value)
            }
          })
        }
      })
    },
    getNik(item) {
      this.loading = true
      checkNik(this.beneficiaries.nik).then(response => {
        if (response.data === true) {
          this.$message.error('NIK ' + this.beneficiaries.nik + ' sudah terdaftar')
          this.beneficiaries.nik = null
          this.loading = false
        } else {
          fetchNik(item).then(response => {
            Object.assign(this.beneficiaries, response.data)
            this.getKecamatan(this.beneficiaries.kabkota_bps_id)
            this.getKelurahan(this.beneficiaries.kec_bps_id)
            this.isAutomatedNik = false
            this.disableField = true
            this.loading = false
          }).catch(err => {
            console.log(err)
            this.$message.error(this.$t('beneficiaries.nik-unregistered'))
            this.isAutomatedNik = true
            this.loading = false
          })
        }
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
  .button-search-nik {
    display: block;
    float: right;
  }
</style>

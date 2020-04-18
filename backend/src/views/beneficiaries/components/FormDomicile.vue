<template>
  <div class="components-container">
    <div class="warning">
      <p class="caution">Masukan informasi mengenai domisili saat ini.</p>
    </div>
    <el-form
      ref="beneficiaries"
      :model="beneficiaries"
      :rules="rules"
      :status-icon="true"
      label-width="150px"
      label-position="left"
    >
      <el-form-item label="Provinsi" prop="domicile_province_bps_id">
        <el-select v-model="beneficiaries.domicile_province_bps_id" style="width:100%" :disabled="disableFieldArea">
          <el-option
            v-for="item in proviceList"
            :key="item.code_bps"
            :label="item.name"
            :value="item.code_bps"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Kabupaten/Kota" prop="domicile_kabkota_name" class="block">
        <el-select v-model="beneficiaries.domicile_kabkota_name" value-key="code_bps" filterable style="width:100%" :disabled="disableFieldArea">
          <el-option
            v-for="item in kabkotaList"
            :key="item.id"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Kecamatan" prop="domicile_kec_name" class="block">
        <el-select v-model="beneficiaries.domicile_kec_name" value-key="code_bps" filterable style="width:100%" :disabled="disableFieldArea">
          <el-option
            v-for="item in kecList"
            :key="item.id"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Kelurahan/Desa" prop="domicile_kel_name" class="block">
        <el-select v-model="beneficiaries.domicile_kel_name" value-key="code_bps" filterable style="width:100%" :disabled="disableFieldArea">
          <el-option
            v-for="item in kelList"
            :key="item.id"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="RW" prop="domicile_rw">
        <el-input v-model="beneficiaries.domicile_rw" type="number" placeholder="RW" :disabled="disableField" />
      </el-form-item>
      <el-form-item label="RT" prop="domicile_rt">
        <el-input v-model="beneficiaries.domicile_rt" type="number" placeholder="RT" :disabled="disableField" />
      </el-form-item>
      <el-form-item label="Nama Jalan" prop="domicile_address">
        <el-input v-model="beneficiaries.domicile_address" placeholder="Alamat" :disabled="disableField" />
      </el-form-item>
      <el-form-item class="ml-min-40 form-button">
        <span v-if="!isCreate">Apakah data sudah benar?</span>
        <el-button v-if="!isCreate" class="button-action" type="primary" plain @click="open">{{ $t('crud.change') }}</el-button>
        <el-button class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { getKecamatanBpsList, getKelurahanBpsList, getKabkotaList } from '@/api/areas'
import checkPermission from '@/utils/permission'

export default {
  props: {
    beneficiaries: {
      type: Object,
      default: null
    },
    disableField: {
      type: Boolean,
      default: true
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
      disableFieldArea: false,
      kabkotaUpdate: null,
      proviceList: [
        {
          name: 'JAWA BARAT',
          code_bps: 32
        }
      ],
      kabkotaList: null,
      kecList: null,
      kelList: null,
      rules: {
        domicile_address: [
          {
            required: true,
            message: 'Alamat harus diisi',
            trigger: 'blur'
          }
        ],
        domicile_rt: [
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
        domicile_rw: [
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
        domicile_kel_name: [
          {
            required: true,
            message: 'Kelurahan/Desa harus diisi',
            trigger: 'change'
          }
        ],
        domicile_kec_name: [
          {
            required: true,
            message: 'Kecamatan harus diisi',
            trigger: 'change'
          }
        ],
        domicile_kabkota_name: [
          {
            required: true,
            message: 'Kabupaten/Kota harus diisi',
            trigger: 'change'
          }
        ],
        domicile_province_bps_id: [
          {
            required: false,
            message: 'Provinsi harus diisi',
            trigger: 'input'
          }
        ]
      }
    }
  },
  watch: {
    'beneficiaries.domicile_kabkota_name'(value1, value2) {
      if (this.isCreate) {
        if (value1 !== value2) {
          if (value2 !== null) {
            this.beneficiaries.domicile_kec_name = null
            this.beneficiaries.domicile_kel_name = null
          } else if (value1 !== null) {
            this.beneficiaries.domicile_kabkota_bps_id = value1.code_bps
            this.getKecamatan(this.beneficiaries.domicile_kabkota_bps_id)
          }
        }
      }
    },
    'beneficiaries.domicile_kec_name'(value1, value2) {
      if (this.isCreate) {
        if (value1 !== value2) {
          if (value2 !== null) {
            this.beneficiaries.domicile_kel_name = null
          } else if (value1 !== null) {
            this.beneficiaries.domicile_kec_bps_id = value1.code_bps
            this.getKelurahan(this.beneficiaries.domicile_kec_bps_id)
          }
        }
      }
    },

    'beneficiaries.domicile_kel_name'(value1, value2) {
      if (this.isCreate) {
        if (value1 !== value2) {
          if (value1 !== null) {
            this.beneficiaries.domicile_kel_bps_id = value1.code_bps
          }
        }
      }
    }
  },
  mounted() {
    this.getArea()
    this.init()
    this.getKecamatan(this.beneficiaries.domicile_kabkota_bps_id)
    this.getKelurahan(this.beneficiaries.domicile_kec_bps_id)
  },
  methods: {
    checkPermission,
    init() {
      const authUser = this.$store.state.user
      if (checkPermission(['staffKel'])) {
        this.disableFieldArea = true
        this.beneficiaries.domicile_province_bps_id = 32
        this.beneficiaries.domicile_kel_name = authUser.kelurahan
        this.beneficiaries.domicile_kec_name = authUser.kecamatan
        this.beneficiaries.domicile_kabkota_name = authUser.kabkota
        this.beneficiaries.domicile_kabkota_bps_id = authUser.kabkota.code_bps
        this.beneficiaries.domicile_kec_bps_id = authUser.kecamatan.code_bps
        this.beneficiaries.domicile_kel_bps_id = authUser.kelurahan.code_bps
      }
    },
    async next() {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }
      this.$emit('nextStep', 1)
    },
    open() {
      this.disableField = false
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
    }
  }
}
</script>
<style lang="scss" scoped>
  .caution {
    font-size: 14px;
    padding: 5px 0;
    margin: 0px;
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

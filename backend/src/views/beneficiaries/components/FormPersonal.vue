<template>
  <div class="components-container">
    <div class="warning">
      <p class="caution">Masukan NIK dari calon penerima bantuan sosial yang terdaftar di DISDUKCAPIL Provinsi Jawa Barat.</p>
      <p class="caution">Maka sistem akan otomatis mendapatkan data diri pemilik NIK tersebut.</p>
    </div>
    <el-form
      ref="beneficiaries"
      :model="beneficiaries"
      :rules="rules"
      :status-icon="true"
      label-width="150px"
      label-position="left"
    >
      <el-form-item label="NIK" prop="nik">
        <el-input v-model="beneficiaries.nik" placeholder="NIK" :disabled="disableField" />
      </el-form-item>
      <el-form-item label="Nama" prop="name">
        <el-input v-model="beneficiaries.name" placeholder="Nama Lengkap" :disabled="disableField" />
      </el-form-item>
      <el-form-item label="Kabupaten/Kota" prop="kabkota_id" class="block">
        <el-select v-model="beneficiaries.kabkota" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kabkotaList"
            :key="item.code_bps"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Kecamatan" prop="kec_id" class="block">
        <el-select v-model="beneficiaries.kecamatan" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kecList"
            :key="item.id"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Kelurahan" prop="kel_id" class="block">
        <el-select v-model="beneficiaries.kelurahan" value-key="code_bps" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in kelList"
            :key="item.id"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="RW" prop="rw">
        <el-input v-model="beneficiaries.rw" type="number" placeholder="RW" :disabled="disableField" />
      </el-form-item>
      <el-form-item label="RT" prop="rt">
        <el-input v-model="beneficiaries.rt" type="number" placeholder="RT" :disabled="disableField" />
      </el-form-item>
      <el-form-item class="ml-min-40 form-button">
        <span>Apakah data sudah benar?</span>
        <el-button class="button-action" type="primary" plain @click="openField">{{ $t('crud.change') }}</el-button>
        <el-button class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { getKecamatanList, getKelurahanList, getKabkotaList } from '@/api/areas'

export default {
  props: {
    beneficiaries: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      disableField: true,
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
          }
        ],
        kabkota_id: [
          {
            required: true,
            message: 'Kabupaten/Kota harus diisi',
            trigger: 'blur'
          }
        ],
        kec_id: [
          {
            required: true,
            message: 'Kecamatan harus diisi',
            trigger: 'blur'
          }
        ],
        kel_id: [
          {
            required: true,
            message: 'Kelurahan harus diisi',
            trigger: 'blur'
          }
        ],
        rw: [
          {
            required: true,
            message: 'RW harus diisi',
            trigger: 'blur'
          }
        ],
        rt: [
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
      if (value1 !== value2) {
        if (value2 !== null) {
          this.beneficiaries.kecamatan = null
          this.beneficiaries.kelurahan = null
          this.beneficiaries.kabkota_id = value1.id
          this.beneficiaries.kabkota_bps_id = value1.code_bps
          this.getKecamatan(value1.id)
        }
      }
    },
    'beneficiaries.kecamatan'(value1, value2) {
      if (value1 !== value2) {
        if (value2 !== null) {
          this.beneficiaries.kelurahan = null
        } else if (value1 !== null) {
          this.getKelurahan(value1.id)
          this.beneficiaries.kec_id = value1.id
          this.beneficiaries.kec_bps_id = value1.code_bps
        }
      }
    },
    'beneficiaries.kelurahan'(value1, value2) {
      if (value1 !== value2) {
        if (value1 !== null) {
          this.beneficiaries.kel_id = value1.id
          this.beneficiaries.kel_bps_id = value1.code_bps
        }
      }
    }
  },
  mounted() {
    this.getArea()
    this.getKecamatan(this.beneficiaries.kabkota_id)
    this.getKelurahan(this.beneficiaries.kec_id)
  },
  methods: {
    async next() {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }
      this.$emit('nextStep', 1)
    },
    openField() {
      this.disableField = false
    },
    getArea() {
      getKabkotaList().then(response => {
        this.kabkotaList = response.data.items
      })
    },
    getKecamatan(value) {
      getKecamatanList(value).then(response => {
        this.kecList = response.data.items
      })
    },
    getKelurahan(value) {
      getKelurahanList(value).then(response => {
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

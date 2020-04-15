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
      <!-- <el-form-item label="Provinsi" prop="nik">
        <el-input v-model="beneficiaries.nik" placeholder="NIK" />
      </el-form-item> -->
      <el-form-item label="Kabupaten/Kota" prop="domicile_kabkota_bps_id" class="block">
        <InputKabkota
          class="inline-block"
          :kabkota-id="beneficiaries.domicile_kabkota_bps_id"
          :style="{width: '300%'}"
          :open="disableField"
          @changeKabkota="beneficiaries.domicile_kabkota_bps_id = $event"          
        />
      </el-form-item>
      <el-form-item label="Kecamatan" prop="domicile_kec_bps_id" class="block">
        <InputKec
          class="inline-block"
          :kec-id="beneficiaries.domicile_kec_bps_id"
          :style="{width: '300%'}"
          :open="disableField"
          @changeKecamatan="beneficiaries.domicile_kec_bps_id = $event"        
        />
      </el-form-item>
      <el-form-item label="Kelurahan/Desa" prop="domicile_kel_bps_id" class="block">
        <InputKel
          class="inline-block"
          :kel-id="beneficiaries.domicile_kel_bps_id"
          :style="{width: '300%'}"
          :open="disableField"
          @changeKelurahan="beneficiaries.domicile_kel_bps_id = $event"        
        />
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
        <span>Apakah data sudah benar?</span>
        <el-button class="button-action" type="primary" @click="open" plain>{{ $t('crud.change') }}</el-button>
        <el-button class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import InputKabkota from '@/components/InputKabkota'
import InputKec from '@/components/InputKec'
import InputKel from '@/components/InputKel'
export default {
  components: {
    InputKabkota,
    InputKec,
    InputKel
  },
  props: {
    beneficiaries: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      disableField: true,
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
          }
        ],
        domicile_rw: [
          {
            required: true,
            message: 'RW harus diisi',
            trigger: 'blur'
          }
        ],
        domicile_kel_bps_id: [
          {
            required: true,
            message: 'Kelurahan/Desa harus diisi',
            trigger: 'blur'
          }
        ],
        domicile_kec_bps_id: [
          {
            required: true,
            message: 'Kecamatan harus diisi',
            trigger: 'blur'
          }
        ],
        domicile_kabkota_bps_id: [
          {
            required: true,
            message: 'Kabupaten/Kota harus diisi',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  methods: {
    async next() {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }
      this.$emit('nextStep', 1)
    },
    open() {
      this.disableField = false
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

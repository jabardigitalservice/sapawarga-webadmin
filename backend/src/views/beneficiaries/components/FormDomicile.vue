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
      <el-form-item label="Kabupaten/Kota" prop="wilayah" class="block">
        <InputKabkota
          class="inline-block"
          :kabkota-id="beneficiaries.domicile_kabkota_bps_id"
          :style="{width: '300%'}"
          @changeKabkota="beneficiaries.domicile_kabkota_bps_id = $event"          
        />
      </el-form-item>
      <el-form-item label="Kecamatan" prop="wilayah" class="block">
        <InputKec
          class="inline-block"
          :kec-id="beneficiaries.domicile_kec_bps_id"
          :style="{width: '300%'}"
          @changeKecamatan="beneficiaries.domicile_kec_bps_id = $event"        
        />
      </el-form-item>
      <el-form-item label="Kelurahan" prop="wilayah" class="block">
        <InputKel
          class="inline-block"
          :kel-id="beneficiaries.domicile_kel_bps_id"
          :style="{width: '300%'}"
          @changeKelurahan="beneficiaries.domicile_kel_bps_id = $event"        
        />
      </el-form-item>
      <el-form-item label="RW" prop="rw">
        <el-input v-model="beneficiaries.domicile_rw" type="number" placeholder="RW" />
      </el-form-item>
      <el-form-item label="RT" prop="rt">
        <el-input v-model="beneficiaries.domicile_rt" type="number" placeholder="RT" />
      </el-form-item>
      <el-form-item label="Nama Jalan" prop="rt">
        <el-input v-model="beneficiaries.domicile_address" placeholder="Alamat" />
      </el-form-item>
      <el-form-item class="ml-min-40 form-button">
        <span>Apakah data sudah benar?</span>
        <el-button class="button-action" type="primary" plain>{{ $t('crud.change') }}</el-button>
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
      rules: {
        name: [
          {
            required: true,
            message: 'Nama harus diisi',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  methods: {
    next() {
      this.$emit('nextStep', 1)
    }
  },
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

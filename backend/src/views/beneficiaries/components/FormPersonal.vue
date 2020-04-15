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
        <el-input v-model="beneficiaries.nik" placeholder="NIK" />
      </el-form-item>
      <el-form-item label="Nama" prop="name">
        <el-input v-model="beneficiaries.name" placeholder="Nama Lengkap" />
      </el-form-item>
      <el-form-item label="Kabupaten/Kota" prop="kabkota_id" class="block">
        <InputKabkota
          class="inline-block"
          :kabkota-id="beneficiaries.kabkota_id"
          :style="{width: '300%'}"
          @changeKabkota="beneficiaries.kabkota_id = $event"          
        />
      </el-form-item>
      <el-form-item label="Kecamatan" prop="kec_id" class="block">
        <InputKec
          class="inline-block"
          :kec-id="beneficiaries.kec_id"
          :style="{width: '300%'}"
          @changeKecamatan="beneficiaries.kec_id = $event"
        />
      </el-form-item>
      <el-form-item label="Kelurahan" prop="kel_id" class="block">
        <InputKel
          class="inline-block"
          :kel-id="beneficiaries.kel_id"
          :style="{width: '300%'}"
          @changeKelurahan="beneficiaries.kel_id = $event"
        />
      </el-form-item>
      <el-form-item label="RW" prop="rw">
        <el-input v-model="beneficiaries.rw" type="number" placeholder="RW" />
      </el-form-item>
      <el-form-item label="RT" prop="rt">
        <el-input v-model="beneficiaries.rt" type="number" placeholder="RT" />
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
  methods: {
    async next() {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }
      this.$emit('nextStep', 1)
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

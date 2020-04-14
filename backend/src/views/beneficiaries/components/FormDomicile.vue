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
      <el-form-item label="Provinsi" prop="nik">
        <el-input v-model="beneficiaries.nik" placeholder="NIK" />
      </el-form-item>
      <el-form-item label="Kota/Kabupaten" prop="kabkota">
        <el-input v-model="beneficiaries.kabkota" placeholder="Kab/Kota" />
      </el-form-item>
      <el-form-item label="Kecamatan" prop="kecamatan">
        <el-input v-model="beneficiaries.kecamatan" placeholder="Kecamatan" />
      </el-form-item>
      <el-form-item label="Kelurahan" prop="Kelurahan">
        <el-input v-model="beneficiaries.kelurahan" placeholder="Kelurahan" />
      </el-form-item>
      <el-form-item label="RW" prop="rw">
        <el-input v-model="beneficiaries.rw" placeholder="RW" />
      </el-form-item>
      <el-form-item label="RT" prop="rt">
        <el-input v-model="beneficiaries.rt" placeholder="RT" />
      </el-form-item>
      <el-form-item label="Nama Jalan" prop="rt">
        <el-input v-model="beneficiaries.rt" placeholder="RT" />
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
export default {
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
    margin: 0px 5px;
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

<template>
  <div class="components-container">
    <el-form
      ref="beneficiaries"
      :status-icon="true"
      :model="beneficiaries"
      :rules="rules"
      label-width="350px"
      label-position="left"
    >
      <p class="ktp-note">Format NIK/Nomor KTP warga ini tidak sesuai.</p>
      <el-form-item v-if="!isCreate" label="Apakah warga ini memiliki NIK/Nomor KTP?" prop="is_have_ktp">
        <el-radio-group v-model="beneficiaries.is_have_ktp">
          <el-radio class="label-check" :label="1">Ya</el-radio>
          <el-radio class="label-check" :label="0">Tidak punya</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="beneficiaries.is_have_ktp" label="Masukan NIK/Nomor KTP" prop="nik">
        <el-input v-model="beneficiaries.nik" type="number" />
      </el-form-item>
      <el-form-item v-if="!beneficiaries.is_have_ktp" label="Alasan tidak punya NIK/Nomor KTP" prop="notes">
        <el-input v-model="beneficiaries.notes" type="textarea" rows="3" />
      </el-form-item>
      <el-form-item class="ml-min-40 form-button">
        <el-button v-if="beneficiaries.is_have_ktp" class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
        <el-button v-else class="button-action" type="primary"> {{ $t('crud.next') }}</el-button>
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
    },
    isCreate: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      rules: {
        is_have_ktp: [
          {
            required: true,
            message: 'Pilih salah satu',
            trigger: 'blur'
          }
        ],
        notes: [
          {
            required: true,
            message: 'Pilih salah satu',
            trigger: 'blur'
          }
        ],
        nik: [
          {
            required: true,
            message: 'Pilih salah satu',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  mounted() {
    this.beneficiaries.is_have_ktp = 1
  },
  methods: {
    next() {}
  }
}
</script>
<style lang="scss" scoped>
  .ktp-note {
    font-size: 14px;
    color: #606266;
    font-weight: bold;
  }
</style>

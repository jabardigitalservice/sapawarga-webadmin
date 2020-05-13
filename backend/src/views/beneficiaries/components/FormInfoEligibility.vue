<template>
  <div class="components-container">
    <el-form
      ref="beneficiaries"
      :status-icon="true"
      :model="beneficiaries"
      :rules="rules"
      label-width="320px"
      label-position="left"
    >
      <el-form-item v-if="!isCreate" label="Apakah warga ini perlu dibantu atau tidak?" prop="is_need_help">
        <el-radio-group v-model="beneficiaries.is_need_help">
          <el-radio class="label-check" :label="1">Perlu Dibantu</el-radio>
          <el-radio class="label-check" :label="0">Tidak Perlu Dibantu</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="!beneficiaries.is_need_help" label="Berikan keterangan kenapa warga tersebut tidak perlu dibantu?" prop="notes_rejected">
        <el-radio-group v-model="beneficiaries.notes_rejected" class="radio-reject">
          <el-radio class="label-check" label="meninggal">Meninggal</el-radio>
          <el-radio class="label-check" label="pindah">Pindah</el-radio>
          <el-radio class="label-check" label="orang mampu">Orang mampu</el-radio>
          <el-radio class="label-check" label="sudah menerima bantuan lain">Sudah menerima program lain</el-radio>
          <el-radio class="label-check" label="lainnya">Lainnya</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="!beneficiaries.is_need_help && beneficiaries.notes_rejected === 'lainnya'" prop="rejected">
        <el-input v-model="beneficiaries.rejected" type="textarea" rows="4" />
      </el-form-item>
      <el-form-item v-if="beneficiaries.is_need_help" label="Berikan keterangan kenapa warga tersebut perlu dibantu?" prop="notes_approved">
        <el-input v-model="beneficiaries.notes_approved" type="textarea" rows="4" />
      </el-form-item>
      <el-form-item v-if="beneficiaries.is_need_help" label="Status ekonomi warga yang bersangkutan" prop="is_poor_new">
        <el-radio-group v-model="beneficiaries.is_poor_new">
          <el-radio :label="1" class="label-check">
            Miskin Baru
            <div class="desc-label">Penjelasan miskin baru adalah orang miskin terdampak langsung COVID 19</div>
          </el-radio>
          <el-radio :label="0" class="label-check is-poor-radio">
            Miskin Lama
            <div class="desc-label">Penjelasan miskin lama adalah orang yang sebelum COVID 19 sudah masuk dalam status miskin</div>
          </el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="!beneficiaries.is_need_help">
        <div>
          <p class="note-reject-text">Data yang kelayakannya tidak perlu dibantu akan secara otomatis tertolak oleh sistem dan tidak akan diajuakan untuk menerima bantuan.</p>
          <p>Apakah Anda yakin warga ini tidak perlu dibantu?</p>
        </div>
      </el-form-item>
      <el-form-item class="ml-min-40 form-button">
        <el-button v-if="beneficiaries.is_need_help" class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
        <el-button v-else class="button-action" type="primary" @click="reject"> {{ $t('crud.next-reject') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { update } from '@/api/beneficiaries'
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
        is_need_help: [
          {
            required: true,
            message: 'Pilih salah satu',
            trigger: 'blur'
          }
        ],
        is_poor_new: [
          {
            required: true,
            message: 'Pilih salah satu',
            trigger: 'blur'
          }
        ],
        notes_approved: [
          {
            required: true,
            message: 'Alasan harus diisi',
            trigger: 'blur'
          }
        ],
        notes_rejected: [
          {
            required: true,
            message: 'Alasan harus diisi',
            trigger: 'blur'
          }
        ],
        rejected: [
          {
            required: true,
            message: 'Alasan harus diisi',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  created() {
    if (!this.isCreate) {
      if (this.beneficiaries.status_verification === 2) this.beneficiaries.is_need_help = 0
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
    async reject() {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }
      if (this.beneficiaries.notes_rejected === 'lainnya') {
        this.beneficiaries.notes_rejected = this.beneficiaries.rejected
      }

      const id = await this.$route.params && this.$route.params.id
      await this.$confirm(this.$t('message.confirmation-reject-data'), 'Peringatan', {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'warning'
      })
      this.beneficiaries.status_verification = 2
      await update(id, this.beneficiaries)
      this.$message.info('Status berhasil diubah')
      this.$router.push('/beneficiaries/index')
    }
  }
}
</script>

<style lang="scss" scoped>
.label-check {
  line-height: 25px;
  font-weight: bold;
  display: block;
}
.desc-label {
  margin-left: 25px;
  font-weight: normal;
}
.is-poor-radio {
  margin-top: 10px;
}
.form-button {
  margin-top: 50px;
}
.note-reject-text {
  line-height: 25px;
}
.radio-reject {
  display: block;
}
</style>

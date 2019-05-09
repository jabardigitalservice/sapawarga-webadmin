<template>
  <el-dialog title="Tambah Nomor Telepon" :append-to-body="true" :visible="modalAddPhoneNumberVisible" @closed="modalClosed">

    <el-form ref="modal_phone_number" :status-icon="true" :model="form" :rules="rules" label-width="160px">
      <el-form-item label="Nomor Telepon" prop="phone_number">
        <el-input v-model="form.phone_number" placeholder="Masukkan angka, contoh: 022553135" autocomplete="off" />
      </el-form-item>
      <el-form-item label="Jenis" prop="type">
        <el-select v-model="form.type" placeholder="Pilih Jenis">
          <el-option label="Telepon" value="phone" />
          <el-option label="Pesan" value="message" />
        </el-select>
      </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
      <el-button type="primary" @click="addItem()">{{ $t('crud.save-create') }}</el-button>
      <el-button @click="closeDialog">{{ $t('crud.cancel') }}</el-button>
    </span>
  </el-dialog>
</template>

<script>
import { containsInvalidPhoneNumber } from '@/utils/validate'

export default {
  props: {
    modalAddPhoneNumberVisible: {
      type: Boolean
    }
  },
  data() {
    const validatorPhoneNumber = (rule, value, callback) => {
      if (containsInvalidPhoneNumber(value)) {
        callback(new Error('Nomor Telepon hanya boleh berisi angka.'))
      }

      callback()
    }

    return {
      form: {
        type: null,
        phone_number: null
      },
      rules: {
        type: [
          { required: true, message: 'Jenis harus diisi.', trigger: 'blur' }
        ],
        phone_number: [
          { required: true, message: 'Nomor Telepon harus diisi.', trigger: 'blur' },
          { min: 3, message: 'Nomor Telepon minimal 3 digit.', trigger: 'blur' },
          { validator: validatorPhoneNumber, trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    async addItem() {
      const valid = await this.$refs.modal_phone_number.validate()

      console.log(valid)

      this.$emit('save', {
        type: this.form.type,
        phone_number: this.form.phone_number
      })

      this.closeDialog()
    },

    closeDialog() {
      this.$emit('close')
    },

    modalClosed() {
      this.$refs.modal_phone_number.resetFields()
    }
  }
}
</script>

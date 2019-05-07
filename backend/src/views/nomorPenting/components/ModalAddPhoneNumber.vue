<template>
  <el-dialog title="Tambah Nomor Telepon" :append-to-body="true" :visible="modalAddPhoneNumberVisible" @closed="modalClosed">

    <el-form ref="modal_phone_number" :model="form" :rules="rules" label-width="160px">
      <el-form-item label="Nomor Telepon" prop="phone_number" required>
        <el-input v-model="form.phone_number" placeholder="Nomor Telepon" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="Jenis" prop="type" required>
        <el-select v-model="form.type" placeholder="Pilih Jenis">
          <el-option label="Telepon" value="phone"></el-option>
          <el-option label="Pesan" value="message"></el-option>
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
export default {
  props: {
    modalAddPhoneNumberVisible: {
      type: Boolean
    }
  },
  data() {
    return {
      form: {
        type: null,
        phone_number: null
      },
      rules: {
        type: [
          { required: true, message: 'Jenis', trigger: 'blur' }
        ],
        phone_number: [
          { required: true, message: 'Nomor Telepon', trigger: 'blur' }
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

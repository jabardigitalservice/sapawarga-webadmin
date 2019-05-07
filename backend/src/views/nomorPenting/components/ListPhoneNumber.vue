<template>
  <div>
    <el-button size="mini" type="primary" @click="modalAddPhoneNumberVisible = true">{{ $t('crud.insert-row') }}</el-button>

    <el-table :data="items" border stripe style="width: 600px">
      <el-table-column label="Nomor Telepon" prop="phone_number"></el-table-column>
      <el-table-column label="Jenis" prop="type"></el-table-column>
      <el-table-column label="Aksi" width="150">
        <template slot-scope="scope">
          <el-button size="mini" type="danger" @click="removeItem(scope.$index)">{{ $t('crud.delete-row') }}</el-button>
        </template>
      </el-table-column>
    </el-table>

    <ModalAddPhoneNumber :modal-add-phone-number-visible="modalAddPhoneNumberVisible" @save="addItem" @close="closeDialog"></ModalAddPhoneNumber>
  </div>
</template>

<script>
import ModalAddPhoneNumber from './ModalAddPhoneNumber'

export default {
  components: {
    ModalAddPhoneNumber
  },
  props: {
    value: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      modalAddPhoneNumberVisible: false,
      items: [],
      typeOptions: [{
        value: 'phone',
        label: 'Telepon'
      }, {
        value: 'message',
        label: 'Pesan'
      }]
    }
  },
  watch: {
    value: {
      handler: function(value) {
        this.items = value
      },
      immediate: true
    }
  },
  methods: {
    async removeItem(index) {
      await this.$confirm(this.$t('crud.delete-row-confirm'), 'Warning', {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'warning'
      })

      const items = this.items

      items.splice(index, 1)

      this.$emit('input', items)
    },

    addItem(data) {
      const items = this.items

      items.push(data)

      this.$emit('input', items)
    },

    closeDialog() {
      this.modalAddPhoneNumberVisible = false
    }
  }
}
</script>

<template>
  <div>
    <div class="clearfix" />
    <el-row v-for="(item, index) in items" :key="index" :gutter="15" style="margin-bottom: 15px">
      <el-col :span="5">
        <el-input v-model="item.phone_number" placeholder="Nomor Telepon" />
      </el-col>
      <el-col :span="5">
        <el-select v-model="item.type" placeholder="Pilih Jenis">
          <el-option
            v-for="option in typeOptions"
            :key="option.value"
            :label="option.label"
            :value="option.value"
          />
        </el-select>
      </el-col>
      <el-col :span="5">
        <el-button size="mini" type="danger" @click="removeItem(index)">{{ $t('crud.delete-row') }}</el-button>
      </el-col>
    </el-row>
    <el-button size="mini" type="primary" @click="addItem">{{ $t('crud.insert-row') }}</el-button>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
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
    removeItem(index) {
      this.items.splice(index, 1)

      this.$emit('input', this.items)
    },

    addItem() {
      this.items.push({
        type: null,
        phone_number: null
      })
    }
  }
}
</script>

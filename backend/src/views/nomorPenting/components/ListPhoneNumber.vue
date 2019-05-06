<template>
  <div>
    <div class="clearfix" />
    <el-row v-for="(item, index) in items" :key="index" :gutter="15" style="margin-bottom: 15px">
      <el-col :span="5">
        <el-input v-model="item.phone_number" />
      </el-col>
      <el-col :span="5">
        <el-select v-model="item.type" placeholder="Select">
          <el-option
            v-for="option in typeOptions"
            :key="option.value"
            :label="option.label"
            :value="option.value"
          />
        </el-select>
      </el-col>
      <el-col :span="5">
        <el-button size="mini" type="danger" @click="removeItem(index)">Hapus</el-button>
      </el-col>
    </el-row>
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
    }
  }
}
</script>

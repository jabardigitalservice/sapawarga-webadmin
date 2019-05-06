<template>
  <el-select v-model="selected" clearable placeholder="Pilih Kategori" @change="$emit('input', $event)">
    <el-option
      v-for="item in options"
      :key="item.value"
      :label="item.label"
      :value="item.value">
    </el-option>
  </el-select>
</template>

<script>
export default {
  props: {
    value: {
      required: true
    }
  },
  data() {
    return {
      options: [{
        value: 1,
        label: 'Kesehatan'
      }, {
        value: 2,
        label: 'Ekonomi'
      }, {
        value: 3,
        label: 'Keamanan'
      }],
      selected: null
    }
  },
  watch: {
    value: {
      handler: function(value) {
        this.selected = value
      },
      immediate: true
    }
  }
}
</script>

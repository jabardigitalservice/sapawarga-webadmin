<template>
  <el-select v-model="selected" clearable :placeholder="title" name="category_id" @change="$emit('input', $event)">
    <el-option
      v-for="item in options"
      :key="item.value"
      :label="item.label"
      :value="postCategory ? item.label : item.value"
    />
  </el-select>
</template>

<script>
import { fetchList } from '@/api/categories'

export default {
  props: {
    value: { // eslint-disable-line
      required: true
    },

    categoryType: {
      type: String,
      required: true
    },

    title: {
      type: String,
      default: 'Pilih Kategori',
      required: false
    },

    postCategory: {
      type: Boolean,
      default: false,
      required: false
    }
  },
  data() {
    return {
      options: [],
      selected: null,
      listQuery: {
        type: this.categoryType
      }
    }
  },
  watch: {
    value: {
      handler: function(value) {
        this.selected = value
      },
      immediate: true
    }
  },
  mounted() {
    this.getList()
  },
  methods: {
    async getList() {
      const response = await fetchList(this.listQuery)

      const { data } = response

      this.options = data.items.map(item => {
        return {
          value: item.id,
          label: item.name
        }
      })
    }
  }
}
</script>

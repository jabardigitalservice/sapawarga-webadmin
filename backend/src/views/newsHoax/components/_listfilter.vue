<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10">
        <el-col :xs="{span:24, tag:'mb-10'}" :span="12">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.search" placeholder="Judul" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :span="6">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.category_id"
              clearable
              filterable
              placeholder="Pilih Kategori Berita Hoax"
              style="width: 100%"
            >
              <el-option
                v-for="item in options"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :xs="{span: 24, tag:'mb-10'}" :span="6">
          <el-button type="primary" size="small" @click="submitSearch">{{ $t('crud.search') }}</el-button>
          <el-button type="primary" size="small" @click="resetFilter">{{ $t('crud.reset') }}</el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import checkPermission from '@/utils/permission'
import { fetchList } from '@/api/categories'
export default {
  props: {
    listQuery: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      options: [],
      query: {
        type: 'newsHoax'
      }
    }
  },
  created() {
    this.getNewsChannel()
  },
  methods: {
    checkPermission,

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    },

    getNewsChannel() {
      fetchList(this.query).then(response => {
        this.options = response.data.items
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.mt-10 {
  margin-top: 10px;
}
</style>

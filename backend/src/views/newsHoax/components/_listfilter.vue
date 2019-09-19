<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="12">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.search" placeholder="Judul" />
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.category_id"
              clearable
              filterable
              placeholder="Pilih Ketegory Berita"
              style="width: 100%"
            >
              <el-option value="1" label="Disinformasi" />
              <el-option value="2" label="Fakta" />
              <el-option value="3" label="Klarifikasi" />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-button type="primary" size="small" @click="submitSearch">Cari</el-button>
          <el-button type="primary" size="small" @click="resetFilter">Reset</el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import checkPermission from '@/utils/permission'
// import { newsChannelList } from '@/api/news'
export default {
  props: {
    listQuery: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      options: []
    }
  },
  created() {
    // this.getNewsChannel()
  },
  methods: {
    checkPermission,

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    }

    // getNewsChannel() {
    //   newsChannelList().then(response => {
    //     this.options = response.data.items
    //   })
    // }
  }
}
</script>

<style lang="scss" scoped>
.mt-10 {
  margin-top: 10px;
}
</style>

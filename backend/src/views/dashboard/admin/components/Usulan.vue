<template>
  <el-card class="box-card">
    <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

    <el-table v-loading="listLoading" class="title" :data="list" stripe border highlight-current-row style="width: 100%">
      <el-table-column
        prop="title"
        label="Usulan"
        align="left"
        min-width="180"
        style="background:blue"
      />
      <el-table-column
        prop="category_name"
        label="Kategori"
        align="center"
      />
      <el-table-column
        prop="total_likes"
        label="Like"
        align="center"
      />
    </el-table>
  </el-card>
</template>

<script>
import { fetchAspirasiMostLikes } from '@/api/dashboard'
import ListFilter from './_listfilter'

export default {
  components: { ListFilter },
  data() {
    return {
      list: null,
      listLoading: true,
      listQuery: {
        category_id: null,
        kabkota_id: null
      }
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      fetchAspirasiMostLikes(this.listQuery).then(response => {
        this.list = response.data.items
        this.listLoading = false
      })
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    }
  }
}
</script>

<style lang="scss" scoped>

  .box-card {
    width: 100%;
  }
</style>

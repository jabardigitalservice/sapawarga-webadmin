<template>
  <el-table class="title" v-loading="listLoading" :data="list" stripe border highlight-current-row style="width: 100%">
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
      label="Likes"
      align="center"
    />
  </el-table>
</template>

<script>
import { fetchList } from '@/api/dashboard'

export default {
  components: {},
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
      fetchList(this.listQuery).then(response => {
        this.list = response.data.items
        console.log(this.list)
        this.listLoading = false
      })
    }
  }
}
</script>

<style lang="scss" scoped>
  // el-table-column:first-child {
  //   margin-left: 50px;
  // }
  .title {
    padding: 0 0px;
  }

</style>
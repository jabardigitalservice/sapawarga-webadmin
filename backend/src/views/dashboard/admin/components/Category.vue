<template>
  <el-table v-loading="listLoading" :data="list" stripe style="width: 100%">
    <el-table-column type="index" align="center" :index="getTableRowNumbering" />
    <el-table-column prop="name" :label="$t('label.popular-category')" align="left" min-width="170" />
    <el-table-column prop="total" :label="$t('dashboard.dashboard-aspiration')" align="center" />
  </el-table>
</template>
<script>
import { fetchCategoryAspirasiMostLikes } from '@/api/dashboard'
export default {
  components: {},
  data() {
    return {
      list: null,
      listLoading: true
    }
  },
  created() {
    this.getCategoryAspirasiMostLikes()
  },
  methods: {
    getTableRowNumbering(index) {
      return (index + 1)
    },
    async getCategoryAspirasiMostLikes() {
      this.listLoading = true
      const response = await fetchCategoryAspirasiMostLikes()
      this.list = await response.data
      this.listLoading = false
    }
  }
}
</script>

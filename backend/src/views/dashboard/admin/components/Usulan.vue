<template>
  <el-card>
    <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

    <el-table v-loading="listLoading" class="title" :data="list" stripe border highlight-current-row style="width: 100%">
      <el-table-column prop="title" :label="$t('label.aspiration-title')" align="left" min-width="180" style="background:blue" />
      <el-table-column prop="category_name" :label="$t('label.category')" align="center" />
      <el-table-column prop="total_likes" :label="$t('label.aspiration-like')" align="center" />
    </el-table>

    <el-row style="margin: 0 auto; text-align: center;padding-top:20px;">
      <router-link :to="{ path: '/aspirasi/index' }">
        <a href="#" style="color: #1890ff;">{{ $t('label.aspiration-view-all') }}</a>
      </router-link>
    </el-row>
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
        limit: 10,
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

<template>
  <el-row>
    <ListFilter
      :list-query.sync="listQuery"
      :fitur="category"
      @submit-search="getList"
      @reset-search="resetFilter"
    />

    <el-table v-loading="listLoading" :data="list" stripe fit highlight-current-row>

      <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

      <el-table-column v-if="category === 'polling'" property="name" label="Judul Polling" min-width="180" />
      
      <el-table-column v-if="category === 'berita'" property="title" label="Judul Berita" min-width="180" />
      
      <el-table-column v-if="category === 'survei'" property="title" label="Judul Survei" min-width="180" />
      
      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">
          <el-tooltip content="Tambah" placement="right">
            <el-button type="success" circle icon="el-icon-plus" @click="addBeritaPriority(scope.row), dialogTableVisible(false)" />
          </el-tooltip>
        </template>
      </el-table-column>

    </el-table>
    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
  </el-row>
</template>
<script>
import Pagination from '@/components/Pagination'
import { fetchList as listNews } from '@/api/news'
import { fetchList as listPolling } from '@/api/polling'
import { fetchList as listSurvey } from '@/api/survey'
import ListFilter from './_listfilter'
export default {
  components: {
    Pagination,
    ListFilter
  },
  props: {
    category: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      list: null,
      listLoading: true,
      total: 0,
      listQuery: {
        title: null,
        search: null,
        channel_id: null,
        status: 10,
        page: 1,
        limit: 10
      }
    }
  },
  watch: {
    category() {
      this.resetFilter()
      this.getList()
    }
  },
  mounted() {
    this.getList()
  },
  methods: {
    async getList() {
      this.listLoading = true
      if (this.category === 'berita') {
        await listNews(this.listQuery).then(response => {
          this.list = response.data.items
          this.total = response.data._meta.totalCount
          this.listLoading = false
        })
      } else if (this.category === 'polling') {
        await listPolling(this.listQuery).then(response => {
          this.list = response.data.items
          this.total = response.data._meta.totalCount
          this.listLoading = false
        })
      } else if (this.category === 'survei') {
        await listSurvey(this.listQuery).then(response => {
          this.list = response.data.items
          this.total = response.data._meta.totalCount
          this.listLoading = false
        })
      }
    },
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    },
    addBeritaPriority(data) {
      this.$emit('childData', data)
    },
    dialogTableVisible(data) {
      this.$emit('closeDialog', data)
      this.resetFilter()
    }
  }
}
</script>
<style lang="scss" scoped>

</style>

<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/polling/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                {{ $t('label.polling-add') }}
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
          <el-table-column prop="name" sortable="custom" :label="$t('label.polling-name')" min-width="250" />
          <el-table-column prop="start_date" sortable="custom" :label="$t('label.polling-start')" min-width="150" align="center">
            <template slot-scope="{row}">
              {{ row.start_date | moment('D MMM YYYY') }}
            </template>
          </el-table-column>
          <el-table-column prop="end_date" sortable="custom" :label="$t('label.polling-end')" min-width="150" align="center">
            <template slot-scope="{row}">
              {{ row.end_date | moment('D MMM YYYY') }}
            </template>
          </el-table-column>
          <el-table-column prop="status" sortable="custom" class-name="status-col" :label="$t('label.status')" min-width="200">
            <template slot-scope="{row}">
              <el-tag :type="getStatusColor(row)">
                {{ getStatusLabel(row) }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column align="center" :label="$t('label.actions')" width="200">
            <template slot-scope="scope">
              <router-link :to="'/polling/detail/'+scope.row.id">
                <el-tooltip :content="$t('label.polling-view')" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="mini" />
                </el-tooltip>
              </router-link>
              <router-link :to="(scope.row.status !== 10 ? '/polling/edit/'+scope.row.id : '')">
                <el-tooltip :content="$t('label.polling-edit')" placement="top">
                  <el-button type="warning" icon="el-icon-edit" size="mini" :disabled="scope.row.status === 10" />
                </el-tooltip>
              </router-link>
            </template>
          </el-table-column>
        </el-table>
        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
    </el-row>
  </div>
</template>
<script>
import { fetchList } from '@/api/polling'
import Pagination from '@/components/Pagination'
import ListFilter from './_listfilter'
import moment from 'moment'
export default {
  components: { Pagination, ListFilter },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '10': 'success',
        '0': 'info',
        '5': 'warning',
        '3': 'danger'
      }
      return statusMap[status]
    }
  },
  props: {
    roleId: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        title: null,
        status: null,
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        sort_by: 'updated_at',
        sort_order: 'descending',
        page: 1,
        limit: 10
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
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },
    getStatusColor(row) {
      const now = moment()
      const startDate = moment(row.start_date).startOf('day')
      const endDate = moment(row.end_date).endOf('day')

      const isRunning = now.isBetween(startDate, endDate, null, '[]')

      if (row.status === 10 && isRunning) {
        return 'success'
      }

      if (row.status === 10 && now.isAfter(endDate)) {
        return 'warning'
      }

      if (row.status === 1) {
        return 'danger'
      }

      if (row.status === 0) {
        return 'info'
      }

      return row.status_label
    },
    getStatusLabel(row) {
      const now = moment()
      const startDate = moment(row.start_date).startOf('day')
      const endDate = moment(row.end_date).endOf('day')

      const isRunning = now.isBetween(startDate, endDate, null, '[]')

      if (row.status === 10 && isRunning) {
        return this.$t('label.polling-live')
      }

      if (row.status === 10 && now.isAfter(endDate)) {
        return this.$t('label.polling-end')
      }

      return row.status_label
    },
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },
    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },
    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    }
  }

}
</script>
<style lang="scss" scoped>

</style>

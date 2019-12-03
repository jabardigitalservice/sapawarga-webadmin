<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/broadcast/create' }">
              <el-button v-if="roles" type="primary" size="small" icon="el-icon-plus">
                {{ $t('route.broadcast-create') }}
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="title" sortable="custom" :label="$t('label.title-broadcast')" min-width="300" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" :label="$t('label.status')" width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column prop="created_at" sortable="custom" align="center" :label="$t('label.created_at')" width="150">
            <template slot-scope="{row}">
              {{ row.created_at | moment('D MMM YYYY HH:mm') }}
            </template>
          </el-table-column>

          <el-table-column prop="updated_at" sortable="custom" align="center" :label="$t('label.send_at')" width="150">
            <template slot-scope="{row}">
              {{ getSentDateTime(row) | moment('D MMM YYYY HH:mm') }}
            </template>
          </el-table-column>

          <el-table-column align="center" :label="$t('label.actions')" width="200px">
            <template slot-scope="scope">
              <router-link :to="'/broadcast/detail/'+scope.row.id">
                <el-tooltip content="Detail Pesan" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <router-link :to="scope.row.status === 0 ? '/broadcast/edit/' +scope.row.id : ''">
                <el-tooltip content="Edit Pesan" placement="top">
                  <el-button v-if="roles" type="warning" icon="el-icon-edit" size="small" :disabled="scope.row.status === status.PUBLISHED || scope.row.status === status.SCHEDULED " />
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
import { fetchList } from '@/api/broadcast'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import ListFilter from './_listfilter'
import checkPermission from '@/utils/permission'
export default {

  components: { Pagination, ListFilter },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '10': 'success',
        '0': 'info',
        '-1': 'danger',
        '5': 'warning'
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
      roles: checkPermission(['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']),
      listLoading: true,
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      listQuery: {
        title: null,
        sort_by: 'updated_at',
        sort_order: 'descending',
        page: 1,
        limit: 10,
        status: null,
        kabkota_id: null,
        kec_id: null,
        kel_id: null
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

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    getSentDateTime(row) {
      return row.is_scheduled === true ? row.scheduled_datetime : row.status === this.status.PUBLISHED ? row.updated_at : '-'
    },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    }
  }
}
</script>

<style lang="scss" scoped>
  .pagination-container {
    width: 100%;
    overflow: auto;
  }
</style>

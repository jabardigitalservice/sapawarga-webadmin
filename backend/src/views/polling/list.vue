<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/polling/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Polling Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>
        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
          <el-table-column prop="name" sortable="custom" label="Nama Polling" min-width="250" />
          <el-table-column prop="start_date" sortable="custom" label="Mulai" width="170" align="center">
            <template slot-scope="{row}">
              {{ row.start_date | moment('D MMMM YYYY HH:mm') }}
            </template>
          </el-table-column>
          <el-table-column prop="end_date" sortable="custom" label="Berakhir" width="170" align="center">
            <template slot-scope="{row}">
              {{ row.end_date | moment('D MMMM YYYY HH:mm') }}
            </template>
          </el-table-column>
          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" width="150">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column align="center" label="Actions" width="200">
            <template slot-scope="scope">
              <router-link :to="'/polling/detail/'+scope.row.id">
                <el-button type="white" size="mini">
                  View
                </el-button>
              </router-link>
              <router-link :to="'/polling/edit/'+scope.row.id">
                <el-button type="white" size="mini" :disabled="scope.row.status === 10">
                  Edit
                </el-button>
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
export default {
  components: { Pagination },
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
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    }
  }

}
</script>
<style lang="scss" scoped>

</style>

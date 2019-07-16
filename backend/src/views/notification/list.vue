<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/notification/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Notifikasi Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="title" sortable="custom" label="Judul" min-width="350" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column prop="created_at" sortable="custom" label="Dibuat" width="150">
            <template slot-scope="{row}">
              {{ row.created_at | moment('D MMMM YYYY HH:mm') }}
            </template>
          </el-table-column>

          <el-table-column prop="updated_at" sortable="custom" label="Dikirim" width="150">>
            <template slot-scope="{row}">
              {{ getSentDateTime(row) | moment('D MMMM YYYY HH:mm') }}
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" width="250px">
            <template slot-scope="scope">
              <router-link :to="'/notification/show/'+scope.row.id">
                <el-button type="white" size="mini">
                  View
                </el-button>
              </router-link>
              <router-link :to="(scope.row.status !== 10 ? '/notification/edit/' +scope.row.id : '')">
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
import { fetchList } from '@/api/notification'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import ListFilter from './_listfilter'

export default {
  components: { Pagination, ListFilter },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '10': 'success',
        '0': 'info',
        '-1': 'danger'
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

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)

      this.getList()
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    getSentDateTime(row) {
      return row.status === 10 ? row.updated_at : ''
    },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },

    async activateRecord(id) {
      try {
        await this.$confirm(this.$t('crud.deactivate-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        // await activate(id)

        this.$message({
          type: 'success',
          message: this.$t('crud.activate-success')
        })

        this.getList()
      } catch (e) {
        console.log(e)
      }
    },

    async deactivateRecord(id) {
      try {
        await this.$confirm(this.$t('crud.deactivate-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        // await deactivate(id)

        this.$message({
          type: 'success',
          message: this.$t('crud.deactivate-success')
        })

        this.getList()
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>

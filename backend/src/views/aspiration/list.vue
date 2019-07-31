<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :lg="24">

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width; 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="title" sortable="custom" label="Judul Usulan" min-width="225" />

          <el-table-column prop="category.name" sortable="custom" label="Kategori" align="center" min-width="150" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" min-width="160">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column prop="created_at" sortable="custom" label="Dibuat" align="center" min-width="125">
            <template slot-scope="{row}">
              {{ row.created_at | moment('D MMMM YYYY') }}
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" width="150px">
            <template slot-scope="scope">
              <router-link :to="'/aspirasi/detail/'+scope.row.id">
                <el-button type="white" size="medium">
                  Lihat
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
import { fetchList } from '@/api/aspiration'
import Pagination from '@/components/Pagination'

import ListFilter from './_listfilter'

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
        category_id: null,
        status: null,
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
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

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    }
  }

}
</script>

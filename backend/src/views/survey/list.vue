<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :sm="24">

        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/survey/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Survei Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="title" sortable="custom" label="Nama Survei" />

          <el-table-column prop="start_date" sortable="custom" label="Mulai" width="150" align="center">
            <template slot-scope="{row}">
              {{ row.start_date | moment('D MMMM YYYY') }}
            </template>
          </el-table-column>
          <el-table-column prop="end_date" sortable="custom" label="Berakhir" width="150" align="center">
            <template slot-scope="{row}">
              {{ row.end_date | moment('D MMMM YYYY') }}
            </template>
          </el-table-column>

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" width="200">
            <template slot-scope="{row}">
              <el-tag :type="statusColor(row)">
                {{ statusLabel(row) }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column align="center" label="Actions" width="250">
            <template slot-scope="scope">
              <a :href="scope.row.external_url" target="_blank">
                <el-button type="white" size="mini">
                  Preview
                </el-button>
              </a>
              <router-link :to="'/survey/detail/'+scope.row.id">
                <el-button type="white" size="mini">
                  View
                </el-button>
              </router-link>
              <router-link :to="scope.row.status === 0 ? `/survey/edit/${scope.row.id}` : ``">
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
import { fetchList } from '@/api/survey'
import Pagination from '@/components/Pagination'
import ListFilter from './_listfilter'

import { getStatusColor, getStatusLabel } from './status'

export default {
  components: { Pagination, ListFilter },
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
    statusColor: getStatusColor,
    statusLabel: getStatusLabel,
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
<style lang="scss" scoped>

</style>

<template>
  <div class="app-container">

    <!-- STATISTIK TAMPILKAN DI ATAS COY -->

    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/user/create', query: { role_id: roleId }}">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Pengguna Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" />

          <el-table-column prop="name" sortable="custom" label="Nama Pengguna" />

          <el-table-column label="Kedudukan">
            <template slot-scope="{row}">
              {{ getKedudukan(row) }}
            </template>
          </el-table-column>

          <el-table-column prop="phone" width="150" sortable="custom" label="Telp" />
          <el-table-column prop="role_label" width="150" label="Role" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" width="250px">
            <template slot-scope="scope">
              <router-link :to="'/user/show/'+scope.row.id">
                <el-button type="white" size="mini">
                  View
                </el-button>
              </router-link>
              <router-link :to="'/user/edit/'+scope.row.id">
                <el-button type="white" size="mini">
                  Edit
                </el-button>
              </router-link>
              <router-link :to="'/user/edit/'+scope.row.id">
                <el-button type="danger" size="mini">
                  Deactivate
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
import _ from 'lodash'

import { fetchList } from '@/api/staff'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination

import ListFilter from './_listfilter'

export default {

  components: { Pagination, ListFilter },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '10': 'success',
        '1': 'info',
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
      dialogAdvancedSearchVisible: false,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        name: null,
        phone: null,
        status: null,
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        role_id: this.roleId,
        sortBy: 'name',
        sortOrder: 'ascending',
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

    getKedudukan(user) {
      const userRole = _.get(user, 'role_id')

      const rw = _.get(user, 'rw', 'N/A')
      const kelurahan = _.get(user, 'kelurahan.name', 'N/A')
      const kecamatan = _.get(user, 'kecamatan.name')
      const kabkota = _.get(user, 'kabkota.name')

      if (userRole === 'staffRW') {
        return `RW ${rw}, Kelurahan ${kelurahan}, Kecamatan ${kecamatan}, ${kabkota}`
      }

      if (userRole === 'staffKel') {
        return `Kelurahan ${kelurahan}, Kecamatan ${kecamatan}, ${kabkota}`
      }

      if (userRole === 'staffKec') {
        return `Kecamatan ${kecamatan}, ${kabkota}`
      }

      if (userRole === 'staffKabkota') {
        return `${kabkota}, Provinsi Jawa Barat`
      }

      if (userRole === 'staffProv') {
        return `Provinsi Jawa Barat`
      }
    },

    changeSort(e) {
      this.listQuery.sortBy = e.prop
      this.listQuery.sortOrder = e.order
      this.getList()
    }
  }
}
</script>

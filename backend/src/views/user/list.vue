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
          <el-col :span="12">
            <input-filter-area />
          </el-col>
        </el-row>

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" />

          <el-table-column prop="name" sortable="custom" label="Name" />
          <el-table-column prop="address" sortable="custom" label="Kedudukan" />
          <el-table-column prop="phone" sortable="custom" label="Telp" />
          <el-table-column prop="role_label" label="Role" />

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
import { fetchList } from '@/api/staff'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import InputFilterArea from '@/components/InputFilterArea'

export default {

  components: { Pagination, InputFilterArea },
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
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
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

    changeSort(e) {
      this.listQuery.sortBy = e.prop
      this.listQuery.sortOrder = e.order
      this.getList()
    }
  }
}
</script>

<style scoped>
  .edit-input {
    padding-right: 100px;
  }
  .cancel-btn {
    position: absolute;
    right: 15px;
    top: 10px;
  }
</style>

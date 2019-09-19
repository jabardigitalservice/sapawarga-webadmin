<template>
  <div class="app-container" name="release-management-list">
    <el-row :gutter="10">
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/release-management/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Berita Counter Hoax
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
          <el-table-column prop="title" min-width="200" align="center" label="Judul" />
          <el-table-column
            prop="status"
            sortable="custom"
            class-name="status-col"
            label="Status"
            align="center"
            min-width="100"
          >
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column prop="category.name" align="center" label="Kategori" />
          <el-table-column prop="source_date" align="center" label="Tanggal" />

          <el-table-column align="center" label="Actions" min-width="130">
            <template slot-scope="scope">
              <el-button type="primary" size="mini">
                Detail
              </el-button>
              <router-link :to="'/release-management/edit/' +scope.row.id">
                <el-button type="white" size="mini">
                  Edit
                </el-button>
              </router-link>
              <el-button type="danger" size="mini">
                Hapus
              </el-button>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchList } from '@/api/newsHoax'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination

export default {
  components: {
    Pagination
  },
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
        type: null,
        name: null,
        sort_by: 'created_at',
        sort_order: 'descending',
        page: 1,
        limit: 10
      }
    }
  },

  mounted() {
    this.getList()
  },

  methods: {
    getList() {
      this.listLoading = true
      fetchList().then(response => {
        this.list = response.data.items
        this.total = 10
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

<template>
  <div class="app-container" name="release-management-list">
    <el-row :gutter="20">
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/release-management/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Release
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <!-- <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" /> -->

          <el-table-column prop="version" sortable="custom" label="Version" min-width="150" />

          <el-table-column prop="force_update" :formatter="cellValueRenderer" sortable="custom" label="Force Update" min-width="150" />

          <el-table-column align="center" label="Actions" min-width="150px">
            <template slot-scope="scope">
              <router-link :to="'/release-management/edit/' +scope.row.id">
                <el-button type="white" size="mini">
                  Edit
                </el-button>
              </router-link>
              <el-button type="danger" size="mini" @click="deleteRelease(scope.row.id)">
                Hapus
              </el-button>
            </template>
          </el-table-column>
        </el-table>

        <!-- <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" /> -->
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchList } from '@/api/releaseManagement'
// import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import { deleteData } from '@/api/releaseManagement'

export default {
  components: {
    // Pagination,
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
        version: null,
        sort_by: 'name',
        sort_order: 'ascending',
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
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)

      this.getList()
    },

    // getTableRowNumbering(index) {
    //   return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    // },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },

    async deleteRelease(id) {
      try {
        await this.$confirm(this.$t('crud.delete-confirm'), 'warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        await deleteData(id)

        this.$message({
          type: 'success',
          message: this.$t('crud.delete-success')
        })

        this.getList()
      } catch (e) {
        console.log(e)
      }
    },
    cellValueRenderer(row, column, cellValue, index) {
      let value = cellValue
      if (typeof row[column.property] === 'boolean') {
        if (cellValue === true) {
          value = 'Ya'
        } else {
          value = 'Tidak'
        }
        // const str = String(cellValue)
        // value = str.charAt(0).toUpperCase() + str.slice(1)
      }
      return value
    }
  }
}
</script>

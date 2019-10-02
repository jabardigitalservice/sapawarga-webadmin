<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 10px">
          <el-col :span="12">
            <router-link :to="{ path: '/banner/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Banner Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <!-- ListFilter -->

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row>
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
          <el-table-column prop="name" sortable="custom" label="Judul Banner" min-width="250" />
          <el-table-column prop="name" sortable="custom" label="Kategori" min-width="200" />
          <el-table-column prop="name" sortable="custom" label="Tautan" min-width="200" />
          <el-table-column align="center" label="Actions" width="250">
            <template slot-scope="scope">
              <router-link :to="'/banner/detail/'+scope.row.id">
                <el-tooltip content="Detail Banner" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <router-link :to="(scope.row.status !== 10 && scope.row.created_by === user_id ? '/banner/edit/' +scope.row.id : '')">
                <el-tooltip content="Edit Banner" placement="top">
                  <el-button type="warning" icon="el-icon-edit" size="small" :disabled="scope.row.status === 10 || scope.row.created_by !== user_id" />
                </el-tooltip>
              </router-link>
              <el-tooltip content="Hapus Banner" placement="top">
                <el-button type="danger" icon="el-icon-delete" size="small" :disabled="scope.row.status === 10 || scope.row.created_by !== user_id" @click="deleteNews(scope.row.id)" />
              </el-tooltip>
              <el-tooltip content="Nonaktifkan Banner" placement="top">
                <el-button v-if="scope.row.status === 10" type="danger" icon="el-icon-circle-close" size="small" :disabled="scope.row.created_by !== user_id" @click="deactivateRecord(scope.row.id)" />
              </el-tooltip>
              <el-tooltip content="Aktifkan Banner" placement="top">
                <el-button v-if="scope.row.status === 0" type="success" icon="el-icon-circle-check" size="small" :disabled="scope.row.created_by !== user_id" @click="activateRecord(scope.row.id)" />
              </el-tooltip>
            </template>
          </el-table-column>
        </el-table>
        <!-- <pagination
          v-show="total>0"
          :total="total"
          :page.sync="listQuery.page"
          :limit.sync="listQuery.limit"
          @pagination="getList"
        /> -->
      </el-col>
    </el-row>
  </div>
</template>

<script>
// import Pagination from '@/components/Pagination'
import { fetchList } from '@/api/banner'
export default {
  // components: { Pagination },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        title: null,
        category: null,
        status: null
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


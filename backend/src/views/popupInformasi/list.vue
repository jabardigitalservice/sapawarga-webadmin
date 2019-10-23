<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 10px">
          <el-col :span="12">
            <router-link :to="{ path: '/popup-informasi/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Pop-Up Informasi Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
          <el-table-column prop="title" sortable="custom" label="Judul Pop-Up Informasi" min-width="250" />
          <el-table-column prop="type" sortable="custom" label="Kategori" align="center" min-width="130" />
          <el-table-column prop="start_date" sortable="custom" label="Tanggal Mulai" align="center" min-width="125">
            <template slot-scope="{row}">
              {{ row.start_date | moment('D MMM YYYY') }}
            </template>
          </el-table-column>
          <el-table-column prop="end_date" sortable="custom" label="Tanggal Akhir" align="center" min-width="125">
            <template slot-scope="{row}">
              {{ row.end_date | moment('D MMM YYYY') }}
            </template>
          </el-table-column>
          <el-table-column align="center" label="Actions" width="250">
            <template slot-scope="scope">
              <router-link :to="'/popup-informasi/detail/'+scope.row.id">
                <el-tooltip content="Detail Pop-Up Informasi" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <router-link :to="(scope.row.created_by === user_id ? '/popup-informasi/edit/' +scope.row.id : '')">
                <el-tooltip content="Edit Pop-Up Informasi" placement="top">
                  <el-button type="warning" icon="el-icon-edit" size="small" :disabled="scope.row.created_by !== user_id" />
                </el-tooltip>
              </router-link>
              <el-tooltip content="Hapus Pop-Up Informasi" placement="top">
                <el-button type="danger" icon="el-icon-delete" size="small" :disabled="scope.row.created_by !== user_id" @click="deletePopUpInformasi(scope.row.id)" />
              </el-tooltip>
            </template>
          </el-table-column>
        </el-table>
        <pagination
          v-show="total>0"
          :total="total"
          :page.sync="listQuery.page"
          :limit.sync="listQuery.limit"
          @pagination="getList"
        />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'
import ListFilter from './_listfilter'
import { fetchList, deleteData } from '@/api/popupInformasi'
import { mapGetters } from 'vuex'

export default {
  components: { Pagination, ListFilter },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '10': 'success',
        '0': 'info'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        title: null,
        type: null,
        status: null,
        page: 1,
        limit: 10
      }
    }
  },

  computed: {
    ...mapGetters([
      'user_id'
    ])
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

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    },
    async deletePopUpInformasi(id) {
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
    }
  }
}
</script>


<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :lg="24">

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="text" sortable="custom" :label="$t('label.post-title')" min-width="300" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" :label="$t('label.status')" width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column prop="likes_count" sortable="custom" align="center" :label="$t('label.post-like')" width="150" />

          <el-table-column align="center" :label="$t('label.actions')" width="200px">
            <template slot-scope="scope">
              <router-link :to="'/post/detail/'+scope.row.id">
                <el-tooltip content="Detail Kegiatan" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <el-tooltip :content="$t('label.post-tooltip-active')" placement="top">
                <el-button v-if="scope.row.status === 0" type="success" icon="el-icon-circle-check" size="small" @click="activateRecord(scope.row.id)" />
              </el-tooltip>
              <el-tooltip :content="$t('label.post-tooltip-inactive')" placement="top">
                <el-button v-if="scope.row.status === 10" type="danger" icon="el-icon-circle-close" size="small" @click="deactivateRecord(scope.row.id)" />
              </el-tooltip>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchList, deactivate, activate } from '@/api/post'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import ListFilter from './_listfilter'
export default {
  components: { Pagination, ListFilter },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '10': 'success',
        '0': 'info',
        '-1': 'danger',
        '5': 'warning'
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
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      listQuery: {
        search: null,
        sort_by: 'created_at',
        sort_order: 'descending',
        page: 1,
        limit: 10,
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
    },

    async deactivateRecord(id) {
      try {
        await this.$confirm(this.$t('crud.deactivate-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        await deactivate(id)

        this.$message.success(this.$t('crud.deactivate-success'))

        this.getList()
      } catch (e) {
        console.log(e)
      }
    },
    async activateRecord(id) {
      try {
        await this.$confirm(this.$t('crud.activate-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })
        this.listLoading = true

        await activate(id)

        this.$message.success(this.$t('crud.activate-success'))

        this.getList()
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>

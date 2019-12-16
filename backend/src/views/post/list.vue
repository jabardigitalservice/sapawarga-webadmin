<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :lg="24">

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="title" sortable="custom" :label="$t('label.post-title')" min-width="300" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" :label="$t('label.status')" width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column prop="likes" sortable="custom" align="center" :label="$t('label.post-like')" width="150" />

          <el-table-column align="center" :label="$t('label.actions')" width="200px">
            <template slot-scope="scope">
              <router-link :to="'/post/detail/'+scope.row.id">
                <el-tooltip content="Detail Kegiatan" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <el-tooltip :content="$t('label.post-tooltip-active')" placement="top">
                <el-button type="success" icon="el-icon-circle-check" size="small" @click="publishRecord(scope.row.id, scope.row.approval_note)" />
              </el-tooltip>
              <el-tooltip :content="$t('label.post-tooltip-inactive')" placement="top">
                <el-button type="danger" icon="el-icon-circle-close" size="small" @click="unpublishRecord(scope.row.id)" />
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
import { fetchList } from '@/api/broadcast'
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
        title: null,
        sort_by: 'updated_at',
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
    }
  }
}
</script>

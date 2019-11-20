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
              {{ parsingDatetime(row.updated_at, 'D MMM YYYY HH:mm') }}
            </template>
          </el-table-column>

          <el-table-column prop="status" label="Actions" header-align="center" width="120">
            <template slot-scope="scope" align="left">
              <router-link :to="'/aspirasi/detail/'+scope.row.id">
                <el-tooltip :content="$t('label.aspiration-tooltip-detail')" placement="top">
                  <el-button type="primary" align="left" icon="el-icon-view" size="small" style="margin-left:5px" />
                </el-tooltip>
              </router-link>
              <el-tooltip :content="$t('label.aspiration-tooltip-publish')" placement="top">
                <el-button v-if="setPublish(scope.row.status)" type="success" icon="el-icon-circle-check" size="small" @click="publishRecord(scope.row.id, scope.row.approval_note)" />
              </el-tooltip>
              <el-tooltip :content="$t('label.aspiration-tooltip-unpublish')" placement="top">
                <el-button v-if="setUnpublish(scope.row.status)" type="danger" icon="el-icon-circle-close" size="small" @click="unpublishRecord(scope.row.id)" />
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
import ListFilter from './_listfilter'
import Pagination from '@/components/Pagination'
import checkPermission from '@/utils/permission'
import { parsingDatetime } from '@/utils/datetimeToString'
import { fetchList, unpublish, publish } from '@/api/aspiration'
import { AspirationStatus, RolesUser } from '@/utils/constantVariabel'

export default {
  components: { Pagination, ListFilter },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '10': 'success',
        '0': 'default',
        '5': 'warning',
        '3': 'danger',
        '7': 'info'
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
      AspirationStatus,
      RolesUser,
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
    checkPermission,
    parsingDatetime,
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

    async unpublishRecord(id) {
      try {
        await this.$confirm(this.$t('crud.unpublish-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        await unpublish(id)

        this.$message.success(this.$t('crud.unpublish-success'))

        this.getList()
      } catch (e) {
        console.log(e)
      }
    },
    async publishRecord(id, approval_note) {
      try {
        await this.$confirm(this.$t('crud.publish-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })
        this.listLoading = true

        await publish(id, approval_note)

        this.$message.success(this.$t('crud.publish-success'))

        this.getList()
      } catch (e) {
        console.log(e)
      }
    },
    setPublish(status) {
      const publish = status === AspirationStatus.UNPUBLISH && checkPermission([RolesUser.ADMIN, RolesUser.STAFFPROV])

      if (publish) {
        return true
      } else {
        return false
      }
    },
    setUnpublish(status) {
      const unpublish = status === AspirationStatus.PUBLISH && checkPermission([RolesUser.ADMIN, RolesUser.STAFFPROV])

      if (unpublish) {
        return true
      } else {
        return false
      }
    }
  }
}
</script>

<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="7" :xl="7">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.category') }}</span>
          </div>
          <el-table stripe :data="tableDataStatistik" :show-header="false" style="width: 100%">
            <el-table-column prop="name" align="left" />
            <el-table-column prop="count" align="right" />
          </el-table>
        </el-card>
        <el-card class="top-space">
          <el-table stripe :data="tableDataStatistikTotal" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="count" align="right" />
          </el-table>
        </el-card>
      </el-col>

      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="17" :xl="17">

        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/video/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                {{ $t('label.video-add') }}
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" align="center" width="50" :index="getTableRowNumbering" />

          <el-table-column :label="$t('label.video-title')" sortable="custom" prop="title" min-width="200">
            <template slot-scope="{row}">
              {{ text_truncate(row.title) }}
            </template>
          </el-table-column>

          <el-table-column prop="category.name" sortable="custom" :label="$t('label.category')" align="center" width="120" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" :label="$t('label.status')" align="center" min-width="100">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column prop="created_at" sortable="custom" :label="$t('label.created_at')" align="center" min-width="180">
            <template slot-scope="{row}">
              {{ row.created_at | moment('DD MMMM YYYY HH:MM') }}
            </template>
          </el-table-column>

          <el-table-column align="center" :label="$t('label.actions')" min-width="250px">
            <template slot-scope="scope">
              <router-link :to="'/video/detail/'+scope.row.id">
                <el-tooltip :content="$t('label.video-detail')" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <router-link :to="(scope.row.status !== 10 && scope.row.created_by === user_id ? '/video/edit/' + scope.row.id : '')">
                <el-tooltip :content="$t('label.video-edit')" placement="top">
                  <el-button type="warning" icon="el-icon-edit" size="small" :disabled="scope.row.status === 10 || scope.row.created_by !== user_id" />
                </el-tooltip>
              </router-link>
              <el-tooltip :content="$t('label.video-delete')" placement="top">
                <el-button type="danger" icon="el-icon-delete" size="small" :disabled="scope.row.status === 10 || scope.row.created_by !== user_id" @click="deleteVideo(scope.row.id)" />
              </el-tooltip>
              <el-tooltip :content="$t('label.video-inactivate')" placement="top">
                <el-button v-if="scope.row.status === 10" type="danger" icon="el-icon-circle-close" size="small" :disabled="scope.row.created_by !== user_id" @click="deactivateRecord(scope.row.id)" />
              </el-tooltip>
              <el-tooltip :content="$t('label.video-activate')" placement="top">
                <el-button v-if="scope.row.status === 0" type="success" icon="el-icon-circle-check" size="small" :disabled="scope.row.created_by !== user_id" @click="activateRecord(scope.row.id)" />
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
import { fetchList, fetchStatistic, deleteData, deactivate, activate } from '@/api/video'
import Pagination from '@/components/Pagination'
import ListFilter from './_listfilter'
import { mapGetters } from 'vuex'

export default {
  components: { Pagination, ListFilter },
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
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        title: null,
        search: null,
        category_id: null,
        page: 1,
        limit: 10
      },
      tableDataStatistik: [],
      tableDataStatistikTotal: [{ title: 'Semua Kategori', count: 0 }]
    }
  },

  computed: {
    ...mapGetters([
      'user_id'
    ])
  },

  created() {
    this.getList()
    this.getStatistic()
  },

  methods: {
    getList() {
      this.listLoading = true

      const data = {}

      Object.assign(data, this.listQuery)

      fetchList(data).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)

      this.getList()
    },

    getStatistic() {
      this.listLoading = true
      fetchStatistic().then(response => {
        this.tableDataStatistik = response.data.items
        const totalChannels = this.tableDataStatistik.reduce((a, b) => a + parseInt(b.count), 0)
        this.tableDataStatistikTotal[0].count = totalChannels
        this.listLoading = false
      })
    },

    async deleteVideo(id) {
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

    async deactivateRecord(id) {
      try {
        await this.$confirm(this.$t('crud.deactivate-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        await deactivate(id)

        this.$message({
          type: 'success',
          message: this.$t('crud.deactivate-success')
        })

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

        this.$message({
          type: 'success',
          message: this.$t('crud.activate-success')
        })

        this.getList()
      } catch (e) {
        console.log(e)
      }
    },

    text_truncate(str) {
      const maxStr = 150
      if (str.length > maxStr) {
        return str.substring(0, maxStr) + '...'
      } else {
        return str
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@media only screen and (max-width: 1200px) {
  .col-right {
    margin-top: 20px;
    margin-right: 20px;
  }
}

.top-space {
  margin-top: 20px;
}
</style>

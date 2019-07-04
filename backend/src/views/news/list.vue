<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="10" :xl="10">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Kanal Media</span>
          </div>
          <el-table stripe :data="tableDataStatistik" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="count" />
          </el-table>
        </el-card>
        <el-card class="top-space">
          <el-table stripe :data="tableDataStatistikTotal" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="count" />
          </el-table>
        </el-card>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="14" :xl="14">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/news/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Berita Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width; 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="title" sortable="custom" label="Judul Berita" min-width="200" />

          <el-table-column prop="channel.name" label="Sumber" min-width="100" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" width="200px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column prop="source_date" sortable="custom" label="Tanggal" width="150">
            <template slot-scope="{row}">
              {{ row.source_date | moment('D MMMM YYYY') }}
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" width="150px">
            <template slot-scope="scope">
              <router-link :to="'/news/detail/'+scope.row.id">
                <el-button type="white" size="medium">
                  View
                </el-button>
              </router-link>
              <router-link :to="'/news/edit/'+scope.row.id">
                <el-button type="white" size="medium">
                  Edit
                </el-button>
              </router-link>
              <el-button type="danger" size="medium" @click="deleteNews(scope.row.id)">
                Delete
              </el-button>
              <el-button v-if="scope.row.status === 10" type="white" size="mini">
                Deactivate
              </el-button>
              <el-button v-if="scope.row.status === 0" type="success" size="mini">
                Activate
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
import { fetchList, fetchStatistic, deleteData } from '@/api/news'
import moment from 'moment'
import Pagination from '@/components/Pagination'
import ListFilter from './_listfilter'

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
        source: null,
        source_date: null,
        page: 1,
        limit: 10
      },
      tableDataStatistik: [],
      tableDataStatistikTotal: [{ title: 'Semua Kategori', count: 0 }]
    }
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

        data.source_date = moment(data.source_date).format('YYYY-MM-DD')

      fetchList(data).then(response => {
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

    getStatistic() {
      this.listLoading = true
      fetchStatistic().then(response => {
        this.tableDataStatistik = response.data.items
        const totalChannels = this.tableDataStatistik.reduce((a, b) => a + b.count, 0)
        this.tableDataStatistikTotal[0].count = totalChannels
        this.listLoading = false
      })
    },

    async deleteNews(id) {
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

<style lang="scss">
@media only screen and (max-width: 1200px) {
  .col-right {
    margin-top: 20px;
    margin-right: 20px !important
  }
}

.top-space {
  margin-top: 20px;
}
</style>

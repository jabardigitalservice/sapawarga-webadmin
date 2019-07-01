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
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-card v-if="tableDataStatistikTotal.length" class="top-space">
          <el-table stripe :data="tableDataStatistikTotal" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="14" :xl="14">
        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width; 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="title" sortable="custom" label="Judul Aspirasi" min-width="200" />

          <el-table-column prop="category.name" sortable="custom" label="Kategori" min-width="100" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" width="200px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column prop="created_at" sortable="custom" label="Dibuat" width="150">
            <template slot-scope="{row}">
              {{ row.created_at | moment('D MMMM YYYY HH:mm') }}
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" width="150px">
            <template slot-scope="scope">
              <router-link :to="'/news/detail/'+scope.row.id">
                <el-button type="white" size="medium">
                  Lihat
                </el-button>
              </router-link>
              <router-link :to="'/news/edit/'+scope.row.id">
                <el-button type="white" size="medium">
                  Edit
                </el-button>
              </router-link>
              <router-link :to="'/news/delete/'+scope.row.id">
                <el-button type="white" size="medium">
                  Hapus
                </el-button>
              </router-link>
              <el-button v-if="scope.row.status === 10" type="danger" size="mini" @click="deactivateNews(scope.row.id)">
                Deactivate
              </el-button>
              <el-button v-if="scope.row.status === 0" type="success" size="mini" @click="activateNews(scope.row.id)">
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
import { fetchList } from '@/api/news'
import Pagination from '@/components/Pagination'

export default {
  components: { Pagination },
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
        page: 1,
        limit: 10
      },
      tableDataStatistik: [],
      tableDataStatistikTotal: []

      /* dummy data
      tableDataStatistik: [{ title: 'Kompas', content: 10 }, { title: 'Detik', content: 10 }],
      tableDataStatistikTotal: [{ title: 'Semua Kategori', content: 20 }] */
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

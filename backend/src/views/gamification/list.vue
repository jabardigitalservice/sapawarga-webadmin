<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 10px">
          <el-col :span="12">
            <router-link :to="{ path: '/gamification/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                {{ $t('label.gamification-add-new') }}
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter
          :list-query.sync="listQuery"
          @submit-search="getList"
          @reset-search="resetFilter"
        />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="judul" label="Judul Misi" />

          <el-table-column prop="status" label="Status" />
          <el-table-column prop="start_date" label="Start Date">
            <template slot-scope="{row}">
              {{ parsingDatetime(row.start_date/1000, 'DD MMM YYYY') }}
            </template>
          </el-table-column>
          <el-table-column prop="end_date" label="End Date">
            <template slot-scope="{row}">
              {{ parsingDatetime(row.end_date/1000, 'DD MMM YYYY') }}
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions">
            <template slot-scope="scope">
              <router-link :to="'/gamification/detail/' +scope.row.id">
                <el-tooltip content="Detail Gamification" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <router-link :to="'/gamification/edit/' +scope.row.id">
                <el-tooltip content="Edit Gamification" placement="top">
                  <el-button type="warning" icon="el-icon-edit" size="small" />
                </el-tooltip>
              </router-link>
              <el-tooltip content="Hapus Gamification" placement="top">
                <el-button type="danger" icon="el-icon-delete" size="small" />
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
import { mapGetters } from 'vuex'
// import { fetchList } from '@/api/releaseManagement'
import { parsingDatetime } from '@/utils/datetimeToString'
import Pagination from '@/components/Pagination'
import ListFilter from './components/_listfilter'

const listGamifications = [
  {
    id: 1,
    judul: 'coba 1',
    status: 'Aktif',
    start_date: Date.now(),
    end_date: Date.now()
  },
  {
    id: 2,
    judul: 'coba 2',
    status: 'Aktif',
    start_date: Date.now(),
    end_date: Date.now()
  },
  {
    id: 3,
    judul: 'coba 3',
    status: 'Aktif',
    start_date: Date.now(),
    end_date: Date.now()
  },
  {
    id: 4,
    judul: 'coba 4',
    status: 'Aktif',
    start_date: Date.now(),
    end_date: Date.now()
  },
  {
    id: 5,
    judul: 'coba 5',
    status: 'Aktif',
    start_date: Date.now(),
    end_date: Date.now()
  }
]

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
      list: listGamifications,
      total: 0,
      listLoading: false,
      listQuery: {
        start_date: '',
        end_date: '',
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

  mounted() {
    // this.getList()
  },
  methods: {
    parsingDatetime,
    getList() {
      this.listLoading = true
      // fetchList(this.listQuery).then(response => {
      //   this.list = response.data.items
      //   this.total = response.data._meta.totalCount
      //   this.listLoading = false
      // })
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

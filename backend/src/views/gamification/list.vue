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
        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="version" label="Version" min-width="150" />

          <el-table-column prop="force_update" :formatter="cellValueRenderer" label="Force Update" min-width="150" />

          <el-table-column align="center" label="Actions" min-width="150px">
            <template v-if="scope.$index === 0" slot-scope="scope">
              <router-link :to="'/gamification/edit/' +scope.row.id">
                <el-button type="white" size="mini">
                  Edit
                </el-button>
              </router-link>
              <el-button type="danger" size="mini">
                Hapus
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
import { mapGetters } from 'vuex'
import { fetchList } from '@/api/releaseManagement'
import Pagination from '@/components/Pagination'

export default {
  components: { Pagination },
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

  mounted() {
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
  }
}
</script>

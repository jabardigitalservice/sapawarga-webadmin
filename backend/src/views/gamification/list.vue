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

          <el-table-column prop="title" :label="$t('label.gamification-title-mision')" />

          <el-table-column prop="status_label" :label="$t('label.status')" />
          <el-table-column prop="start_date" :label="$t('label.start-date')">
            <template slot-scope="{row}">
              {{ row.start_date | moment('D MMMM YYYY') }}
            </template>
          </el-table-column>
          <el-table-column prop="end_date" :label="$t('label.end-date')">
            <template slot-scope="{row}">
              {{ row.end_date | moment('D MMMM YYYY') }}
            </template>
          </el-table-column>

          <el-table-column align="center" :label="$t('label.actions')">
            <template slot-scope="scope">
              <router-link :to="'/gamification/detail/' +scope.row.id">
                <el-tooltip :content="$t('label.gamification-detail')" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <router-link :to="'/gamification/edit/' +scope.row.id">
                <el-tooltip :content="$t('label.gamification-edit')" placement="top">
                  <el-button type="warning" icon="el-icon-edit" size="small" />
                </el-tooltip>
              </router-link>
              <el-tooltip :content="$t('label.gamification-delete')" placement="top">
                <el-button type="danger" icon="el-icon-delete" size="small" @click="deactivateGamification(scope.row.id)" />
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
import { fetchList, deactivate } from '@/api/gamification'
import { parsingDatetime } from '@/utils/datetimeToString'
import Pagination from '@/components/Pagination'
import ListFilter from './components/_listfilter'

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
      listLoading: false,
      listQuery: {
        start_date: '',
        end_date: '',
        title: null,
        type: null,
        status: 10,
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
    parsingDatetime,
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    async deactivateGamification(id) {
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

<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-row style="margin: 10px 0px">
        <el-col :span="12">
          <router-link :to="{ path: '/news-important/create' }">
            <el-button type="primary" size="small" icon="el-icon-plus"> {{ $t('crud.save-newsImportant') }} </el-button>
          </router-link>
        </el-col>
      </el-row>

      <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

      <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
        <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

        <el-table-column prop="title" sortable="custom" :label="$t('label.newsImportant-title')" min-width="200" />

        <el-table-column prop="category.name" sortable="custom" :label="$t('label.category')" align="center" min-width="100" />

        <el-table-column prop="status" sortable="custom" class-name="status-col" :label="$t('label.status')" align="center" min-width="100">
          <template slot-scope="{row}">
            <el-tag :type="row.status | statusFilter">
              {{ row.status_label }}
            </el-tag>
          </template>
        </el-table-column>

        <el-table-column prop="created_at" sortable="custom" :label="$t('label.newsImportant-date-updated')" align="center" min-width="110">
          <template slot-scope="{row}">
            {{ parsingDatetime(row.updated_at, 'D MMM YYYY HH:mm') }}
          </template>
        </el-table-column>

        <el-table-column :label="$t('label.actions')" align="center" width="225">
          <template slot-scope="scope">
            <router-link :to="'/news-important/detail/' + scope.row.id">
              <el-tooltip :content="$t('label.newsImportant-tooltip-detail')" placement="top">
                <el-button type="primary" icon="el-icon-view" size="small" />
              </el-tooltip>
            </router-link>
            <router-link :to="(scope.row.status !== 10 && scope.row.created_by === user_id ? '/news-important/edit/' +scope.row.id : '')">
              <el-tooltip :content="$t('label.newsImportant-tooltip-edit')" placement="top">
                <el-button type="warning" icon="el-icon-edit" size="small" :disabled="scope.row.status === 10 || scope.row.created_by !== user_id" />
              </el-tooltip>
            </router-link>
            <el-tooltip :content="$t('label.newsImportant-tooltip-delete')" placement="top">
              <el-button type="danger" icon="el-icon-delete" size="small" :disabled="scope.row.status === 10 || scope.row.created_by !== user_id" @click="deleteNewsImportant(scope.row.id)" />
            </el-tooltip>
            <el-tooltip :content="$t('label.newsImportant-tooltip-nonactive')" placement="top">
              <el-button v-if="scope.row.status === 10" type="danger" icon="el-icon-circle-close" size="small" :disabled="scope.row.created_by !== user_id" @click="deactivateRecord(scope.row.id)" />
            </el-tooltip>
            <el-tooltip :content="$t('label.newsImportant-tooltip-active')" placement="top">
              <el-button v-if="scope.row.status === 0" type="success" icon="el-icon-circle-check" size="small" :disabled="scope.row.created_by !== user_id" @click="activateRecord(scope.row.id)" />
            </el-tooltip>
          </template>
        </el-table-column>
      </el-table>
      <Pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    </el-row>
  </div>
</template>

<script>
import { fetchList, deleteData, deactivate, activate } from '@/api/newsImportant'
import { mapGetters } from 'vuex'
import ListFilter from './_listfilter'
import Pagination from '@/components/Pagination'
import { parsingDatetime } from '@/utils/datetimeToString'

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
  props: {},
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        title: null,
        category_id: null,
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
    parsingDatetime,
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
    async deleteNewsImportant(id) {
      try {
        await this.$confirm(this.$t('crud.delete-confirm'), 'warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        await deleteData(id)

        this.$message.success(this.$t('crud.delete-success'))

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

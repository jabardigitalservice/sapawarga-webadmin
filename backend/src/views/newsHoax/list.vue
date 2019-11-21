<template>
  <div class="app-container" name="berita-counter-hoax">
    <el-row :gutter="10">
      <el-col :lg="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/news-hoax/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                {{ $t('label.add-news-counter-hoax') }}
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
          <el-table-column prop="title" sortable="custom" min-width="200" align="center" :label="$t('label.title')" />
          <el-table-column
            prop="status"
            sortable="custom"
            class-name="status-col"
            :label="$t('label.status')"
            align="center"
            min-width="100"
          >
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column prop="category.name" align="center" :label="$t('label.category')" sortable="custom" />
          <el-table-column prop="source_date" align="center" :label="$t('label.date')" sortable="custom" />

          <el-table-column align="center" :label="$t('label.actions')" min-width="130">
            <template slot-scope="scope">
              <router-link :to="'/news-hoax/detail/' +scope.row.id">
                <el-button type="info" icon="el-icon-view" size="small" />
              </router-link>
              <el-button type="danger" icon="el-icon-delete" size="small" :disabled="scope.row.status === 10" @click="deleteNews(scope.row.id)" />
              <router-link :to="(scope.row.status !== 10 ? '/news-hoax/edit/' +scope.row.id : '')">
                <el-button type="info" icon="el-icon-edit" size="small" :disabled="scope.row.status === 10" />
              </router-link>
              <el-tooltip content="Nonaktifkan Berita Counter Hoax" placement="top">
                <el-button v-if="scope.row.status === 10" type="danger" icon="el-icon-circle-close" size="small" @click="deactivateRecord(scope.row.id)" />
              </el-tooltip>
              <el-tooltip content="Aktifkan Berita Counter Hoax" placement="top">
                <el-button v-if="scope.row.status === 0" type="success" icon="el-icon-circle-check" size="small" @click="activateRecord(scope.row.id)" />
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
import { fetchList } from '@/api/newsHoax'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import { deleteData, deactivate, activate } from '@/api/newsHoax'
import ListFilter from './components/_listfilter'

export default {
  components: {
    Pagination,
    ListFilter
  },
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
      listQuery: {
        type: null,
        search: null,
        category_id: null,
        page: 1,
        limit: 10
      }
    }
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
    }

  }
}
</script>

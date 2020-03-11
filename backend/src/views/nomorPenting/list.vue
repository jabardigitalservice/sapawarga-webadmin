<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="24">
        <el-row v-if="!isDisabledButton" style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="(!isDisabledButton) ? { path: '/nomor-penting/create' } : ''">
              <el-button :disabled="isDisabledButton" type="primary" size="small" icon="el-icon-plus">
                Tambah Nomor Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" sortable="custom" label="Nama Instansi" />

          <el-table-column prop="category.name" sortable="custom" align="center" label="Kategori" />

          <el-table-column prop="phone_numbers" align="center" label="Nomor Telepon">
            <template slot-scope="{row}">
              <div v-html="showPhoneNumbers(row.phone_numbers)" />
            </template>
          </el-table-column>

          <el-table-column prop="address" label="Alamat" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" width="225">
            <template slot-scope="scope">

              <router-link :to="'/nomor-penting/show/'+scope.row.id">
                <el-tooltip :content="$t('label.newsImportant-tooltip-detail')" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>

              <router-link v-if="!isDisabledButton" :to="(!isDisabledButton) ? '/nomor-penting/edit/'+scope.row.id : ''">
                {{ /* untuk disabled bisa menggunakan function, seperti :disabled="checkDisabledButton()" */ }}
                <el-tooltip :content="$t('label.newsImportant-tooltip-edit')" placement="top">
                  <el-button type="warning" icon="el-icon-edit" size="small" :disabled="isDisabledButton" />
                </el-tooltip>
              </router-link>

              <el-tooltip :content="$t('label.newsImportant-tooltip-nonactive')" placement="top">
                <el-button v-if="scope.row.status === 10 && !isDisabledButton" :disabled="isDisabledButton" type="danger" icon="el-icon-circle-close" size="small" @click="deactivateRecord(scope.row.id)" />
              </el-tooltip>

              <el-tooltip :content="$t('label.newsImportant-tooltip-active')" placement="top">
                <el-button v-if="scope.row.status === 0 && !isDisabledButton" :disabled="isDisabledButton" type="success" icon="el-icon-circle-check" size="small" @click="activateRecord(scope.row.id)" />
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
import { fetchList, activate, deactivate } from '@/api/phonebooks'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import checkPermission from '@/utils/permission'
import ListFilter from './_listfilter'

export default {

  components: { Pagination, ListFilter },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '10': 'success',
        '1': 'warning',
        '0': 'info',
        '-1': 'danger'
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
        name: null,
        category_id: null,
        address: null,
        phone: null,
        sequence: null,
        status: null,
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        sort_by: 'name',
        sort_order: 'ascending',
        page: 1,
        limit: 10
      },
      isDisabledButton: false
    }
  },

  mounted() {
    this.getList()
    this.isDisabledButton = !checkPermission(['admin', 'staffProv'])
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

    showPhoneNumbers(array) {
      return _.map(array, 'phone_number').join('<br />')
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)

      this.getList()
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    changeSort(e) {
      if (e.prop === 'category.name') {
        e.prop = 'category_id'
      }

      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },

    async activateRecord(id) {
      try {
        await this.$confirm(this.$t('crud.deactivate-confirm'), 'Warning', {
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
    }
  }
}
</script>

<template>
  <div class="app-container">

    <!-- panel-group :role-id="roleId" :total-all-user="totalAllUser" :total-user-province="totalUserProvince" :total-user-kab-kota="totalUserKabKota" :total-user-kec="totalUserKec" :total-user-kel="totalUserKel" :total-user-rw="totalUserRw" /-->

    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/nomor-penting/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Nomor Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" sortable="custom" label="Nama Instansi" />

          <el-table-column prop="category.name" sortable="custom" label="Kategori" />

          <el-table-column prop="phone_numbers" label="Nomor Telepon">
            <template slot-scope="{row}">
              <div v-html="showPhoneNumbers(row.phone_numbers)"></div>
            </template>
          </el-table-column>

          <el-table-column prop="address" label="Alamat" />
          <el-table-column prop="seq" sortable="custom" width="120" align="right" label="Sequence" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" width="250px">
            <template slot-scope="scope">
              <router-link :to="'/nomor-penting/show/'+scope.row.id">
                <el-button type="white" size="mini">
                  View
                </el-button>
              </router-link>
              <router-link :to="'/nomor-penting/edit/'+scope.row.id">
                <el-button type="white" size="mini">
                  Edit
                </el-button>
              </router-link>

              <el-button v-if="scope.row.status === 10" type="danger" size="mini" @click="deactivateRecord(scope.row.id)">
                Deactivate
              </el-button>
              <el-button v-if="scope.row.status === 0" type="success" size="mini" @click="activateRecord(scope.row.id)">
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
import { fetchList, activate, deactivate } from '@/api/phonebooks'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
// import PanelGroup from './components/PanelGroup'

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
      totalAllUser: 0,
      totalUserProvince: 0,
      totalUserKabKota: 0,
      totalUserKec: 0,
      totalUserKel: 0,
      totalUserRw: 0
    }
  },

  created() {
    this.getList()
    this.getTotalUser()
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

    getTotalUser() {
      // totalUser().then(response => {
      //   this.totalAllUser = (_.find(response.data.items, ['level', 'all'])) ? _.find(response.data.items, ['level', 'all']).value : null
      //   this.totalUserProvince = (_.find(response.data.items, ['level', 'prov'])) ? _.find(response.data.items, ['level', 'prov']).value : null
      //   this.totalUserKabKota = (_.find(response.data.items, ['level', 'kabkota'])) ? _.find(response.data.items, ['level', 'kabkota']).value : null
      //   this.totalUserKec = (_.find(response.data.items, ['level', 'kec'])) ? _.find(response.data.items, ['level', 'kec']).value : null
      //   this.totalUserKel = (_.find(response.data.items, ['level', 'kel'])) ? _.find(response.data.items, ['level', 'kel']).value : null
      //   this.totalUserRw = (_.find(response.data.items, ['level', 'rw'])) ? _.find(response.data.items, ['level', 'rw']).value : null
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

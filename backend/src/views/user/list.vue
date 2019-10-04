<template>
  <div class="app-container">

    <panel-group :role-id="roleId" :total-all-user="totalAllUser" :total-user-province="totalUserProvince" :total-user-kab-kota="totalUserKabKota" :total-user-kec="totalUserKec" :total-user-kel="totalUserKel" :total-user-rw="totalUserRw" :total-user-saberhoax="totalUserSaberhoax" />

    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/user/create', query: { role_id: roleId }}">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Pengguna Baru
              </el-button>
            </router-link>
          </el-col>
        </el-row>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" min-width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" sortable="custom" label="Nama Lengkap" min-width="120" />

          <el-table-column prop="username" sortable="custom" label="Username" min-width="100" />

          <el-table-column label="Kedudukan" min-width="150">
            <template slot-scope="{row}">
              {{ getKedudukan(row) }}
            </template>
          </el-table-column>

          <el-table-column v-if="checkPermission(['admin', 'staffProv'])" prop="last_access_at" :formatter="formatterCell" sortable="custom" label="Akses Terakhir" min-width="120" />

          <el-table-column prop="phone" min-width="120" sortable="custom" label="Telp" />
          <el-table-column prop="role_label" min-width="150" label="Role" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" label="Status" min-width="120px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" min-width="170px">
            <template slot-scope="scope">
              <router-link :to="'/user/detail/'+scope.row.id">
                <el-tooltip content="Lihat Pengguna" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <router-link :to="'/user/edit/'+scope.row.id">
                <el-tooltip content="Edit Pengguna" placement="top">
                  <el-button type="warning" size="small" icon="el-icon-edit" />
                </el-tooltip>
              </router-link>
              <el-tooltip content="Nonaktifkan Pengguna" placement="top">
                <el-button v-if="scope.row.status === 10" type="danger" icon="el-icon-circle-close" size="small" @click="deactivateUser(scope.row.id)" />
              </el-tooltip>
              <el-tooltip content="Aktifkan Pengguna" placement="top">
                <el-button v-if="scope.row.status === 0" type="success" icon="el-icon-circle-check" size="small" @click="activateUser(scope.row.id)" />
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
import { fetchList, activate, deactivate, totalUser } from '@/api/staff'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import PanelGroup from './components/PanelGroup'
import permission from '@/directive/permission/index.js'
import checkPermission from '@/utils/permission'
import moment from 'moment'
import ListFilter from './_listfilter'

export default {
  components: { Pagination, ListFilter, PanelGroup },
  directives: { permission },
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
        username: null,
        phone: null,
        status: null,
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        role_id: this.roleId,
        profile_completed: null,
        last_access_start: null,
        last_access_end: null,
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
      totalUserRw: 0,
      totalUserSaberhoax: 0
    }
  },

  created() {
    this.getList()
    this.getTotalUser()
  },

  methods: {
    checkPermission,

    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    getTotalUser() {
      totalUser().then(response => {
        this.totalAllUser = (_.find(response.data.items, ['level', 'all'])) ? _.find(response.data.items, ['level', 'all']).value : null
        this.totalUserProvince = (_.find(response.data.items, ['level', 'prov'])) ? _.find(response.data.items, ['level', 'prov']).value : null
        this.totalUserKabKota = (_.find(response.data.items, ['level', 'kabkota'])) ? _.find(response.data.items, ['level', 'kabkota']).value : null
        this.totalUserKec = (_.find(response.data.items, ['level', 'kec'])) ? _.find(response.data.items, ['level', 'kec']).value : null
        this.totalUserKel = (_.find(response.data.items, ['level', 'kel'])) ? _.find(response.data.items, ['level', 'kel']).value : null
        this.totalUserRw = (_.find(response.data.items, ['level', 'rw'])) ? _.find(response.data.items, ['level', 'rw']).value : null
        this.totalUserSaberhoax = (_.find(response.data.items, ['level', 'saberhoax'])) ? _.find(response.data.items, ['level', 'saberhoax']).value : null
      })
    },

    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)

      this.getList()
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    getKedudukan(user) {
      const userRole = _.get(user, 'role_id')

      const rw = _.get(user, 'rw', 'N/A')
      const kelurahan = _.get(user, 'kelurahan.name', 'N/A')
      const kecamatan = _.get(user, 'kecamatan.name')
      const kabkota = _.get(user, 'kabkota.name')

      if (userRole === 'staffRW') {
        return `RW ${rw}, Desa/Kelurahan ${kelurahan}, Kecamatan ${kecamatan}, ${kabkota}`
      }

      if (userRole === 'staffKel') {
        return `Desa/Kelurahan ${kelurahan}, Kecamatan ${kecamatan}, ${kabkota}`
      }

      if (userRole === 'staffKec') {
        return `Kecamatan ${kecamatan}, ${kabkota}`
      }

      if (userRole === 'staffKabkota') {
        return `${kabkota}, Provinsi Jawa Barat`
      }

      if (userRole === 'staffProv') {
        return `Provinsi Jawa Barat`
      }
    },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },

    async activateUser(id) {
      try {
        await this.$confirm(this.$t('crud.user-activate-confirm'), 'Warning', {
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

    async deactivateUser(id) {
      try {
        await this.$confirm(this.$t('crud.user-deactivate-confirm'), 'Warning', {
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

    formatterCell(row, column, cellValue, index) {
      const value = cellValue ? moment(cellValue).format('D MMM YYYY MM:SS') : '-'
      return value
    }
  }
}
</script>

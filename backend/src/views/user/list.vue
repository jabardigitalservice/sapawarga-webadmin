<template>
  <div class="app-container">

    <panel-group :role-id="roleId" :total-all-user="totalAllUser" :total-user-province="totalUserProvince" :total-user-kab-kota="totalUserKabKota" :total-user-kec="totalUserKec" :total-user-kel="totalUserKel" :total-user-rw="totalUserRw" :total-user-saberhoax="totalUserSaberhoax" />

    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="5">
            <router-link :to="{ path: '/user/create', query: { role_id: roleId }}">
              <el-button type="primary" size="small" icon="el-icon-plus">
                Tambah Pengguna Baru
              </el-button>
            </router-link>
          </el-col>
          <el-col v-if="checkPermission(['admin', 'staffProv'])" :span="19" align="right">
            <el-button type="primary" size="small" @click="exportDataURL">Unduh Data</el-button>
            <!-- <el-button type="primary" size="small" @click="openDialog(`import`)">Import Data</el-button> -->
          </el-col>
        </el-row>
        <el-dialog :title="(importDialogVisible)? `Import Data Pengguna Sapawarga`:`Export Data`" :visible.sync="visibleDialog" :width="(importDialogVisible)? `50%`:`20%`" @close="closeDialog">
          <div v-if="importDialogVisible">
            <div class="dialog-text">Anda dapat melakukan import data dengan mengunggah file dengan tipe CSV.</div>
            <div class="dialog-text">Template file dapat diunduh pada <a href="http://">Tautan berikut</a></div>
            <div>Pilih lokasi file pada komputer Anda (max. 5 MB)</div>
            <div slot="footer" class="dialog-footer" align="left">
              <el-upload
                ref="upload"
                v-loading="listLoading"
                class="upload-demo"
                action="https://jsonplaceholder.typicode.com/posts/"
                :on-progress="handleProgress"
                :on-success="handleSuccess"
                :limit="1"
                :on-exceed="handleExceed"
                :before-remove="beforeRemove"
                :auto-upload="false"
              >
                <el-button slot="trigger" class="dialog-buttom" size="small" type="primary">Pilih File</el-button>
              </el-upload>
              <el-button type="primary" @click="submitUpload, visibleDialog = false, importDialogVisible = false">Upload File</el-button>
              <el-button type="info" @click="closeDialog">Cancel</el-button>
            </div>
          </div>
          <div v-else class="export-user">
            <span>Pilih File</span><br><br>
            <el-radio v-model="radio" label="1" border size="medium">CSV</el-radio><br><br>
            <el-radio v-model="radio" label="2" border size="medium">Excel</el-radio>
            <div slot="footer" class="dialog-footer" align="left" style="padding-top: 20px;">
              <el-button type="primary" size="small" @click="getDataExport">Download</el-button>
              <el-button type="info" size="small" @click="closeDialog">Batal</el-button>
            </div>
          </div>
        </el-dialog>

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
import { fetchList, activate, deactivate, totalUser, fetchExport } from '@/api/staff'
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
        last_access_start: '',
        last_access_end: '',
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
      totalUserSaberhoax: 0,
      visibleDialog: false,
      importDialogVisible: false,
      exportDialogVisible: false,
      radio: '1'
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
    },

    handleExceed(files, fileList) {
      this.$message.warning(`Hanya dapat mengunggah ${files.length} files. Silahkan hapus untuk mengganti file.`)
    },

    beforeRemove(file, fileList) {
      return this.$confirm(`Anda yakin akan menghapus file ${file.name} ?`)
    },

    openDialog(type) {
      if (type === 'export') {
        this.exportDialogVisible = true
      } else if (type === 'import') {
        this.importDialogVisible = true
      }
      this.visibleDialog = true
    },

    closeDialog() {
      this.exportDialogVisible = false
      this.importDialogVisible = false
      this.visibleDialog = false
    },

    submitUpload() {
      this.$refs.upload.submit()
    },

    exportDataURL() {
      fetchExport(this.listQuery).then(response => {
        this.getDataExport(response.data)
      })
    },

    getDataExport(url) {
      window.open(url)
    },

    handleProgress() {
      this.listLoading = true
    },

    handleSuccess() {
      this.listLoading = false
    }
  }
}
</script>

<style lang="scss" scoped>
  .dialog-text {
    margin-bottom: 15px;
  }

  .dialog-buttom {
    margin-bottom: 10px;
  }

  a {
    color: #4a96e8;
  }

  .export-user > span {
    font-size: 18px;
  }
</style>

<template>
  <div class="app-container">

    <panel-group
      :role-id="roleId ? roleId : store.getters.roles[0]"
      :pages="pages"
      :total-all-user="totalAllUser"
      :total-user-province="totalUserProvince"
      :total-user-kab-kota="totalUserKabKota"
      :total-user-kec="totalUserKec"
      :total-user-kel="totalUserKel"
      :total-user-rw="totalUserRw"
      :total-user-saber-hoax="totalUserSaberHoax"
      :total-user-trainer="totalUserTrainer"
      :total-user-publik="totalUserPublik"
    />

    <el-row :gutter="20">
      <el-col :span="24">
        <el-row style="margin: 10px 0px">
          <el-col :span="5">
            <router-link :to="{ path: '/user/create', query: { role_id: roleId }}">
              <el-button type="primary" size="small" icon="el-icon-plus">
                {{ $t('users.users-add-new') }}
              </el-button>
            </router-link>
          </el-col>
          <el-col v-if="checkPermission(['admin', 'staffProv'])" :span="19" align="right">
            <el-button type="primary" size="small" @click="exportDataURL">{{ $t('users.download-data') }}</el-button>
            <el-button type="primary" size="small" @click="openDialog(`import`)">{{ $t('users.users-dialog-bottom-upload-data') }}</el-button>
          </el-col>
        </el-row>
        <el-dialog :title="$t('users.users-import-data')" :visible.sync="visibleDialog" :width="(importDialogVisible)? `50%`:`20%`" @close="closeDialog">
          <div class="dialog-text">{{ $t('users.users-dialog-text-import-xlsx') }}</div>
          <div class="dialog-text">{{ $t('users.users-dialog-text-template-file') }}<a @click="getSample">{{ $t('users.users-dialog-text-url') }}</a></div>
          <div>{{ $t('users.users-dialog-text-choose-location-file') }}</div>
          <div slot="footer" class="dialog-footer" align="left">
            <div class="import-file">
              <label class="custom-file-upload primary-custome">{{ $t('label.select-file') }}
                <input id="file" ref="file" type="file" accept=".xlsx" @change="handleFileUpload()">
              </label>
              <span v-if="file !== null">{{ file.name }}</span>
            </div>

            <el-button type="primary" @click="submitFile(), visibleDialog = false, importDialogVisible = false">{{ $t('users.users-dialog-bottom-upload-file') }}</el-button>
            <el-button type="info" @click="closeDialog">{{ $t('users.users-dialog-bottom-cancel') }}</el-button>
          </div>
        </el-dialog>

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe fit highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" min-width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" sortable="custom" :label="$t('users.users-fullname')" min-width="120" />

          <el-table-column prop="username" sortable="custom" :label="$t('users.users-username')" min-width="100" />

          <el-table-column :label="$t('users.users-place')" min-width="150">
            <template slot-scope="{row}">
              {{ getKedudukan(row) }}
            </template>
          </el-table-column>

          <el-table-column v-if="checkPermission(['admin', 'staffProv'])" prop="last_access_at" :formatter="formatterCell" sortable="custom" :label="$t('users.users-last-access')" min-width="120" />

          <el-table-column prop="phone" min-width="120" sortable="custom" :label="$t('users.users-telp')" />
          <el-table-column prop="role_label" min-width="150" label="Role" />

          <el-table-column prop="status" sortable="custom" class-name="status-col" :label="$t('users.users-status')" min-width="120px">
            <template slot-scope="{row}">
              <el-tag :type="row.status | statusFilter">
                {{ row.status_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column align="center" :label="$t('users.users-actions')" min-width="170px">
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
import { fetchList, activate, deactivate, totalUser, fetchExport, downloadSample, importUser } from '@/api/staff'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import PanelGroup from './components/PanelGroup'
import permission from '@/directive/permission/index.js'
import checkPermission from '@/utils/permission'
import ListFilter from './_listfilter'
import { parsingDatetime } from '@/utils/datetimeToString'
import { RolesUser } from '@/utils/constantVariabel'
import store from '@/store'

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
    },
    pages: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      file: null,
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
      totalUserTrainer: 0,
      totalUserSaberHoax: 0,
      totalUserPublik: 0,
      visibleDialog: false,
      importDialogVisible: false,
      radio: '1',
      store
    }
  },
  created() {
    this.getTotalUser()
    this.getList()
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
        this.totalUserProvince = (_.find(response.data.items, ['level', RolesUser.STAFFPROV])) ? _.find(response.data.items, ['level', RolesUser.STAFFPROV]).value : 0
        this.totalUserKabKota = (_.find(response.data.items, ['level', RolesUser.STAFFKABKOTA])) ? _.find(response.data.items, ['level', RolesUser.STAFFKABKOTA]).value : 0
        this.totalUserKec = (_.find(response.data.items, ['level', RolesUser.STAFFKEC])) ? _.find(response.data.items, ['level', RolesUser.STAFFKEC]).value : 0
        this.totalUserKel = (_.find(response.data.items, ['level', RolesUser.STAFFKEL])) ? _.find(response.data.items, ['level', RolesUser.STAFFKEL]).value : 0
        this.totalUserRw = (_.find(response.data.items, ['level', RolesUser.STAFFRW])) ? _.find(response.data.items, ['level', RolesUser.STAFFRW]).value : 0
        this.totalUserSaberHoax = (_.find(response.data.items, ['level', RolesUser.STAFFSABERHOAX])) ? _.find(response.data.items, ['level', RolesUser.STAFFSABERHOAX]).value : null
        this.totalUserTrainer = (_.find(response.data.items, ['level', RolesUser.TRAINER])) ? _.find(response.data.items, ['level', RolesUser.TRAINER]).value : 0
        this.totalUserPublik = (_.find(response.data.items, ['level', RolesUser.PUBLIK])) ? _.find(response.data.items, ['level', RolesUser.PUBLIK]).value : 0
        this.totalAllUser = this.totalUserProvince + this.totalUserKabKota + this.totalUserKec + this.totalUserKel + this.totalUserRw + this.totalUserSaberHoax + this.totalUserTrainer + this.totalUserPublik
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

      if ((userRole === RolesUser.STAFFRW) || userRole === RolesUser.TRAINER || userRole === RolesUser.PUBLIK) {
        return this.$t('users.users-role-text-staff-rw', [rw, kelurahan, kecamatan, kabkota])
      }

      if (userRole === RolesUser.STAFFKEL) {
        return this.$t('users.users-role-text-staff-kel', [kelurahan, kecamatan, kabkota])
      }

      if (userRole === RolesUser.STAFFKEC) {
        return this.$t('users.users-role-text-staff-kec', [kecamatan, kabkota])
      }

      if (userRole === RolesUser.STAFFKABKOTA) {
        return this.$t('users.users-role-text-staff-kabkota', [kabkota])
      }

      if (userRole === RolesUser.STAFFPROV) {
        return this.$t('users.users-role-text-staff-prov')
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
      const value = cellValue ? parsingDatetime(cellValue, 'DD MMM YYYY HH:mm') : '-'
      return value
    },

    openDialog(type) {
      if (type === 'import') {
        this.importDialogVisible = true
      }
      this.visibleDialog = true
    },

    closeDialog() {
      this.importDialogVisible = false
      this.visibleDialog = false
    },

    async exportDataURL() {
      try {
        this.listLoading = true
        const data = await fetchExport(this.listQuery)
        this.getDataExport(data.data)
      } catch (error) {
        this.listLoading = false
      }
    },

    getDataExport(url) {
      window.open(url)
      this.listLoading = false
    },

    getSample() {
      downloadSample(this.listQuery).then(response => {
        window.open(response.data.file_url)
      })
    },

    handleFileUpload() {
      this.file = this.$refs.file.files[0]
    },

    submitFile() {
      const formData = new FormData()

      formData.append('file', this.file)

      importUser(formData).then(response => {
        this.file = null
        this.$message.success(this.$t('message.user-import-sending'))
      }).catch(error => {
        const errorEmpty = error.response.data.data.file
        if (errorEmpty) {
          this.$message.error(this.$t('errors.user-import-empty-file'))
        } else {
          console.log(error)
        }
      })
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

  input[type="file"] {
    display: none;
  }

  .custom-file-upload {
    cursor: pointer;
    background: #FFFFFF;
    border: 1px solid #DCDFE6;
    border-color: #DCDFE6;
    color: #606266;
    -webkit-appearance: none;
    text-align: center;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    outline: none;
    -webkit-transition: .1s;
    transition: .1s;
    font-weight: 400;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 4px;
    width: 100px;
    display: inline-block;
    margin-bottom: 20px;
  }

  .import-file {
    display: block;
  }

  .primary-custome {
    color: white;
    background:#409eff;
    border-color: #409eff;
  }

  .primary-custome:hover {
    background: #46a6ff;
    border-color: #46a6ff;
    color: #FFFFFF;
  }

</style>

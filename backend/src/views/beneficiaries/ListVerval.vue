<template>
  <div class="app-container">
    <el-row>
      <el-col :lg="24">
        <el-dropdown size="large" trigger="click" placement="bottom-end" split-button type="primary" class="dropdown" @command="handleCommand">
          {{ $t('beneficiaries.show-stage') }} <b>{{ tahapDisplay }}</b>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item v-for="item in listTahap" :key="item.value" :command="{label: item.label, value: item.value}">{{ item.label }}</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>

        <DashboardTitle :list-type="listType" />

        <!-- show statistics -->
        <StatisticsVerval :is-loading="isLoadingSummary" :is-verval="true" :list-type="listType" :summery="dataSummary" />

        <ListFilter :list-query.sync="listQuery" :is-verval="true" :is-download-verval="false" :list-type="listType" :selection-length="multipleSelection.length" @submit-search="getList" @reset-search="resetFilter" @multiple-validate="multipleValidate" />

        <el-table ref="multipleTable" v-loading="listLoading" :data="list" border stripe highlight-current-row style="width: 100%" @selection-change="handleSelectionChange" @sort-change="changeSort">
          <el-table-column v-if="listType === 'pending'" type="selection" width="55" align="center" />

          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" sortable="custom" :label="$t('label.beneficiaries-name')" min-width="200px" />

          <el-table-column prop="nik" sortable="custom" :label="$t('label.beneficiaries-nik')" min-width="175px">
            <template slot-scope="{row}">
              {{ row.nik }}
              <div v-if="row.is_nik_valid === 0" slot="reference" class="name-wrapper">
                <el-tag size="medium" type="danger">{{ $t('label.beneficiaries-nik-invalid-format') }}</el-tag>
              </div>
            </template>
          </el-table-column>

          <el-table-column prop="income_before" sortable="custom" :label="$t('label.beneficiaries-income-before')" min-width="170px">
            <template slot-scope="{row}">
              {{ formatCurrency(row.income_before, 'Rp.') }}
            </template>
          </el-table-column>

          <el-table-column prop="income_after" sortable="custom" :label="$t('label.beneficiaries-income-after')" min-width="170px">
            <template slot-scope="{row}">
              {{ formatCurrency(row.income_after, 'Rp.') }}
            </template>
          </el-table-column>

          <el-table-column prop="total_family_members" sortable="custom" align="center" :label="$t('label.beneficiaries-total-family')" min-width="150px" />

          <el-table-column align="center" :label="$t('label.actions')" width="200px">
            <template slot-scope="scope">
              <el-tooltip :content="$t('label.beneficiaries-detail')" placement="top">
                <el-button type="primary" icon="el-icon-view" size="small" @click="getDetail(scope.row.id)" />
              </el-tooltip>
              <el-tooltip v-if="listType === 'pending'" :content="$t('label.beneficiaries-validate')" placement="top">
                <el-button type="success" icon="el-icon-circle-check" size="small" :disabled="multipleSelection.length > 0" @click="validate(scope.row.id)" />
              </el-tooltip>
            </template>
          </el-table-column>
        </el-table>
        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
    </el-row>
    <el-dialog
      :visible.sync="isDetail"
      width="80%"
      :close-on-click-modal="false"
      custom-class="dialog-custome"
      :modal-append-to-body="false"
      :append-to-body="true"
      top="5vh"
      style="margin-bottom: 30px"
    >
      <span slot="title" class="dialog-title detail-title" style="margin: 0; padding: 0">Detail Penerima Bantuan</span>
      <hr class="line-separator">
      <Preview :id-detail="idDetail" :is-verval="true" @closeDialog="closeDetail" />
    </el-dialog>
  </div>
</template>

<script>
import { fetchSummaryVerval, fetchListVerval, validateStaffKelBulk, fetchCurrentTahap } from '@/api/beneficiaries'
import StatisticsVerval from './components/StatisticsVerval'
import DashboardTitle from './components/DashboardTitle'
import Pagination from '@/components/Pagination'
import Preview from './components/Preview'
import checkPermission from '@/utils/permission'
import { RolesUser } from '@/utils/constantVariable'
import ListFilter from './_listfilter'
import { mapGetters } from 'vuex'

export default {
  components: {
    StatisticsVerval,
    DashboardTitle,
    Pagination,
    ListFilter,
    Preview
  },
  filters: {
    statusFilter(status) {
      const statusMap = {
        '3': 'success',
        '2': 'danger',
        '1': 'warning'
      }
      return statusMap[status]
    }
  },
  props: {
    listType: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      list: null,
      total: 0,
      dialogVisible: false,
      isLoadingSummary: true,
      dataSummary: null,
      isDetail: false,
      idDetail: null,
      listTahap: [],
      listLoading: true,
      tahapDisplay: null,
      multipleSelection: [],
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      listQuery: {
        nik: null,
        name: null,
        sort_by: null,
        sort_order: null,
        page: 1,
        limit: 10,
        tahap: null,
        status_verification: null,
        domicile_kabkota_bps_id: null,
        domicile_kec_bps_id: null,
        domicile_kel_bps_id: null,
        domicile_rw_like: null,
        domicile_rt_like: null
      }
    }
  },
  computed: {
    ...mapGetters(['user', 'roles'])
  },
  async created() {
    await this.getStep()
    this.getList()
    this.getSummary(this.listQuery.tahap)
  },

  methods: {
    handleCommand(command) {
      this.listQuery.tahap = command.value
      this.tahapDisplay = command.label
      this.getList()
      this.getSummary(command.value)
    },

    async getStep() {
      await fetchCurrentTahap().then(response => {
        this.listQuery.tahap = response.data.current_tahap_verval
        this.tahapDisplay = this.$t('beneficiaries.stage') + this.listQuery.tahap
        for (let i = 1; i <= this.listQuery.tahap; i++) {
          const data = {
            value: i,
            label: this.$t('beneficiaries.stage') + i
          }
          this.listTahap.push(data)
        }
      })
    },

    // get summary statistics
    getSummary(value) {
      const querySummary = {
        tahap: value,
        domicile_kabkota_bps_id: this.user.kabkota ? this.user.kabkota.code_bps : null,
        domicile_kec_bps_id: this.user.kecamatan ? this.user.kecamatan.code_bps : null,
        domicile_kel_bps_id: this.user.kelurahan ? this.user.kelurahan.code_bps : null
      }

      this.isLoadingSummary = true
      fetchSummaryVerval(querySummary).then(response => {
        this.dataSummary = response.data
        this.isLoadingSummary = false
      })
    },
    getDetail(value) {
      this.idDetail = value
      this.isDetail = true
    },

    closeDetail(value) {
      if (value === 'reload') {
        this.$router.push('/beneficiaries/approved')
      } else {
        this.isDetail = false
      }
    },

    getList() {
      this.listLoading = true
      if (checkPermission([RolesUser.STAFFKEL])) {
        if (this.listType === 'pending') {
          this.listQuery.status_verification = 3
        } else if (this.listType === 'approved') {
          this.listQuery.status_verification = 5
        } else if (this.listType === 'rejected') {
          this.listQuery.status_verification = 2 || 4
        }
      } else if (checkPermission([RolesUser.STAFFKEC])) {
        if (this.listType === 'pending') {
          this.listQuery.status_verification = 5
        } else if (this.listType === 'approved') {
          this.listQuery.status_verification = 7
        } else if (this.listType === 'rejected') {
          this.listQuery.status_verification = 2 || 4
        }
      } else if (checkPermission([RolesUser.STAFFKABKOTA])) {
        if (this.listType === 'pending') {
          this.listQuery.status_verification = 7
        } else if (this.listType === 'approved') {
          this.listQuery.status_verification = 9
        } else if (this.listType === 'rejected') {
          this.listQuery.status_verification = 2 || 4
        }
      }
      fetchListVerval(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
    },

    async validate(id) {
      try {
        await this.$confirm(this.$t('crud.approval-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        await validateStaffKelBulk(id)

        this.$message.success(this.$t('crud.approval-success'))

        this.getList()
        this.getSummary(this.listQuery.tahap)
      } catch (e) {
        console.log(e)
      }
    },

    resetFilter() {
      const tahap = this.listQuery.tahap
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)

      // set tahap
      this.listQuery.tahap = tahap
      this.getList()
    },

    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },

    formatCurrency(value, prefix) {
      if (value) {
        const number_string = value.toString()
        const split = number_string.split(',')
        const modulo = split[0].length % 3
        let rupiah = split[0].substr(0, modulo)
        const thousand = split[0].substr(modulo).match(/\d{3}/gi)

        if (thousand) {
          const separator = modulo ? '.' : ''
          rupiah += separator + thousand.join('.')
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah
        return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '')
      } else {
        return 'Rp. 0'
      }
    },

    changeSort(e) {
      this.listQuery.sort_by = e.prop
      this.listQuery.sort_order = e.order
      this.getList()
    },

    handleSelectionChange(val) {
      this.multipleSelection = val
    },

    toggleSelection() {
      this.$refs.multipleTable.clearSelection()
    },

    multipleValidate() {
      this.validate(this.multipleSelection.map(element => (element.id)))
    }
  }
}
</script>
<style lang="scss" scoped>
  .line-separator {
    margin: 0 -20px;
    border: .1px solid #e6ebf5;
  }

  .dialog-custome {
    background: transparent;
    box-shadow: none;
    padding: 0;
    margin: 0;
  }

  .detail-title {
    color: #606266;
  }
  .dialog-title {
    font-weight: bold;
    text-align: left;
    font-size: 22px;
    float: left;
    padding: 10px;
  }
  .dialog-content {
    padding: 0 10px;
    font-size: 16px;
    .space {
      line-height: 25px;
    }
    .link {
      color: blue !important;
    }
  }
  .footer {
    padding-top: 10px;
  }
  .warn-content-warning {
    background: #2b823d;
    border-radius: 5px;
    padding: 1.5rem;
    word-spacing: .05rem;
    color: white;
    margin-bottom: 25px;

    .title {
      font-weight: 600;
    }

    .link {
      text-decoration: underline;
      cursor: pointer;
      color: white !important;
    }
  }

  .dropdown {
    margin-top: 15px;
    margin-bottom: 100px;
    display: block;
    float: right;
    z-index: 1;
  }
</style>

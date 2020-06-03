<template>
  <div class="app-container">
    <el-row>
      <el-col :lg="24">
        <DashboardTitle :list-type="listType" />

        <!-- show statistics -->
        <StatisticsVerval :is-loading="isLoadingSummary" :is-verval="true" :list-type="listType" :summery="dataSummary" />

        <ListFilter :list-query.sync="listQuery" :is-verval="true" @submit-search="getList" @reset-search="resetFilter" />

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
              <router-link :to="'/beneficiaries/detail-verval/' +scope.row.id">
                <el-tooltip :content="$t('label.beneficiaries-detail')" placement="top">
                  <el-button type="primary" icon="el-icon-view" size="small" />
                </el-tooltip>
              </router-link>
              <el-tooltip v-if="listType === 'pending'" :content="$t('label.beneficiaries-validate')" placement="top">
                <el-button type="success" icon="el-icon-circle-check" size="small" :disabled="multipleSelection.length > 0" @click="validate(scope.row.id)" />
              </el-tooltip>
            </template>
          </el-table-column>
        </el-table>
        <div v-if="listType === 'pending'" style="margin-top: 20px">
          <el-button v-if="multipleSelection.length === 0" type="success" style="float: right; margin-right: 30px" @click="validateAll()">{{ $t('label.beneficiaries-validate-all') }}</el-button>
          <el-button v-if="multipleSelection.length > 0" type="success" style="float: right; margin-right: 50px" @click="multipleValidate()">{{ $t('label.beneficiaries-validate-select') }}</el-button>
        </div>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchSummaryVerval, fetchListVerval, validateStaffKelBulk } from '@/api/beneficiaries'
import DashboardTitle from './components/DashboardTitle'
import Pagination from '@/components/Pagination'
import StatisticsVerval from './components/StatisticsVerval'
import ListFilter from './_listfilter'
import { mapGetters } from 'vuex'

export default {
  components: { Pagination, StatisticsVerval, ListFilter, DashboardTitle },
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
      listLoading: true,
      multipleSelection: [],
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      listQuery: {
        nik: null,
        name: null,
        sort_by: 'nik',
        sort_order: 'ascending',
        page: 1,
        limit: 10,
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
    ...mapGetters(['user'])
  },
  created() {
    this.getList()
    this.getSummary()
  },

  methods: {
    // get summary statistics
    getSummary() {
      const querySummary = {
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
    getList() {
      this.listLoading = true
      if (this.listType === 'pending') {
        this.listQuery.status_verification = 3
      } else if (this.listType === 'approved') {
        this.listQuery.status_verification = 5
      } else if (this.listType === 'rejected') {
        this.listQuery.status_verification = 2 || 4
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
    },

    validateAll() {
      this.validate(this.list.map(element => (element.id)))
    }
  }
}
</script>
<style lang="scss" scoped>
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
</style>
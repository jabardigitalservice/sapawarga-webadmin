<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-dropdown size="large" trigger="click" placement="bottom-end" split-button type="primary" class="dropdown" @command="handleCommand">
          {{ $t('beneficiaries.show-stage') }} <b>{{ tahapDisplay }}</b>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item :command="{label: $t('beneficiaries.stage1'), value: 1}">{{ $t('beneficiaries.stage1') }}</el-dropdown-item>
            <el-dropdown-item :command="{label: $t('beneficiaries.stage2'), value: 2}">{{ $t('beneficiaries.stage2') }}</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
        <DashboardTitle :is-monitoring-bnba="true" />
      </el-col>
    </el-row>
    <el-form>
      <el-row :gutter="10">
        <el-col :span="11">
          <el-select
            v-model="citySelected"
            filterable
            :clearable="true"
            :placeholder="$t('label.beneficiaries-monitoring-city')"
            style="width: 100%"
            @clear="clearedCity"
          >
            <el-option
              v-for="item in kabkotaOptions"
              :key="item.value"
              :label="item.label"
              :value="item"
            />
          </el-select>
        </el-col>
        <el-col :span="11">
          <el-select
            v-model="bansosTypeSelected"
            filterable
            :clearable="true"
            :placeholder="$t('label.beneficiaries-monitoring-bansos-type')"
            style="width: 100%"
            @clear="clearedBansosType"
          >
            <el-option
              v-for="item in beneficiariesTypeList"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-col>
        <el-col :span="2">
          <el-button
            type="primary"
            @click="handleFilter"
          >{{ $t('label.beneficiaries-monitoring-choose') }}</el-button>
        </el-col>
      </el-row>
    </el-form>
    <el-row style="margin-top: 10px">
      <el-col :span="24">
        <el-card class="box-card">
          <div slot="header">
            <el-row>
              <el-col :span="12" style="margin-top: 10px">
                <span>{{ $t('label.beneficiaries-monitoring-table-title') }}</span>
                <span>{{ cityName }}</span>
              </el-col>
              <el-col :span="12">
                <el-button style="float: right;" type="success" plain @click="dialogTableVisible = true">'{{ $t('beneficiaries.download-history') }}'</el-button>
              </el-col>
            </el-row>
          </div>
          <div class="text item">
            <el-table
              v-loading="loading"
              :data="sortedList"
              border
              stripe
              highlight-current-row
              style="width: 100%"
              @sort-change="changeSort"
            >
              <el-table-column
                type="index"
                sortable="custom"
                width="50"
                align="center"
                :index="getTableRowNumbering"
              />
              <el-table-column
                prop="kabkota_name"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-city').toUpperCase()"
              />
              <el-table-column
                prop="is_dtks"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-bansos-type').toUpperCase()"
              >
                <template slot-scope="{row}">{{ row.is_dtks === 1 ? 'DTKS' : 'NON DTKS' }}</template>
              </el-table-column>
              <el-table-column
                prop="last_updated"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-last-update').toUpperCase()"
              >
                <template
                  slot-scope="{row}"
                >{{ row.last_updated ? parsingDatetime(Number(row.last_updated)) : '-' }}</template>
              </el-table-column>
              <el-table-column
                align="center"
                :label="$t('label.beneficiaries-monitoring-action').toUpperCase()"
                width="200"
              >
                <template slot-scope="{row}">
                  <el-tooltip
                    :content="$t('label.beneficiaries-monitoring-download')"
                    placement="top"
                  >
                    <el-button type="success" size="mini" @click="handleDownload(row)">
                      <i class="el-icon-download el-icon-right" />
                      {{ $t('label.beneficiaries-monitoring-download') }}
                    </el-button>
                  </el-tooltip>
                </template>
              </el-table-column>
            </el-table>
            <pagination
              v-show="total>0"
              :total="total"
              :page.sync="listQuery.page"
              :limit.sync="listQuery.limit"
              @pagination="getList"
            />
          </div>
        </el-card>
        <el-dialog width="70%" :visible.sync="dialogTableVisible">
          <span slot="title" class="dialog-title">{{ $t('beneficiaries.download-history-location') }}</span>
          <DialogDownloadHistory :source="'bnba'" />
        </el-dialog>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { getKabkotaList } from '@/api/areas'
import { parsingDatetime } from '@/utils/datetimeToString'
import {
  fetchBeneficiariesBnbaList,
  downloadBeneficiariesBnba
} from '@/api/beneficiaries'
import DashboardTitle from './components/DashboardTitle'
import DialogDownloadHistory from './components/DialogDownloadHistory'
import Pagination from '@/components/Pagination'
import Swal from 'sweetalert2'

export default {
  components: {
    DialogDownloadHistory,
    DashboardTitle,
    Pagination
  },
  data() {
    return {
      loading: false,
      tahapDisplay: null,
      kabkotaOptions: null,
      citySelected: null,
      bansosTypeSelected: null,
      dialogTableVisible: false,
      dataDownloadHistory: null,
      total: 0,
      list: null,
      listQuery: {
        page: 1,
        limit: 10,
        code_bps: null,
        is_dtks: null,
        tahap_bantuan: null
      },
      sort_prop: 'data.approved',
      sort_order: 'descending',
      beneficiariesTypeList: [
        { value: 1, label: 'DTKS' },
        { value: 0, label: 'NON DTKS' }
      ],
      cityName: null
    }
  },
  computed: {
    sortedList() {
      const prop = this.sort_prop
      const order = this.sort_order
      function compare(a, b) {
        if (a[prop] < b[prop]) {
          return order === 'ascending' ? -1 : 1
        }
        if (a[prop] > b[prop]) {
          return order === 'ascending' ? 1 : -1
        }
        return 0
      }
      if (this.list) {
        return this.list.map(x => x).sort(compare)
      } else {
        return []
      }
    }
  },
  created() {
    this.tahapDisplay = this.$t('beneficiaries.stage2')
    this.listQuery.tahap = 2
    this.getList()
    this.getKabkotaOptions()
  },
  methods: {
    handleCommand(command) {
      this.listQuery.tahap = command.value
      this.tahapDisplay = command.label
      this.getList()
    },
    async getList() {
      this.listQuery.tahap_bantuan = this.listQuery.tahap
      this.loading = true
      const response = await fetchBeneficiariesBnbaList(this.listQuery)
      this.list = response.data.items
      this.total = response.data._meta.totalCount
      this.loading = false
    },
    async getKabkotaOptions() {
      this.kabkotaOptions = []
      const { data } = await getKabkotaList(true)
      this.kabkotaOptions = data.items.map(item => {
        return {
          value: item.code_bps,
          label: item.name
        }
      })
    },
    getTableRowNumbering(index) {
      return (this.listQuery.page - 1) * this.listQuery.limit + (index + 1)
    },
    changeSort(e) {
      this.sort_prop = e.prop
      this.sort_order = e.order
    },
    handleFilter() {
      if (this.citySelected) {
        this.cityName = this.citySelected.label
        this.listQuery.code_bps = this.citySelected.value
      }
      this.listQuery.is_dtks = this.bansosTypeSelected
      this.getList()
    },
    clearedBansosType() {
      this.listQuery.is_dtks = null
    },
    clearedCity() {
      this.listQuery.code_bps = null
    },
    async handleDownload(data) {
      try {
        const params = {
          kode_kab: data.code_bps,
          bansos_type: data.is_dtks === 1 ? 'dtks' : 'non-dtks',
          tahap_bantuan: this.listQuery.tahap
        }
        this.loading = true
        const response = await downloadBeneficiariesBnba(params)
        if (response.status === 200) {
          Swal.fire({
            title: this.$t('label.beneficiaries-download-start-title-alert'),
            text: this.$t(
              'label.beneficiaries-download-start-description-alert'
            ),
            icon: 'success',
            button: 'OK'
          })
        }
        this.loading = false
      } catch (error) {
        this.loading = false
      }
    },
    parsingDatetime
  }
}
</script>
<style lang="scss" scoped>
  .dropdown {
    margin-top: 15px;
    margin-bottom: 100px;
    display: block;
    float: right;
  }
  .dialog-title {
    font-weight: bold;
    text-align: left;
    font-size: 22px;
    float: left;
    padding: 20px;
    margin-bottom: 15px;
  }
</style>

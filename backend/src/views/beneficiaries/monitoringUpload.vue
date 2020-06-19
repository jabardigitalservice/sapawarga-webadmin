<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <ListFilterTahap :list-query.sync="listQuery" @handle-change-tahap="getList" />
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
        <el-card class="box-card green">
          <div slot="header">
            <span>{{ $t('label.beneficiaries-monitoring-table-title') }}</span>
            <span>{{ cityName }}</span>
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
                prop="name"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-city').toUpperCase()"
              />
              <el-table-column
                prop="type"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-bansos-type').toUpperCase()"
              >
                <template slot-scope="{row}">{{ row.type.toUpperCase() }}</template>
              </el-table-column>
              <el-table-column
                prop="last_update"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-last-update').toUpperCase()"
              >
                <template
                  slot-scope="{row}"
                >{{ Number(row.last_update) | moment('D MMMM YYYY H:mm') }}</template>
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
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { getKabkotaList } from '@/api/areas'
import {
  fetchBeneficiariesBnbaList,
  downloadBeneficiariesBnba
} from '@/api/beneficiaries'
import DashboardTitle from './components/DashboardTitle'
import Pagination from '@/components/Pagination'
import Swal from 'sweetalert2'
import ListFilterTahap from './_listFilterTahap'

export default {
  components: {
    DashboardTitle,
    Pagination,
    ListFilterTahap
  },
  data() {
    return {
      loading: false,
      kabkotaOptions: null,
      citySelected: null,
      bansosTypeSelected: null,
      total: 0,
      list: null,
      listQuery: {
        page: 1,
        limit: 10,
        kode_kab: null,
        bansos_type: null,
        tahap_bantuan: null
      },
      sort_prop: 'data.approved',
      sort_order: 'descending',
      beneficiariesTypeList: [
        { value: 'dtks', label: 'DTKS' },
        { value: 'non-dtks', label: 'NON DTKS' }
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
    this.getList()
    this.getKabkotaOptions()
  },
  methods: {
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
        this.listQuery.kode_kab = this.citySelected.value
      }
      this.listQuery.bansos_type = this.bansosTypeSelected
      this.getList()
    },
    clearedBansosType() {
      this.listQuery.bansos_type = null
    },
    clearedCity() {
      this.listQuery.kode_kab = null
    },
    async handleDownload(data) {
      try {
        const params = {
          kode_kab: data.code_bps,
          bansos_type: data.type,
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
    }
  }
}
</script>


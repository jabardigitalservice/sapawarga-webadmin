<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <DashboardTitle :is-monitoring-bnba="true" />
      </el-col>
    </el-row>
    <el-form>
      <el-row :gutter="10">
        <el-col :span="11">
          <el-select
            v-model="citySelected"
            filterable
            clearable
            :placeholder="$t('label.beneficiaries-monitoring-city')"
            style="width: 100%"
            :return-object="true"
          >
            <el-option
              v-for="item in kabkotaOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-col>
        <el-col :span="11">
          <el-select
            v-model="bansosTypeSelected"
            filterable
            clearable
            :placeholder="$t('label.beneficiaries-monitoring-bansos-type')"
            style="width: 100%"
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
            <span>{{ `${$t('label.beneficiaries-monitoring-table-title')}` }}</span>
          </div>
          <div class="text item">
            <el-table
              v-loading="loading"
              :data="list"
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
                prop="address"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-city').toUpperCase()"
                width="400"
              />
              <el-table-column
                prop="bansos_type"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-bansos-type').toUpperCase()"
                width="180"
              />
              <el-table-column
                prop="date"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-last-update').toUpperCase()"
                align="center"
                width="180"
              />
              <el-table-column
                align="center"
                :label="$t('label.beneficiaries-monitoring-action').toUpperCase()"
                width="200"
              >
                <template>
                  <a href="#">
                    <el-tooltip
                      :content="$t('label.beneficiaries-monitoring-download')"
                      placement="top"
                    >
                      <el-button type="success" size="mini">
                        <i class="el-icon-download el-icon-right" />
                        {{ $t('label.beneficiaries-monitoring-download') }}
                      </el-button>
                    </el-tooltip>
                  </a>
                </template>
              </el-table-column>
            </el-table>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { getKabkotaList } from '@/api/areas'
// todo: uncomment code di bawah ini jika api sudah ready
// import { fetchBeneficieriesBnbaList } from '@/api/beneficiaries'
import DashboardTitle from './components/DashboardTitle'
import BeneficiariesType from '../bansos/statics/beneficiariesType'

export default {
  components: {
    DashboardTitle
  },
  data() {
    return {
      loading: false,
      kabkotaOptions: null,
      citySelected: null,
      bansosTypeSelected: null,
      // todo: hapus data dummy ini jika api sudah ready
      list: [
        {
          date: '2016-05-03',
          bansos_type: 'DTKS',
          address: 'Sumedang'
        },
        {
          date: '2016-05-02',
          bansos_type: 'NON DTKS',
          address: 'Sumedang'
        },
        {
          date: '2016-05-04',
          bansos_type: 'DTKS',
          address: 'Sumedang'
        },
        {
          date: '2016-05-01',
          bansos_type: 'NON DTKS',
          address: 'Sumedang'
        }
      ],
      listQuery: {
        page: 1,
        limit: 10
      },
      sort_prop: 'data.approved',
      sort_order: 'descending',
      beneficiariesTypeList: null
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
    this.getBeneficiariesTypeList()
  },
  methods: {
    async getBeneficiariesTypeList() {
      const beneficiariesType = new BeneficiariesType()
      const data = await beneficiariesType.getAll()
      this.beneficiariesTypeList = data.map(item => {
        return {
          value: item.id,
          label: `${item.type.toUpperCase().replace('_', ' ')} - ${item.name}`
        }
      })
    },
    async getKabkotaOptions() {
      this.kabkotaOptions = []
      const { data } = await getKabkotaList(true)
      this.kabkotaOptions = data.items.map(item => {
        return {
          value: item.id,
          label: item.name
        }
      })
    },
    async getList() {
      this.loading = true
      // todo: uncomment code dibawah ini jika api sudah ready
      // const response = await fetchBeneficieriesBnbaList(this.listQuery);
      this.loading = false
    },
    getTableRowNumbering(index) {
      return (this.listQuery.page - 1) * this.listQuery.limit + (index + 1)
    },
    changeSort(e) {
      this.sort_prop = e.prop
      this.sort_order = e.order
    },
    handleFilter() {
      // todo: request data ke api
    }
  }
}
</script>

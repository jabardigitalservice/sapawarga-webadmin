<template>
  <div class="app-container">
    <el-row style="margin-top: 50px">
      <el-col :span="24">
        <el-card class="box-card green">
          <div slot="header">
            <span>{{ $t('label.beneficiaries-monitoring-table-title') }}</span>
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
import { fetchBeneficieriesBnbaList } from '@/api/beneficiaries'

export default {
  data() {
    return {
      loading: false,
      list: [
        {
          date: '2016-05-03',
          bansos_type: 'DTKS',
          address: 'No. 189, Grove St, Los Angeles'
        },
        {
          date: '2016-05-02',
          bansos_type: 'NON DTKS',
          address: 'No. 189, Grove St, Los Angeles'
        },
        {
          date: '2016-05-04',
          bansos_type: 'DTKS',
          address: 'No. 189, Grove St, Los Angeles'
        },
        {
          date: '2016-05-01',
          bansos_type: 'NON DTKS',
          address: 'No. 189, Grove St, Los Angeles'
        }
      ],
      listQuery: {
        page: 1,
        limit: 10
      },
      sort_prop: 'data.approved',
      sort_order: 'descending'
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
  },
  methods: {
    async getList() {
      this.loading = true
      const response = await fetchBeneficieriesBnbaList(this.listQuery)
      this.loading = false
      console.log(response)
    },
    getTableRowNumbering(index) {
      return (this.listQuery.page - 1) * this.listQuery.limit + (index + 1)
    },
    changeSort(e) {
      this.sort_prop = e.prop
      this.sort_order = e.order
    }
  }
}
</script>

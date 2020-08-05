<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <h2 class="dashboard-title">{{ $t('label.beneficiaries-monitoring-bnba-title') }}</h2>
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
              <el-col :span="24" style="margin-top: 10px">
                <span>{{ $t('label.beneficiaries-monitoring-table-title') }}</span>
                <span>{{ cityName }}</span>
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
                prop="timestamp"
                sortable="custom"
                :label="$t('label.beneficiaries-monitoring-last-update').toUpperCase()"
              >
                <template
                  slot-scope="{row}"
                >{{ Number(row.timestamp) | moment('D MMMM YYYY H:mm') }}</template>
              </el-table-column>
              <el-table-column
                align="center"
                property="final_url"
                :label="$t('label.beneficiaries-monitoring-action').toUpperCase()"
                width="200"
              >
                <!-- <template slot-scope="{row}">
                  <el-tooltip
                    :content="$t('label.beneficiaries-monitoring-download')"
                    placement="top"
                  >
                    <el-button type="success" size="mini" @click="handleDownload(row)">
                      <i class="el-icon-download el-icon-right" />
                      {{ $t('label.beneficiaries-monitoring-download') }}
                    </el-button>
                  </el-tooltip>
                </template> -->
                <template slot-scope="{row}">
                  <el-tooltip
                    :content="$t('label.beneficiaries-monitoring-download')"
                    placement="top"
                  >
                    <a :href="row.final_url" target="_blank" rel="noopener noreferrer">{{ row.final_url || '-' }}</a>
                  </el-tooltip></template>
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
import { fetchUploadBnbaList } from '@/api/beneficiaries'
import Pagination from '@/components/Pagination'

export default {
  components: {
    Pagination
  },
  data() {
    return {
      loading: false,
      kabkotaOptions: null,
      citySelected: null,
      total: 0,
      list: null,
      listQuery: {
        page: 1,
        limit: 10,
        kabkota_name: null
      },
      sort_prop: 'data.approved',
      sort_order: 'descending',
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
      this.loading = true
      const response = await fetchUploadBnbaList(this.listQuery)
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
        this.listQuery.kabkota_name = this.citySelected.label
      }
      this.getList()
    },
    clearedBansosType() {
      this.listQuery.bansos_type = null
    },
    clearedCity() {
      this.listQuery.kabkota_name = null
    }
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

<template>
  <div class="app-container">
    <el-row>
      <el-col :lg="24">
        <!-- <el-row style="margin: 10px 0px">
          <el-col :span="12">
            <router-link :to="{ path: '/beneficiaries/create' }">
              <el-button type="primary" size="small" icon="el-icon-plus">
                {{ $t('route.beneficiaries-create') }}
              </el-button>
            </router-link>
          </el-col>
        </el-row> -->

        <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

        <el-table v-loading="listLoading" :data="list" border stripe highlight-current-row style="width: 100%" @sort-change="changeSort">
          <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />

          <el-table-column prop="name" sortable="custom" :label="$t('label.beneficiaries-name')" min-width="200px" />

          <el-table-column prop="nik" sortable="custom" :label="$t('label.beneficiaries-nik')" min-width="175px" />

          <el-table-column prop="rw" sortable="custom" align="center" :label="$t('label.beneficiaries-rw')" min-width="70px" />

          <el-table-column prop="rt" sortable="custom" align="center" :label="$t('label.beneficiaries-rt')" min-width="70px" />

          <el-table-column prop="income_before" sortable="custom" :label="$t('label.beneficiaries-income-before')" min-width="180px">
            <template slot-scope="{row}">
              {{ formatCurrency(row.income_before, 'Rp.') }}
            </template>
          </el-table-column>

          <el-table-column prop="income_after" sortable="custom" :label="$t('label.beneficiaries-income-after')" min-width="180px">
            <template slot-scope="{row}">
              {{ formatCurrency(row.income_after, 'Rp.') }}
            </template>
          </el-table-column>

          <el-table-column prop="status_verification" class-name="status-col" sortable="custom" :label="$t('label.beneficiaries-status')" min-width="150px">
            <template slot-scope="{row}">
              <el-tag :type="row.status_verification | statusFilter">
                {{ row.status_verification_label }}
              </el-tag>
            </template>
          </el-table-column>

          <el-table-column align="center" :label="$t('label.actions')" width="200px">
            <template slot-scope="scope">
              <router-link :to="'/beneficiaries/detail/'+scope.row.id">
                <el-tooltip :content="$t('label.beneficiaries-verivication')" placement="top">
                  <el-button type="success" icon="el-icon-circle-check" size="small" :disabled="scope.row.status_verification !== 1">{{ $t('label.beneficiaries-verivication') }}</el-button>
                </el-tooltip>
              </router-link>
              <!-- <router-link :to="scope.row.status === 0 ? '/beneficiaries/edit/' +scope.row.id : ''">
                <el-tooltip :content="$t('label.beneficiaries-edit')" placement="top">
                  <el-button type="warning" icon="el-icon-edit" size="small" />
                </el-tooltip>
              </router-link> -->
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchList } from '@/api/beneficiaries'
import Pagination from '@/components/Pagination'
import ListFilter from './_listfilter'

export default {
  components: { Pagination, ListFilter },
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
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      },
      listQuery: {
        nik: null,
        name: null,
        sort_by: 'name',
        sort_order: 'ascending',
        page: 1,
        limit: 10,
        status_verification: null,
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        rw_like: null,
        rt_like: null
      }
    }
  },

  created() {
    this.getList()
  },

  methods: {
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.listLoading = false
      })
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
    }
  }
}
</script>

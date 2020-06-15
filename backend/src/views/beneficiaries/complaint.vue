<template>
  <div class="app-container">
    <h1>{{ $t('label.beneficiaries-complaint-title') }}</h1>
    <p>{{ `Berikut ini adalah daftar calon penerima yang diadukan di Kel/Desa ${user.kelurahan.name}, Kec. ${user.kecamatan.name}, Kab/Kota ${user.kabkota.name}` }}</p>

    <el-row :gutter="24">
      <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
        <div class="grid-content">
          <div class="stat-title">{{ $t('label.beneficiaries-complaint-total') }}</div>
          <!-- show loading -->
          <div
            v-loading="isLoadingList"
            class="icon-loading"
            element-loading-spinner="el-icon-loading"
          />
          <!-- show data -->
          <div v-if="!isLoadingList" class="total color-sw-green">{{ total }}</div>
        </div>
      </el-col>
    </el-row>

    <ListFilter :list-query.sync="listQuery" @submit-search="getList" @reset-search="resetFilter" />

    <el-table
      v-loading="isLoadingList"
      :data="list"
      border
      stripe
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column
        type="index"
        align="center"
        :index="getTableRowNumbering"
        width="50"
      />
      <el-table-column
        prop="beneficiary.name"
        label="Nama Lengkap"
      />
      <el-table-column
        prop="beneficiary.nik"
        label="NIK"
      />
      <el-table-column
        prop="beneficiary.rt"
        label="RT"
        width="50"
      />
      <el-table-column
        prop="domicile_rt.rw"
        label="RW"
        width="50"
      />
      <el-table-column
        prop="domicile_rt.address"
        label="Alamat"
      />
      <el-table-column
        prop="notes_reason"
        label="Alasan Dilaporkan"
      />
      <el-table-column
        label="AKSI"
        width="80"
        align="center"
      >
        <template slot-scope="scope">
          <router-link :to="'/beneficiaries/complaint/detail/' +scope.row.id">
            <el-tooltip :content="$t('label.beneficiaries-complaint-detail')" placement="top">
              <el-button
                size="mini"
                type="primary"
                icon="el-icon-view"
              />
            </el-tooltip>
          </router-link>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ListFilter from './_listFilterComplaint'
import Pagination from '@/components/Pagination'
import { fetchListComplaint } from '@/api/beneficiaries'
export default {
  components: { ListFilter, Pagination },
  data() {
    return {
      isLoadingList: true,
      list: null,
      total: 0,
      tableData: [{
        id: 1,
        name: 'aaa',
        nik: 'nik',
        rt: 'rt',
        rw: 'rw',
        address: 'address',
        reason: 'reason'
      }],
      listQuery: {
        nik: null,
        name: null,
        domicile_rt: null,
        domicile_rw: null,
        sort_by: 'nik',
        page: 1,
        limit: 10
      }
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.isLoadingList = true
      fetchListComplaint(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data._meta.totalCount
        this.isLoadingList = false
      })
    },
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },
    resetFilter() {
      Object.assign(this.$data.listQuery, this.$options.data().listQuery)
      this.getList()
    }
  }
}
</script>

<style lang="scss" scoped>
.grid-content {
  position: relative;
  padding: 1.5rem;
  margin-bottom: 2rem;
  background: #FFFFFF;
  border: 1px solid #E1E5EE;
  box-sizing: border-box;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.04);
  border-radius: 8px;
}

.stat-title {
  margin-bottom: 13px;
  font-weight: bold;
  font-size: 15px;
}

.color-sw-green {
  color: #27AE60;
  font-weight: bold;
}

.total {
  font-size: 32px;
}
</style>

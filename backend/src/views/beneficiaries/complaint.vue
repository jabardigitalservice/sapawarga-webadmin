<template>
  <div class="app-container">
    <h1>{{ $t('label.beneficiaries-complaint-title') }}</h1>
    <p>{{ `Berikut ini adalah daftar calon penerima yang diadukan di Kel/Desa ${user.kelurahan.name}, Kec. ${user.kecamatan.name}, Kab/Kota ${user.kabkota.name}` }}</p>

    <el-row :gutter="24">
      <el-col :xs="24" :sm="8" :md="6" :lg="4" :xl="4">
        <div class="grid-content">
          <div class="stat-title">{{ $t('label.beneficiaries-complaint-total') }}</div>
          <!-- show loading -->
          <!-- <div
            v-loading="isLoading"
            class="icon-loading"
            element-loading-spinner="el-icon-loading"
          /> -->
          <!-- show data -->
          <div class="total color-sw-green">213</div>
        </div>
      </el-col>
    </el-row>

    <ListFilter :list-query.sync="listQuery" />

    <el-table
      :data="tableData"
      border
      highlight-current-row
      style="width: 100%"
      :header-row-style="{'color': '#000' }"
    >
      <el-table-column
        type="index"
        align="center"
        :index="getTableRowNumbering"
        width="50"
      />
      <el-table-column
        prop="name"
        label="Nama Lengkap"
      />
      <el-table-column
        prop="nik"
        label="NIK"
      />
      <el-table-column
        prop="rt"
        label="RT"
        width="50"
      />
      <el-table-column
        prop="rw"
        label="RW"
        width="50"
      />
      <el-table-column
        prop="address"
        label="Alamat"
      />
      <el-table-column
        prop="reason"
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

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ListFilter from './_listFilterComplaint'
import Pagination from '@/components/Pagination'
export default {
  components: { ListFilter, Pagination },
  data() {
    return {
      tableData: [{
        id: 1,
        name: 'aaa',
        nik: 'nik',
        rt: 'rt',
        rw: 'rw',
        address: 'address',
        reason: 'reason'
      }],
      total: 1,
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
  methods: {
    getTableRowNumbering(index) {
      return (index + 1)
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

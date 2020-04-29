<template>
  <div class="app-container">
    <el-card class="box-card" :body-style="{ background: '#fce0b4' }">
      <div slot="header">
        <span>{{ $t('label.beneficiaries-upload') }}</span>
      </div>
      <div class="text item">
        <p><strong><i class="el-icon-info" /> {{ $t('label.beneficiaries-upload-option') }}</strong></p>
        <p>{{ $t('label.beneficiaries-upload-info') }}</p>
      </div>
    </el-card>
    <el-card class="box-card">
      <router-link to="/bansos/upload-form?type=1">
        <img src="@/assets/bansos-provinsi.svg" class="img-bansos">
      </router-link>
      <router-link to="/bansos/upload-form?type=2">
        <img src="@/assets/bansos-kabupaten.svg" class="img-bansos">
      </router-link>
      <router-link to="/bansos/upload-form?type=3">
        <img src="@/assets/bansos-desa.svg" class="img-bansos">
      </router-link>
      <router-link to="/bansos/upload-form?type=4">
        <img src="@/assets/bansos-presiden.svg" class="img-bansos">
      </router-link>
      <router-link to="/bansos/upload-form?type=5">
        <img src="@/assets/bansos-kemensos.svg" class="img-bansos">
      </router-link>
    </el-card>
    <br>
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>{{ $t('label.beneficiaries-upload-history') }}</span>
      </div>
      <el-table v-loading="listLoading" :data="list" stripe fit highlight-current-row style="width: 100%">
        <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
        <el-table-column prop="pintu_bantuan" sortable="custom" :label="$t('label.beneficiaries')" />
        <el-table-column prop="status_upload" sortable="custom" :label="$t('label.beneficiaries-upload-status')" />
        <el-table-column prop="tanggal_upload" sortable="custom" :label="$t('label.beneficiaries-upload-date')" />
        <el-table-column align="center" :label="$t('label.actions')" width="200">
          <template slot-scope="scope">
            <router-link :to="'#'">
              <el-tooltip :content="$t('label.beneficiaries-upload-view')" placement="top">
                <el-button type="primary" icon="el-icon-view" size="mini" />
              </el-tooltip>
            </router-link>
          </template>
        </el-table-column>
      </el-table>
      <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
    </el-card>
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'
export default {
  components: { Pagination },
  data() {
    return {
      list: null,
      listLoading: true,
      total: 0,
      listQuery: {
        page: 1,
        limit: 10,
      }
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      this.list = [
        { pintu_bantuan: 'Bantuan Sosial Provinsi', status_upload: 'KAB BANDUNG', tanggal_upload: '29 April 2020' },
        { pintu_bantuan: 'Bantuan Sosial Kota / Kabupaten', status_upload: 'KAB BANDUNG BARAT', tanggal_upload: '29 April 2020' }
      ]
      this.listLoading = false
    },
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.img-bansos {
  width: 100%;
  margin-top:10px;
}
</style>

<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-card class="box-card green body-nopadding">
          <div slot="header">
            <span>{{ $t('label.beneficiaries-upload') }}</span>
          </div>
          <div class="text item card-description">
            <p><strong><i class="el-icon-info" /> {{ $t('label.beneficiaries-upload-option') }}</strong></p>
            <p>{{ $t('label.beneficiaries-upload-info') }}</p>
          </div>
        </el-card>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="24">
        <router-link to="/bansos/upload-form?type=1">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">Bantuan Sosial Provinsi</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=2">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">Bantuan Sosial Kota / Kabupaten</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=3">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">Bantuan Dana Desa</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=4">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">Bantuan Sosial Presiden Sembako (Bodebek)</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=5">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">Bantuan Sosial Tunai Kemensos</p>
          </el-card>
        </router-link>
      </el-col>
    </el-row>
    <el-row style="margin-top: 50px">
      <el-col :span="24">
        <el-card class="box-card green">
          <div slot="header">
            <span>{{ $t('label.beneficiaries-upload-history') }}</span>
          </div>
          <div class="text item">
            <el-table v-loading="listLoading" :data="list" stripe fit highlight-current-row style="width: 100%">
              <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
              <el-table-column prop="pintu_bantuan" sortable="custom" :label="$t('label.beneficiaries')" />
              <el-table-column prop="status_upload" sortable="custom" :label="$t('label.beneficiaries-upload-status')" />
              <el-table-column prop="tanggal_upload" sortable="custom" :label="$t('label.beneficiaries-upload-date')" />
              <el-table-column align="center" :label="$t('label.actions')" width="200">
                <template>
                  <router-link :to="'#'">
                    <el-tooltip :content="$t('label.beneficiaries-upload-view')" placement="top">
                      <el-button type="primary" icon="el-icon-view" size="mini" />
                    </el-tooltip>
                  </router-link>
                </template>
              </el-table-column>
            </el-table>
            <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
          </div>
        </el-card>
      </el-col>
    </el-row>
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
        limit: 10
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
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.img-bansos {
  width: 100%;
  margin-top:10px;
}
</style>

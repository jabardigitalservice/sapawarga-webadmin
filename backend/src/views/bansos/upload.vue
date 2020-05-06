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
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">{{ $t('label.beneficiaries-province') }}</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=2">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">{{ $t('label.beneficiaries-city') }}</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=3">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">{{ $t('label.beneficiaries-village-fund') }}</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=4">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">{{ $t('label.beneficiaries-president') }}</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=5">
          <el-card class="box-card">
            <p style="margin:0; font-weight: bold"><img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">{{ $t('label.beneficiaries-kemensos') }}</p>
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
            <el-table v-loading="loading" :data="list" border stripe fit highlight-current-row style="width: 100%">
              <el-table-column type="index" width="50" align="center" :index="getTableRowNumbering" />
              <el-table-column prop="bansos_type" sortable="custom" :label="$t('label.beneficiaries')">
                <template slot-scope="{row}">
                  {{ row.bansos_type }}
                </template>
              </el-table-column>
              <el-table-column prop="target_upload" sortable="custom" :label="$t('label.beneficiaries-upload-target')" />
              <el-table-column prop="created_at" sortable="custom" :label="$t('label.beneficiaries-upload-date')">
                <template slot-scope="{row}">
                  {{ row.created_at | moment('D MMMM YYYY') }}
                </template>
              </el-table-column>
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
import { uploadBansosList } from '@/api/bansos'
import Pagination from '@/components/Pagination'

export default {
  components: { Pagination },
  data() {
    return {
      list: null,
      loading: true,
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
    async getList() {
      this.loading = true
      const response = await uploadBansosList(this.listQuery)
      const data = []
      response.data.map(value => {
        data.push({
          'bansos_type': this.getTitle(value.bansos_type),
          'target_upload': value.kabkota_name,
          'created_at': value.created_at,
          'id': value.id
        })
      })
      this.list = data
      this.loading = false
    },
    getTableRowNumbering(index) {
      return ((this.listQuery.page - 1) * this.listQuery.limit) + (index + 1)
    },
    getTitle(typeId) {
      const type = typeId.toString()
      switch (type) {
        case '1':
          return this.$t('label.beneficiaries-province')
        case '2':
          return this.$t('label.beneficiaries-city')
        case '3':
          return this.$t('label.beneficiaries-village-fund')
        case '4':
          return this.$t('label.beneficiaries-president')
        case '5':
          return this.$t('label.beneficiaries-kemensos')
        default:
          return this.$t('label.beneficiaries-not-available')
      }
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

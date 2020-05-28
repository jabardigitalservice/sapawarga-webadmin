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
    <el-row :gutter="30">
      <el-col :span="12">
        <el-card class="box-card body-nopadding">
          <div slot="header">
            <strong><span>{{ $t('label.beneficiaries-dtks-option') }}</span></strong>
          </div>
        </el-card>
        <template v-for="(beneficiariesType, index) in beneficiariesTypeList">
          <router-link v-if="beneficiariesType.type == 'dtks'" :key="index" :to="`/bansos/upload-form?type=${ beneficiariesType.id }`">
            <el-card class="box-card">
              <p style="margin:0; font-weight: bold">
                <img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">{{ `${ beneficiariesType.type.toUpperCase().replace('_', ' ') } - ${ beneficiariesType.name }` }}
              </p>
            </el-card>
          </router-link>
        </template>
      </el-col>
      <el-col :span="12">
        <el-card class="box-card body-nopadding">
          <div slot="header">
            <strong><span>{{ $t('label.beneficiaries-nondtks-option') }}</span></strong>
          </div>
        </el-card>
        <template v-for="(beneficiariesType, index) in beneficiariesTypeList">
          <router-link v-if="beneficiariesType.type == 'non_dtks'" :key="index" :to="`/bansos/upload-form?type=${ beneficiariesType.id }`">
            <el-card class="box-card">
              <p style="margin:0; font-weight: bold">
                <img src="@/assets/bansos-type.png" style="vertical-align: middle; margin-right: 15px">{{ `${beneficiariesType.type.toUpperCase().replace('_', ' ') } - ${ beneficiariesType.name }` }}
              </p>
            </el-card>
          </router-link>
        </template>
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
              <el-table-column prop="notes" sortable="custom" align="center" :label="$t('label.beneficiaries-upload-status')" />
              <el-table-column prop="created_at" sortable="custom" align="center" :label="$t('label.beneficiaries-upload-date')">
                <template slot-scope="{row}">
                  {{ row.created_at | moment('D MMMM YYYY H:mm:ss') }}
                </template>
              </el-table-column>
              <el-table-column align="center" :label="$t('label.actions')" width="200">
                <template slot-scope="{row}">
                  <a v-if="row.status == 20" :href="row.invalid_file_url">
                    <el-tooltip :content="$t('label.beneficiaries-download-invalid-file')" placement="top">
                      <el-button type="warning" size="mini"><i class="el-icon-download el-icon-right" />{{ $t('label.beneficiaries-download-invalid-file') }}</el-button>
                    </el-tooltip>
                  </a>
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
import BeneficiariesType from './statics/beneficiariesType'

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
      },
      beneficiariesTypeList: null
    }
  },
  created() {
    this.getList()
    this.getBeneficiariesTypeList()
  },
  methods: {
    async getBeneficiariesTypeList() {
      const beneficiariesType = new BeneficiariesType()
      this.beneficiariesTypeList = await beneficiariesType.getAll()
    },
    async getList() {
      this.loading = true
      const response = await uploadBansosList(this.listQuery)
      const data = []
      response.data.map(value => {
        data.push({
          'bansos_type': this.getTitle(value.bansos_type),
          'target_upload': value.kabkota_name,
          'created_at': value.created_at,
          'file_url': value.file_url,
          'invalid_file_url': value.invalid_file_url,
          'status': value.status,
          'notes': value.notes,
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
      const beneficiariesType = new BeneficiariesType()
      const response = beneficiariesType.getAll(typeId)
      return `${response.type.toUpperCase().replace('_', ' ')} - ${response.name}`
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

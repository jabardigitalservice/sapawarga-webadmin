<template>
  <div>
    <el-card class="box-card" style="margin-bottom: 10px">
      <el-form>
        <el-row :gutter="10">
          <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="3">
            <el-form-item style="margin-bottom: 0">
              <el-input v-model="listQuery.name" placeholder="Nama Lengkap" />
            </el-form-item>
          </el-col>
          <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="3">
            <el-form-item style="margin-bottom: 0">
              <el-input v-model="listQuery.nik" placeholder="NIK" />
            </el-form-item>
          </el-col>
          <el-col v-if="!isVerval" :xs="{span:24, tag:'mb-10'}" :sm="24" :md="3">
            <el-form-item style="margin-bottom: 0">
              <el-select
                v-model="listQuery.status_verification"
                clearable
                filterable
                placeholder="Pilih Status"
                style="width: 100%"
              >
                <el-option value="2" :label="$t('label.beneficiaries-reject')" />
                <el-option value="3" :label="$t('label.beneficiaries-verified')" />
                <el-option value="1" :label="$t('label.beneficiaries-unverified')" />
              </el-select>
            </el-form-item>
          </el-col>
          <el-col v-if="!roles" :xs="{span:24, tag:'mb-10'}" :sm="24" :md="3">
            <input-filter-area-bps
              :parent-id="filterAreaParentId"
              :kabkota-id="listQuery.domicile_kabkota_bps_id"
              :kec-id="listQuery.domicile_kec_bps_id"
              :kel-id="listQuery.domicile_kel_bps_id"
              @changeKabkota="changeKabkota"
              @changeKecamatan="changeKecamatan"
              @changeKelurahan="changeKelurahan"
            />
          </el-col>
          <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="2">
            <el-form-item style="margin-bottom: 0">
              <el-input v-model="listQuery.domicile_rw_like" placeholder="RW" :disabled="listQuery.kel_id === null && !roles" />
            </el-form-item>
          </el-col>
          <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="2">
            <el-form-item style="margin-bottom: 0">
              <el-input v-model="listQuery.domicile_rt_like" placeholder="RT" :disabled="listQuery.kel_id === null && !roles" />
            </el-form-item>
          </el-col>
          <el-col :xs="24" :sm="24" :md="3">
            <el-button type="primary" size="small" @click="submitSearch">
              {{ $t('crud.search') }}
            </el-button>
            <el-button type="primary" size="small" @click="resetFilter">
              {{ $t('crud.reset') }}
            </el-button>
          </el-col>

          <template v-if="roles && isDownloadVerval">
            <el-col :xs="24" :sm="24" :md="3" :xl="2" style="float: right">
              <el-button
                size="medium"
                class="border-orange text-orange btn-export"
                @click="downloadVerval"
              >{{ $t('label.beneficiaries-download-verval') }}</el-button>
            </el-col>
          </template>

          <template v-if="roles">
            <el-col :xs="24" :sm="24" :md="3" :xl="2" style="float: right">
              <el-button class="border-green button-history float-right" type="success" plain @click="showHistoryDownload">{{ $t('label.beneficiaries-history-download') }}</el-button>
            </el-col>
          </template>

        </el-row>
      </el-form>
    </el-card>
    <!-- show dialog history download -->
    <el-dialog width="70%" :visible.sync="dialogTableVisible">
      <span slot="title" class="dialog-title">{{ $t('label.beneficiaries-history-download-verval') }}</span>
      <DialogDownloadHistory ref="dialogDownloadHistoryVerval" :source="'verval'" />
    </el-dialog>
  </div>
</template>

<script>
import { exportBansos } from '@/api/bansos'
import InputFilterAreaBps from '@/components/InputFilterAreaBps'
import Swal from 'sweetalert2'
import DialogDownloadHistory from '../beneficiaries/components/DialogDownloadHistory'

import checkPermission from '@/utils/permission'

export default {
  components: { InputFilterAreaBps, DialogDownloadHistory },

  props: {
    listQuery: {
      type: Object,
      default: null
    },
    isVerval: {
      type: Boolean,
      default: false
    },
    isDownloadVerval: {
      type: Boolean,
      default: true
    }
  },

  data() {
    return {
      dialogTableVisible: false,
      roles: checkPermission(['staffKel']),
      queryDownload: {
        tahap_bantuan: null
      }
    }
  },

  computed: {
    filterAreaParentId() {
      const authUser = this.$store.state.user

      if (checkPermission(['staffKabkota'])) {
        return parseInt(authUser.kabkota.code_bps)
      }

      if (checkPermission(['staffKec'])) {
        return parseInt(authUser.kecamatan.code_bps)
      }

      if (checkPermission(['staffKel'])) {
        return parseInt(authUser.kelurahan.code_bps)
      }

      return null
    }
  },

  methods: {
    checkPermission,

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    },

    changeKabkota(id) {
      this.listQuery.domicile_kabkota_bps_id = id
    },

    changeKecamatan(id) {
      this.listQuery.domicile_kec_bps_id = id
    },

    changeKelurahan(id) {
      this.listQuery.domicile_kel_bps_id = id
    },

    async downloadVerval() {
      // set state tahap
      this.queryDownload.tahap_bantuan = this.listQuery.tahap
      const response = await exportBansos(this.queryDownload)
      if (response.status === 200) {
        Swal.fire({
          title: this.$t('label.beneficiaries-download-start-title-alert'),
          text: this.$t(
            'label.beneficiaries-download-start-description-alert'
          ),
          icon: 'success',
          button: 'OK'
        })
      }
    },
    showHistoryDownload() {
      this.dialogTableVisible = true
      if (this.$refs.dialogDownloadHistoryVerval) {
        this.$refs.dialogDownloadHistoryVerval.getDataStatus()
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .float-right {
    float: right;
  }

.border-green {
  border: 2px solid #13ce66;
}
</style>

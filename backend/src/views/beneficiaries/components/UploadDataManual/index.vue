<template>
  <div>
    <el-row :gutter="20" class="pb-2">

      <!-- section box import data manual -->
      <el-col :span="8" style="position:relative">
        <div>
          <el-card shadow="never" class="section-box-upload" :body-style="{'border-radius': '8px','background-color': '#FF834E', 'color': '#fff' }">
            <el-row :gutter="20" class="pb-2 box-upload-info">
              <el-col :span="7">
                <div>
                  <img src="@/assets/upload-data.svg" alt="icon-upload">
                </div>
              </el-col>
              <el-col :span="17"><div class="text-24 text-bold pl-1 line-height-29" v-html="$t('importDataManual.title')" /></el-col>
            </el-row>

            <div class="text-14" style="line-height: 150%;">
              {{ $t('importDataManual.desc') }}
            </div>

            <el-row class="section-action-upload">
              <el-button size="medium" class="bg-sw-green text-white text-16 border-radius-8 border-green text-bold p-2 mr-1" @click="openUpload = true">{{ $t('importDataManual.btn-import') }}</el-button>
              <el-button size="medium" class="bg-transparant text-white text-16 border-radius-8 border-none text-bold p-2 border-2" @click="openGuide = true">{{ $t('importDataManual.btn-guide') }}</el-button>
            </el-row>
          </el-card>
        </div>
        <div class="bg-upload">
          <img src="@/assets/bg-upload-manual.png" alt="bg-upload">
        </div>
      </el-col>

      <!-- section table -->
      <el-col :span="16">
        <el-card shadow="never" class="section-box-table border-radius-8" :body-style="{'border-radius': '8px' }">
          <div class="title-table">
            <el-row :gutter="20">
              <el-col :span="12">
                <div class="text-22 text-bold">
                  {{ $t('importDataManual.tbl-title') }}
                </div>
              </el-col>
              <el-col :span="6" :offset="6" style="text-align:end">
                <el-button size="medium" class="text-16 border-orange text-orange border-radius-8" @click="downloadSample()"> {{ $t('importDataManual.btn-download') }}</el-button>
              </el-col>
            </el-row>
          </div>

          <el-table
            :data="tableData"
            stripe
            :header-row-style="{'color': '#000', 'font-weight': 'bold' }"
            height="260"
            style="width: 100%"
          >
            <el-table-column
              type="index"
              align="center"
              label="NO"
              :index="getTableRowNumbering"
              width="50"
            />
            <el-table-column
              prop="namaFile"
              sortable="true"
              label="NAMA FILE"
            />
            <el-table-column
              prop="status"
              sortable="true"
              label="STATUS"
              width="100"
            />
            <el-table-column
              prop="date"
              sortable="true"
              label="WAKTU UPLOAD"
            />
            <el-table-column
              label="AKSI"
              width="80"
            >
              <template slot-scope="scope">
                <el-button
                  size="mini"
                  type="primary"
                  icon="el-icon-view"
                  @click="handleEdit(scope.$index, scope.row)"
                />
              </template>
            </el-table-column>
            <el-button slot="append" type="text" class="btn-load-more">Tampilkan lebih banyak <i class="el-icon-arrow-down" /></el-button>
          </el-table>
        </el-card>
      </el-col>
    </el-row>

    <!-- info guide -->
    <el-dialog
      :visible.sync="openGuide"
      :show-close="false"
      width="35%"
      custom-class="dialog-guide"
      center
    >
      <el-card shadow="never" class="section-box-upload" :body-style="{'border-radius': '8px','background-color': '#FF834E', 'color': '#fff', 'position': 'relative' }">
        <div style="position: absolute; right: 20px; z-index: 2; cursor: pointer" @click="openGuide = false">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.99974 5.58623L11.9497 0.63623L13.3637 2.05023L8.41374 7.00023L13.3637 11.9502L11.9497 13.3642L6.99974 8.41423L2.04974 13.3642L0.635742 11.9502L5.58574 7.00023L0.635742 2.05023L2.04974 0.63623L6.99974 5.58623Z" fill="white" />
          </svg>
        </div>
        <el-row :gutter="20" class="pb-2 box-upload-info">
          <el-col :span="7">
            <div>
              <img src="@/assets/upload-data.svg" alt="icon-upload">
            </div>
          </el-col>
          <el-col :span="17"><div class="text-24 text-bold pl-1 line-height-29" v-html="$t('importDataManual.title-guide')" /></el-col>
        </el-row>

        <div class="text-14" style="line-height: 150%;" v-html="$t('importDataManual.desc-guide')" />

        <el-row class="section-action-upload" style="text-align:center">
          <el-button size="medium" class="bg-sw-green text-white text-16 border-radius-8 border-green text-bold p-2" @click="openUpload = true">{{ $t('importDataManual.upload-btn') }}</el-button>
        </el-row>
      </el-card>
    </el-dialog>

    <!-- upload file -->
    <el-dialog
      :title="$t('importDataManual.title-upload')"
      :visible.sync="openUpload"
      width="30%"
      :show-close="false"
      :before-close="handleCloseUpload"
      custom-class="dialog-guide"
    >
      <div>
        <div style="color:#828282">{{ $t('importDataManual.desc-upload') }}</div>
        <el-upload
          ref="importManual"
          style="text-align:center; padding-top: 1rem"
          :limit="1"
          :before-close="clearUpload"
          :multiple="false"
          action=""
          :auto-upload="false"
          :on-remove="handleUploadRemove"
          :on-change="handleChangeFile"
        >
          <div v-if="!file">
            <el-button type="primary" icon="el-icon-paperclip" plain style="font-weight: bold; padding: 1rem; padding-left: 2rem; padding-right: 2rem">{{ $t('importDataManual.btn-choice') }}</el-button>
          </div>
        </el-upload>
      </div>

      <span slot="footer" class="dialog-footer-upload">
        <el-button class="mr-1" @click="onCloseUploadDialog">{{ $t('crud.cancel') }}</el-button>
        <el-button type="primary" @click="submitUpload">{{ $t('importDataManual.upload') }}</el-button>
      </span>
    </el-dialog>
  </div>

</template>

<script>
import Swal from 'sweetalert2'
import { UrlDownloadImportData } from '@/utils/constantVariable'
export default {
  data() {
    return {
      loading: false,
      openGuide: false,
      openUpload: false,
      tableData: [],
      file: null,
      listQuery: {
        name: null,
        date: null,
        page: 1,
        limit: 10
      }
    }
  },
  methods: {
    getTableRowNumbering(index) {
      return (index + 1)
    },
    handleCloseUpload(done) {
      this.clearUpload()
      done()
    },
    downloadSample() {
      window.open(UrlDownloadImportData)
    },
    async submitUpload() {
      try {
        this.loading = true

        // const formData = new FormData()
        // formData.append('type', this.$route.query.type)
        // formData.append('kabkota_id', this.user.kabkota_id)
        // formData.append('file', this.file)
        // await uploadBansos(formData)
        Swal.fire({
          title: this.$t('label.beneficiaries-upload-start'),
          text: this.$t('label.beneficiaries-upload-success'),
          icon: 'success',
          button: 'OK'
        }).then((action) => {
          if (action) {
            // this.$router.push('/bansos/upload')
          }
        })

        this.loading = false
        this.openUpload = false
      } catch (err) {
        this.loading = false
        if (err.response.status === 422) {
          Swal.fire({
            text: err.response.data.data.file[0],
            icon: 'error',
            button: 'OK'
          })
        }
        return err
      }
    },
    handleChangeFile(file) {
      const isXlsx = file.raw.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
      const isXls = file.raw.type === 'application/vnd.ms-excel'
      if (!isXlsx && !isXls) {
        Swal.fire({
          text: this.$t('errors.field_only_accepts_xlsx_xls'),
          icon: 'error',
          button: 'OK'
        })
        this.clearUpload()
        this.openUpload = false
        this.openGuide = false
      } else {
        this.file = file.raw
      }
    },
    handleUploadRemove() {
      this.$refs.importManual.clearFiles()
      this.file = null
    },
    onCloseUploadDialog() {
      this.clearUpload()
      this.openUpload = false
    },
    clearUpload() {
      this.$refs.importManual.clearFiles()
      this.file = null
      this.openUpload = false
    }
  }
}
</script>

<style lang="scss" scoped>

// dialog
.dialog-footer-upload {
  text-align: center;
}

.title-table {
  padding-bottom: 1rem;
  border-bottom: 1px solid #E0E0E0;
}

.color-sw-green {
  color: #02964D;
}

.bg-sw-green {
  background-color: #02964D;
}

.bg-upload {
    position: absolute;
    bottom: 0;
    right: 0;
}

.line-height-29 {
  line-height: 29px;
}

.bg-transparant {
  background-color: transparent;
}

.text-white {
  color: #fff;
}

.text-orange {
  color: #FF9A08;
}

.mr-1 {
  margin-right: 1rem;
}

.border-radius-8 {
  border-radius: 8px;
}

.border-none {
  border: none;
}

.border-green {
  border: 2px solid #02964D;
}

.border-orange {
  border: 2px solid #FF9A08;
}

.border-2 {
  border: 2px solid #FFFFFF;
}

.pl-1 {
  padding-left: 1rem;
}

.p-2 {
  padding: 1rem;
}

.pb-2 {
  padding-bottom: 2rem;
}

.bg-orange-upload {
  background-color: #FF834E;
}

.text-24 {
  font-size: 24px;
}

.text-22 {
  font-size: 22px;
}

.text-14 {
  font-size: 14px;
}

.text-16 {
  font-size: 16px;
}

.text-bold {
  font-weight: bold;
}

.section-box-upload {
  border: unset;
}

.box-upload-info {
  display: flex;
  align-items: flex-end;
  padding-top: 1rem;
}

.section-action-upload {
  padding-top: 1.5rem;
  padding-bottom: 1rem;
}

.btn-load-more {
  padding-top: 1rem;
  padding-bottom: 1rem;
  display: flex;
  margin: 0 auto;
  font-weight: bold;
}
</style>

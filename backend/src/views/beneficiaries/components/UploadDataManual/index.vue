<template>
  <div v-loading.fullScreen.lock="loading">
    <el-row :gutter="20" class="pb-2">
      <!-- section box import data manual -->
      <el-col :span="8" style="position:relative">
        <div>
          <el-card
            shadow="never"
            class="section-box-upload"
            :body-style="{'border-radius': '8px','background-color': '#FF834E', 'color': '#fff' }"
          >
            <el-row class="pb-2 box-upload-info">
              <el-col :span="10">
                <div>
                  <img src="@/assets/upload-data.svg" alt="icon-upload" class="img-upload">
                </div>
              </el-col>
              <el-col :span="14">
                <div
                  class="text-24 text-bold pl-1 line-height-29"
                  v-html="$t('importDataManual.title')"
                />
              </el-col>
            </el-row>

            <div class="text-14" style="line-height: 150%;">{{ $t('importDataManual.desc') }}</div>

            <el-row :gutter="10" class="section-action-upload">
              <el-col :span="12">
                <el-button
                  size="small"
                  class="bg-sw-green text-white border-radius-8 border-green text-bold p-2 mr-1 btn-import"
                  @click="openUpload = true"
                >{{ $t('importDataManual.btn-import') }}</el-button>
              </el-col>
              <el-col :span="12">
                <img src="@/assets/bg-upload-manual.png" alt="bg-upload" class="bg-image-upload">
                <el-button
                  size="small"
                  class="bg-transparant text-white border-radius-8 border-none text-bold p-2 border-2 btn-guide"
                  @click="openGuide = true"
                >{{ $t('importDataManual.btn-guide') }}</el-button>
              </el-col>
            </el-row>
          </el-card>
        </div>
      </el-col>

      <!-- section table -->
      <el-col :span="16">
        <el-card
          shadow="never"
          class="section-box-table border-radius-8"
          :body-style="{'border-radius': '8px' }"
        >
          <div class="title-table">
            <el-row>
              <el-col :span="12">
                <div class="text-22 text-bold">{{ $t('importDataManual.tbl-title') }}</div>
              </el-col>
              <el-col :span="12">
                <el-button
                  size="medium"
                  class="text-16 border-orange text-orange border-radius-8 btn-export"
                  @click="downloadSample()"
                >{{ $t('importDataManual.btn-download') }}</el-button>
              </el-col>
            </el-row>
          </div>

          <el-table
            v-loading="loadingVervalList"
            :data="sortedList"
            border
            fit
            :header-row-style="{'color': '#000', 'font-weight': 'bold' }"
            height="260"
            style="width: 100%"
            :row-class-name="tableRowClassName"
            @sort-change="changeSort"
          >
            <el-table-column type="index" align="center" :index="getTableRowNumbering" width="50" />
            <el-table-column
              prop="original_filename"
              sortable="custom"
              :label="$t('importDataManual.history-import-file-name')"
            />
            <el-table-column
              prop="notes"
              sortable="custom"
              :label="$t('importDataManual.history-import-status')"
            >
              <template slot-scope="{row}">
                <span :class="statusClassName(row)">{{ row.notes }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="created_at"
              sortable="custom"
              :label="$t('importDataManual.history-import-created-at')"
            >
              <template slot-scope="{row}">{{ row.created_at | moment('D MMMM YYYY H:mm') }}</template>
            </el-table-column>
            <el-table-column :label="$t('importDataManual.history-import-action')" width="80">
              <template slot-scope="{row}">
                <a v-if="row.status === 20 || row.status === 21" :href="row.file_url">
                  <el-tooltip
                    :content="$t('label.beneficiaries-download-invalid-file')"
                    placement="top"
                  >
                    <el-button type="warning" size="mini">
                      <i class="el-icon-download el-icon-right" />
                    </el-button>
                  </el-tooltip>
                </a>
              </template>
            </el-table-column>
          </el-table>

          <pagination
            v-show="total>0"
            :total="total"
            :page.sync="listQuery.page"
            :limit.sync="listQuery.limit"
            @pagination="getVervalUploadList"
          />
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
      class="show-dialog-guide"
    >
      <el-card
        shadow="never"
        class="section-box-upload"
        :body-style="{'border-radius': '8px','background-color': '#FF834E', 'color': '#fff', 'position': 'relative' }"
      >
        <div
          style="position: absolute; right: 20px; z-index: 2; cursor: pointer"
          @click="openGuide = false"
        >
          <svg
            width="14"
            height="14"
            viewBox="0 0 14 14"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6.99974 5.58623L11.9497 0.63623L13.3637 2.05023L8.41374 7.00023L13.3637 11.9502L11.9497 13.3642L6.99974 8.41423L2.04974 13.3642L0.635742 11.9502L5.58574 7.00023L0.635742 2.05023L2.04974 0.63623L6.99974 5.58623Z"
              fill="white"
            />
          </svg>
        </div>
        <el-row :gutter="10" class="pb-2 box-upload-info">
          <el-col :span="10">
            <div>
              <img src="@/assets/upload-data.svg" alt="icon-upload" class="img-upload">
            </div>
          </el-col>
          <el-col :span="14">
            <div
              class="text-24 text-bold pl-1 line-height-29"
              v-html="$t('importDataManual.title-guide')"
            />
          </el-col>
        </el-row>

        <div class="text-14" style="line-height: 150%;" v-html="$t('importDataManual.desc-guide')" />

        <el-row class="section-action-upload" style="text-align:center">
          <el-button
            size="medium"
            class="bg-sw-green text-white text-16 border-radius-8 border-green text-bold p-2"
            @click="openUpload = true"
          >{{ $t('importDataManual.import-btn') }}</el-button>
        </el-row>
      </el-card>
    </el-dialog>

    <!-- upload file -->
    <el-dialog
      :title="$t('importDataManual.title-import')"
      :visible.sync="openUpload"
      width="30%"
      :show-close="false"
      :close-on-click-modal="false"
      custom-class="dialog-guide"
    >
      <div>
        <div style="color:#828282">{{ $t('importDataManual.desc-import') }}</div>
        <el-upload
          ref="importManual"
          style="text-align:center; padding-top: 1rem"
          :limit="1"
          :before-close="clearUpload"
          :multiple="false"
          action
          :auto-upload="false"
          :on-remove="handleUploadRemove"
          :on-change="handleChangeFile"
        >
          <div v-if="!file">
            <el-button
              type="primary"
              icon="el-icon-paperclip"
              plain
              style="font-weight: bold; padding: 1rem; padding-left: 2rem; padding-right: 2rem"
            >{{ $t('importDataManual.btn-import-choice') }}</el-button>
          </div>
        </el-upload>
      </div>

      <span slot="footer" class="dialog-footer-upload">
        <el-button class="mr-1" @click="onCloseUploadDialog">{{ $t('crud.cancel') }}</el-button>
        <el-button type="primary" @click="submitUpload">{{ $t('importDataManual.import') }}</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import { fetchVervalUploadList, vervalUpload } from '@/api/beneficiaries'
import { UrlDownloadImportData } from '@/utils/constantVariable'
import Pagination from '@/components/Pagination'

export default {
  components: { Pagination },
  data() {
    return {
      loading: false,
      openGuide: false,
      total: 0,
      openUpload: false,
      tableData: [],
      file: null,
      listQuery: {
        name: null,
        date: null,
        page: 1,
        limit: 10
      },
      vervalUploadList: null,
      loadingVervalList: true,
      sort_prop: 'data.approved',
      sort_order: 'descending'
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
      if (this.vervalUploadList) {
        return this.vervalUploadList.map(x => x).sort(compare)
      } else {
        return []
      }
    }
  },
  created() {
    this.getVervalUploadList()
  },
  methods: {
    async getVervalUploadList() {
      this.loadingVervalList = true
      const response = await fetchVervalUploadList(this.listQuery)
      const data = []
      response.data.items.map(value => {
        const fileUrl =
          value.status === 20
            ? value.invalid_file_path_url
            : value.status === 21
              ? value.file_path_url
              : ''
        const notes =
          value.status === 0
            ? this.$t('label.beneficiaries-import-start')
            : value.status === -1
              ? this.$t('label.beneficiaries-upload-error-process')
              : value.notes
        data.push({
          original_filename: value.original_filename,
          status: value.status,
          notes: notes,
          created_at: value.created_at,
          file_url: fileUrl
        })
      })

      this.vervalUploadList = data
      this.loadingVervalList = false
      this.total = response.data._meta.totalCount
    },
    getTableRowNumbering(index) {
      return (this.listQuery.page - 1) * this.listQuery.limit + (index + 1)
    },
    downloadSample() {
      window.open(UrlDownloadImportData)
    },
    async submitUpload() {
      try {
        this.loading = true
        this.openUpload = false
        const formData = new FormData()

        formData.append('file', this.file)
        await vervalUpload(formData)

        this.clearUpload()
        this.loading = false

        Swal.fire({
          title: this.$t('label.beneficiaries-upload-start'),
          text: this.$t('label.beneficiaries-upload-success'),
          icon: 'success',
          button: 'OK'
        }).then(action => {
          if (action) {
            this.getVervalUploadList()
          }
        })
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
      const fileExtension = file.name.replace(/^.*\./, '')
      if (fileExtension === 'xlsx') {
        this.file = file.raw
      } else {
        Swal.fire({
          text: this.$t('errors.field_only_accepts_xlsx'),
          icon: 'error',
          button: 'OK'
        })
        this.clearUpload()
        this.openUpload = false
        this.openGuide = false
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
    },
    changeSort(e) {
      this.sort_prop = e.prop
      this.sort_order = e.order
    },
    statusClassName(row) {
      return row.status === 10 ? 'success-status' : ''
    },
    tableRowClassName({ row, rowIndex }) {
      return row.status === 20
        ? 'danger-row'
        : row.status === 21
          ? 'warning-row'
          : ''
    }
  },
  getCreatedAt(data) {
    return data.created_at
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
  border-bottom: 1px solid #e0e0e0;
}

.color-sw-green {
  color: #02964d;
}

.bg-sw-green {
  background-color: #02964d;
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
  color: #ff9a08;
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
  border: 2px solid #02964d;
}

.border-orange {
  border: 2px solid #ff9a08;
}

.border-2 {
  border: 2px solid #ffffff;
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
  background-color: #ff834e;
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

.btn-export {
  float: right;
}

.btn-import {
  float: left;
  width: 100%;
  font-size: 11px;
}

.btn-guide {
  float: right;
  width: 100%;
  font-size: 11px;
}

.bg-image-upload {
  position: absolute;
  right: -10px;
  top: -140px;
  z-index: 1;
}

.img-upload {
  width: 100%;
}

.el-dialog.el-dialog--center.dialog-guide {
  background: transparent;
  box-shadow: none;
}

.dialog-guide .el-dialog__footer {
  text-align: center;
}

.dialog-guide .el-card__body {
  border-radius: 0px !important;
}

.show-dialog-guide {
  margin-top: -100px !important;
}

.success-status {
  color: #67c23a;
}

.el-table .warning-row {
  background: rgb(250, 236, 216);
}

.el-table .danger-row {
  background: rgb(253, 226, 226);
}

.hover-row > td {
  background-color: initial !important;
}
</style>

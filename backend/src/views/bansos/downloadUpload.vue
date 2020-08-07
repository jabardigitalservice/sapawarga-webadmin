<template>
  <div class="app-container">
    <div>
      <h2 class="dashboard-title">Unduh dan Unggah BNBA</h2>
      <div class="warn-content-warning">
        <p class="title">
          <span>
            <i class="el-icon-warning" style="color: rgba(226, 194, 124, 0.938)" />
          </span>
          <span>Panduan Penggunaan:</span>
        </p>
        <p class="content">
          <ol>
            <li>Unduh dan Unggah BNBA usulan</li>
            <li>Cek email 1x24 jam apabila tidak terkirim hubungi WA: +62 812-2008-2668</li>
            <li>Buka file excel dan silahkan isi verval di kolom Berikan Bantuan, apabila tidak layak mendapat bantuan, isi dikolom tersebut dengan isi: "tidak"</li>
            <li>Save dengan format, nama kab/kota dan tanggal, misal: Kab bandung 170720</li>
            <li>Unggah data hasil verifikasi</li>
          </ol>
        </p>
      </div>
    </div>
    <el-row :gutter="24">
      <el-col :xs="24" :sm="24" :lg="12">
        <el-button size="large" name="button-download" type="primary" style="width: 100%; padding: 50px; font-weight: bold; font-size: 1.2rem" @click="downloadFile">{{ $t('label.beneficiaries-download-bnba') }}</el-button>
      </el-col>
      <el-col :xs="24" :sm="24" :lg="12">
        <el-upload
          ref="uploadBnbaManual"
          class="upload-container"
          :limit="1"
          :auto-upload="false"
          :multiple="false"
          action
          :on-change="handleChangeFile"
        >
          <el-button size="large" name="button-upload" type="warning" style="width: 100%; padding: 50px; font-weight: bold; font-size: 1.2rem">{{ $t('label.beneficiaries-upload-bnba') }}</el-button>
        </el-upload>
      </el-col>
    </el-row>
    <br>
    <el-button class="button-history float-right" type="success" plain @click="showHistoryDownload">{{ $t('label.beneficiaries-history-download-bnba') }}</el-button>
    <br>
    <br>
    <UploadTable ref="uploadTable" />

    <el-dialog width="70%" :visible.sync="dialogTableVisible">
      <span slot="title" class="dialog-title">{{ $t('label.beneficiaries-history-download-bnba') }}</span>
      <DialogDownloadHistory ref="dialogDownloadHistory" :source="'bnba'" :params="{export_type: 'bnbawithcomplain'}" />
    </el-dialog>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import { Loading } from 'element-ui'
import { uploadBnba } from '@/api/beneficiaries'
import { downloadBeneficiariesBnba } from '@/api/beneficiaries'
import UploadTable from './components/UploadTable'
import DialogDownloadHistory from '../beneficiaries/components/DialogDownloadHistory'
export default {
  components: {
    UploadTable,
    DialogDownloadHistory
  },
  data() {
    return {
      dialogTableVisible: false,
      file: null
    }
  },
  methods: {
    handleChangeFile(file) {
      const fileExtension = file.name.replace(/^.*\./, '')
      if (fileExtension === 'xlsx') {
        this.file = file.raw
        console.log('masuk')
        this.uploadFile()
      } else {
        Swal.fire({
          text: this.$t('errors.field_only_accepts_xlsx'),
          icon: 'error',
          button: 'OK'
        })
        this.clearUpload()
      }
    },
    handleRemoveFile() {
      this.clearUpload()
      this.file = null
    },
    clearUpload() {
      this.$refs.uploadBnbaManual.clearFiles()
    },
    async downloadFile() {
      try {
        Loading.service({ fullScreen: true })
        const params = {
          export_type: 'bnbawithcomplain'
        }
        const response = await downloadBeneficiariesBnba(params)
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
        Loading.service({ fullScreen: true }).close()
      } catch (error) {
        Loading.service({ fullScreen: true }).close()
      }
    },
    async uploadFile() {
      try {
        this.loading = true

        const formData = new FormData()
        formData.append('file', this.file)
        await uploadBnba(formData)
        Swal.fire({
          title: this.$t('label.beneficiaries-bnba-upload'),
          icon: 'success',
          button: 'OK'
        }).then(action => {
          if (action) {
            this.file = null
            this.$refs.uploadBnbaManual.clearFiles()
            this.$refs.uploadTable.getVervalUploadList()
          }
        })

        this.loading = false
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
    showHistoryDownload() {
      this.dialogTableVisible = true
      if (this.$refs.dialogDownloadHistory) {
        this.$refs.dialogDownloadHistory.getDataStatus()
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.warn-content-warning {
  background: #fff3d2;
  border: 1.5px solid rgba(226, 194, 124, 0.938);
  border-radius: 5px;
  padding: 0.5rem 1.5rem;
  word-spacing: 0.05rem;
  color: black;
  margin-bottom: 25px;

  p {
    margin: 10px 0;
  }

  .title {
    font-weight: 600;
  }

  .content {
    padding-left: 1.5rem;
    line-height: 1.4;
  }

  .link {
    text-decoration: underline;
    cursor: pointer;
    color: white !important;
  }

  .btn-download-upload {
    font-weight: bold;
  }
}
</style>

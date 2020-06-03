<template>
  <div>
    <el-row :gutter="20" class="pb-2">
      <el-col :span="8" style="position:relative">
        <div>
          <el-card shadow="never" class="section-box-upload" :body-style="{'border-radius': '8px','background-color': '#FF834E', 'color': '#fff' }">
            <el-row :gutter="20" class="pb-2 box-upload-info">
              <el-col :span="7">
                <div>
                  <img src="@/assets/upload-data.svg" alt="icon-upload">
                </div>
              </el-col>
              <el-col :span="17"><div class="text-24 text-bold pl-1 line-height-29">Import manual data calon penerima Bantuan <br> Sosial</div></el-col>
            </el-row>

            <div class="text-14" style="line-height: 150%;">
              Sekarang Anda dapat melakukan input calon penerima bantuan sosial secara manual, sehingga dapat membantu kami lebih baik lagi untuk memperbaiki perlayanan di Sapawarga
            </div>

            <el-row class="section-action-upload">
              <el-button size="medium" class="bg-sw-green text-white text-16 border-radius-8 border-green text-bold p-2 mr-1" @click="openUpload = true">IMPORT SEKARANG</el-button>
              <el-button size="medium" class="bg-transparant text-white text-16 border-radius-8 border-none text-bold p-2 border-2" @click="openGuide = true">LIHAT PANDUAN</el-button>
            </el-row>
          </el-card>
        </div>
        <div class="bg-upload">
          <img src="@/assets/bg-upload-manual.png" alt="bg-upload">
        </div>
      </el-col>
      <el-col :span="16">
        <el-card shadow="never" class="section-box-table border-radius-8" :body-style="{'border-radius': '8px' }">
          <div class="title-table">
            <el-row :gutter="20">
              <el-col :span="12">
                <div class="text-22 text-bold">
                  Riwayat Import Data Manual
                </div>
              </el-col>
              <el-col :span="6" :offset="6" style="text-align:end">
                <el-button size="medium" class="text-16 border-orange text-orange border-radius-8" @click="downloadSample()">Unduh Template Excel</el-button>
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
              prop="no"
              label="NO"
              width="100"
            />
            <el-table-column
              prop="namaFile"
              label="NAMA FILE"
            />
            <el-table-column
              prop="status"
              label="STATUS"
              width="100"
            />
            <el-table-column
              prop="date"
              label="WAKTU UPLOAD"
            />
            <el-table-column
              label="AKSI"
              width="100"
            >
              <template slot-scope="scope">
                <el-button
                  size="mini"
                  type="primary"
                  icon="el-icon-share"
                  @click="handleEdit(scope.$index, scope.row)"
                />
              </template>
            </el-table-column>
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
      <el-card shadow="never" class="section-box-upload" :body-style="{'border-radius': '8px','background-color': '#FF834E', 'color': '#fff' }">
        <el-row :gutter="20" class="pb-2 box-upload-info">
          <el-col :span="7">
            <div>
              <img src="@/assets/upload-data.svg" alt="icon-upload">
            </div>
          </el-col>
          <el-col :span="17"><div class="text-24 text-bold pl-1 line-height-29">Panduan Input Data Calon Penerima Bantuan <br> Sosial</div></el-col>
        </el-row>

        <div class="text-14" style="line-height: 150%;">
          <ol>
            <li><b>Download<b /> template file Excel.xlsx untuk melihat format Input Data</b></li>
            <li>Mengisi kolom dengan data yang benar, kolom berwarna hijau wajib untuk diisi.</li>
            <li>Save dengan format .xlsx</li>
            <li>Pilih file Excel.xlsx yang akan diupload</li>
            <li>klik tombol Upload</li>
          </ol>
        </div>

        <el-row class="section-action-upload" style="text-align:center">
          <el-button size="medium" class="bg-sw-green text-white text-16 border-radius-8 border-green text-bold p-2" @click="openUpload = true">IMPORT SEKARANG</el-button>
        </el-row>
      </el-card>
    </el-dialog>

    <!-- upload file -->
    <el-dialog
      title="Upload Data Input Manual"
      :visible.sync="openUpload"
      width="30%"
      :show-close="false"
      custom-class="dialog-guide"
    >
      <div>
        <div style="color:#828282">Untuk upload data input manual harus memakai format Excel (.xls).</div>
        <el-upload
          ref="importManual"
          style="text-align:center; padding-top: 1rem"
          :limit="1"
          :before-close="clearUpload"
          :multiple="false"
          action=""
          :auto-upload="false"
          :on-change="handleChangeFile"
        >
          <div v-if="!file">
            <el-button type="primary" icon="el-icon-paperclip" plain style="font-weight: bold; padding: 1rem; padding-left: 2rem; padding-right: 2rem">Pilih File yang akan diupload</el-button>
          </div>
        </el-upload>
      </div>

      <span slot="footer" class="dialog-footer-upload">
        <el-button @click="onCloseUploadDialog">Batal</el-button>
        <el-button type="primary" @click="openUpload = false">Upload</el-button>
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
      tableData: [
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'asdasdas  adasdsadas asdadasdas assa dad asdas da',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        }
      ],
      file: null
    }
  },
  methods: {
    downloadSample() {
      window.open(UrlDownloadImportData)
    },
    async submitUpload() {
      try {
        this.loading = true

        const formData = new FormData()
        formData.append('type', this.$route.query.type)
        formData.append('kabkota_id', this.user.kabkota_id)
        formData.append('file', this.file)
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
      const isXls = file.raw.type === ''
      if (!isXlsx && !isXls) {
        Swal.fire({
          text: this.$t('errors.field_only_accepts_xlsx_xls'),
          icon: 'error',
          button: 'OK'
        })
        this.clearUpload()
        this.openUpload = false
      } else {
        this.file = file.raw
      }
    },
    onCloseUploadDialog() {
      this.clearUpload()
      this.openUpload = false
    },
    clearUpload() {
      console.log('masuk')
      this.$refs.importManual.clearFiles()
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
</style>

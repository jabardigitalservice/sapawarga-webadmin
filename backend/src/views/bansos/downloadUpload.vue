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
            <li>Unduh dan BNBA usulan</li>
            <li>Cek email 1x24 jam apabila tidak terkirim hubungi WA: 08XXXXX</li>
            <li>Buka file excel dan silahkan isi verval di kolom Berikan Bantuan, apabila tidak layak mendapat bantuan, isi dikolom tersebut dengan isi: "tidak"</li>
            <li>Save dengan format, nama kab/kota dan tanggal, misal: Kab bandung 170720</li>
            <li>Unggah data hasil verifikasi</li>
          </ol>
        </p>
      </div>
    </div>
    <el-row :gutter="24">
      <el-col :xs="24" :sm="24" :lg="12">
        <el-button size="large" name="button-download" type="primary" style="width: 100%; padding: 50px; font-weight: bold; font-size: 1.2rem" @click="downloadFile">Unduh Data BNBA Usulan</el-button>
      </el-col>
      <el-col :xs="24" :sm="24" :lg="12">
        <el-button size="large" name="button-upload" type="warning" style="width: 100%; padding: 50px; font-weight: bold; font-size: 1.2rem" @click="uploadFile">Unggah Data Hasil Verifikasi Manual</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import { Loading } from 'element-ui'
import { exportBansos } from '@/api/bansos'
export default {

  data() {
    return {
    }
  },
  methods: {
    async downloadFile() {
      try {
        Loading.service({ fullScreen: true })
        const response = await exportBansos()
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
    uploadFile() {
      alert('upload')
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

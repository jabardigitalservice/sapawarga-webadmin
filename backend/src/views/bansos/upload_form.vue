<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-card class="box-card green body-nopadding">
          <div slot="header">
            <span>Upload Data KRTS Non DTKS: {{ getTitle() }}</span>
          </div>
          <div class="text item card-description">
            <p><strong>Pilih salah satu antara Kota/Kabupaten atau Kecamatan</strong></p>
            <p>Sebelum melakukan upload file excel diharap memilih lokasi upload yang dituju.</p>
          </div>
        </el-card>
        <el-card class="box-card">
          <div class="text item">
            <el-collapse v-model="activeName" accordion>
              <el-collapse-item :title="`Alokasi ${ getTitle() } untuk ${user.kabkota.name}`" name="1">
                <el-upload
                  ref="upload"
                  class="upload-demo"
                  :multiple="false"
                  :headers="{ Authorization: `Bearer ${ getToken() }` }"
                  :data="{ type: type, kabkota_id: user.kabkota_id }"
                  :action="`${url}bansos/upload`"
                  :auto-upload="false"
                  :on-success="onSuccess"
                >
                  <el-button slot="trigger" type="primary">Pilih Dokumen</el-button>
                  <el-button style="margin-left: 10px;" type="success" @click="submitUpload">Kirim</el-button>
                </el-upload>
              </el-collapse-item>
              <el-collapse-item :title="`Alokasi ${ getTitle() } Per Kecamatan`" name="2">
                <div style="margin: 20px 0">
                  <input-kecamatan @changeKecamatan="changeKecamatan" />
                </div>
                <el-upload
                  ref="uploadKecamatan"
                  class="upload-demo"
                  :multiple="false"
                  :headers="{ Authorization: `Bearer ${ getToken() }` }"
                  :data="{ type: type, kabkota_id: user.kabkota_id, kec_id: kecId }"
                  :action="`${url}bansos/upload`"
                  :auto-upload="false"
                  :on-success="onSuccess"
                >
                  <el-button slot="trigger" type="primary">Pilih Dokumen</el-button>
                  <el-button style="margin-left: 10px;" type="success" @click="submitUploadKecamatan">Kirim</el-button>
                </el-upload>
              </el-collapse-item>
            </el-collapse>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { getToken } from '@/utils/auth'
import { mapGetters } from 'vuex'
import InputKecamatan from '@/components/InputKec'

export default {
  components: { InputKecamatan },

  data() {
    return {
      type: this.$route.query.type,
      activeName: '1',
      url: process.env.VUE_APP_BASE_API,
      kecId: null
    }
  },

  computed: {
    ...mapGetters([
      'user'
    ])
  },

  methods: {
    getToken,

    getTitle() {
      switch (this.type) {
        case '1':
          return 'Bantuan Sosial Provinsi'
        case '2':
          return 'Bantuan Sosial Kota/Kabupaten'
        case '3':
          return 'Bantuan Dana Desa'
        case '4':
          return 'Bantuan Sosial Presiden Sembako (Bodebek)'
        case '5':
          return 'Bantuan Sosial Tunai Kemensos'
        default:
          return 'N/A'
      }
    },

    submitUpload() {
      this.$refs.upload.submit()
    },

    submitUploadKecamatan() {
      this.$refs.uploadKecamatan.submit()
    },

    changeKecamatan(value) {
      console.log(value)
      this.kecId = value
    },

    onSuccess(response, file, fileList) {
      this.$message.success('Dokumen berhasil dikirim.')

      this.$router.push('/bansos/upload')
    }
  }
}
</script>

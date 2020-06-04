<template>
  <div v-loading.fullscreen.lock="loading" class="app-container">
    <el-row>
      <el-col :span="24">
        <span class="head-title">
          <b>{{ $t('label.area-kabkota') }}</b>
        </span>
      </el-col>
    </el-row>
    <br>
    <el-row :gutter="40">
      <el-col :span="12">
        <el-upload
          ref="upload"
          drag
          :multiple="false"
          :limit="1"
          action
          :auto-upload="false"
          :on-change="handleChangeFile"
        >
          <div class="el-upload__text">
            <i class="el-icon-upload" />
            <em>{{ $t('label.beneficiaries-add-file') }}</em>
          </div>
        </el-upload>
      </el-col>
      <el-col :span="12">
        <el-button type="primary" @click="submitUpload">
          {{ $t('label.beneficiaries-upload-file') }}
          <i class="el-icon-upload el-icon-right" />
        </el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { uploadBansos } from '@/api/bansos'
import { mapGetters } from 'vuex'
import Swal from 'sweetalert2'

export default {
  name: 'FormUploadCity',
  data() {
    return {
      loading: false,
      file: null
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    async submitUpload() {
      try {
        this.loading = true

        const formData = new FormData()
        formData.append('type', this.$route.query.type)
        formData.append('kabkota_id', this.user.kabkota_id)
        formData.append('file', this.file)
        await uploadBansos(formData)
        Swal.fire({
          title: this.$t('label.beneficiaries-upload-start'),
          text: this.$t('label.beneficiaries-upload-success'),
          icon: 'success',
          button: 'OK'
        }).then(action => {
          if (action) {
            this.$router.push('/bansos/upload')
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
      const isXlsx =
        file.raw.type ===
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
      const isXls = file.raw.type === ''
      if (!isXlsx && !isXls) {
        Swal.fire({
          text: this.$t('errors.field_only_accepts_xlsx_xls'),
          icon: 'error',
          button: 'OK'
        })
        this.$refs.upload.clearFiles()
      } else {
        this.file = file.raw
      }
    }
  }
}
</script>

<style>
.el-row {
  margin-bottom: 10px;
}
.el-upload {
  display: inline-block;
  text-align: center;
  cursor: pointer;
  outline: none;
  width: 100%;
}
.el-upload-dragger {
  background-color: #fff;
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  height: 36px !important;
  text-align: center;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  width: 100% !important;
}
.el-upload-dragger .el-icon-upload {
  font-size: 20px;
  color: #c0c4cc;
  margin: -10px 0 -10px;
  line-height: 50px;
}
</style>


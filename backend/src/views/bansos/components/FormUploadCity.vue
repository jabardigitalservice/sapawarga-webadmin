<template>
  <div v-loading.fullScreen.lock="loading" class="app-container">
    <el-row :gutter="40">
      <el-col :span="24">
        <div class="upload-description">{{ $t('label.beneficiaries-upload-description') }}</div>
        <el-upload
          ref="importBansos"
          class="form-upload"
          :limit="1"
          :multiple="false"
          action
          :auto-upload="false"
          :on-change="handleChangeFile"
          :on-remove="handleRemoveFile"
        >
          <div v-if="!file">
            <el-button
              icon="el-icon-paperclip"
              plain
              class="button-upload"
            >{{ $t('label.beneficiaries-choose-file') }}</el-button>
          </div>
        </el-upload>
      </el-col>
    </el-row>
    <br>
    <el-row :gutter="40">
      <el-col :span="20">&nbsp;</el-col>
      <el-col :span="4">
        <el-button type="primary" style="width:100%" @click="submitUpload">
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
            this.$router.push('/allocation/upload')
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
      }
    },
    handleRemoveFile() {
      this.clearUpload()
      this.file = null
    },
    clearUpload() {
      this.$refs.importBansos.clearFiles()
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
.upload-description {
  color: #828282;
}
.form-upload {
  text-align: center;
  padding-top: 1rem;
}
.button-upload {
  font-weight: bold;
  padding: 1rem;
  padding-left: 2rem;
  padding-right: 2rem;
}
</style>


<template>
  <div class="components-container">
    <div class="warning">
      <p class="caution">Upload beberapa dokumen pendukung untuk kelengkapan proses validasi penerima bantuan.</p>
    </div>
    <el-form
      ref="beneficiaries"
      :model="beneficiaries"
      :status-icon="true"
      label-width="250px"
      label-position="top"
    >
      <el-row>
        <el-col :xs="24" :sm="24" :md="12" :lg="12">
          <div>
            <el-form-item class="position" label="Foto KTP" prop="nik">
              <div class="image-beneficiaries">
                <AttachmentPhotoUpload
                  type="user_post_photo"
                  :initial-url="beneficiaries.image_ktp_url"
                  style="margin-bottom: 25px"
                  @onUpload="photoUploadedKtp"
                />
              </div>
            </el-form-item>
          </div>
        </el-col>
        <el-col :xs="24" :sm="24" :md="12" :lg="12">
          <el-form-item class="position" label="Foto Kepala Keluarga" prop="nik">
            <div class="image-beneficiaries">
              <AttachmentPhotoUpload
                type="user_post_photo"
                :initial-url="beneficiaries.image_kk_url"
                style="margin-bottom: 25px"
                @onUpload="photoUploadedKk"
              />
            </div>
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item class="ml-min-40 form-button">
        <span v-if="!isCreate">Apakah data sudah benar?</span>
        <el-button v-if="!isCreate" class="button-action" type="primary" plain @click="next">{{ $t('crud.change') }}</el-button>
        <el-button class="button-action" type="primary" @click="dialogVisible = true"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
    <el-dialog
      title="Konfirmasi"
      :visible.sync="dialogVisible"
      center
    >
      <p>Data yang sudah dimasukan tidak dapat diubah lagi.</p>
      <p>Apakah yakin untuk memproses data ini?</p>
      <p>Klik Cek Ulang apabila Anda ingin melakukan pengecekan.</p>
      <span slot="footer" class="dialog-footer">
        <el-button @click="next">{{ $t('crud.recheck') }}</el-button>
        <el-button type="danger" @click="updateData(statusRejected)">{{ $t('crud.reject') }}</el-button>
        <el-button type="success" @click="updateData(statusVerified)">{{ $t('crud.verified') }}</el-button>
      </span>
    </el-dialog>
    {{ isCreate }}
  </div>
</template>
<script>
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'
import { update, create } from '@/api/beneficiaries'

export default {
  components: { AttachmentPhotoUpload },
  props: {
    beneficiaries: {
      type: Object,
      default: null
    },
    isCreate: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      dialogVisible: false,
      statusVerified: 3,
      statusRejected: 2
    }
  },
  methods: {
    next() {
      this.dialogVisible = true
      this.$emit('nextStep', 1)
    },
    async updateData(value) {
      const id = await this.$route.params && this.$route.params.id
      if (value === this.statusVerified) {
        this.beneficiaries.status_verification = value
      } else {
        this.beneficiaries.status_verification = value
      }

      if (this.isCreate) {
        this.beneficiaries.status = 10
        await create(this.beneficiaries)
      } else {
        delete this.beneficiaries.nik
        await update(id, this.beneficiaries)
      }
      this.dialogVisible = false
      this.$message.info('Status berhasil diubah')
      this.$router.push('/beneficiaries/index')
    },
    photoUploadedKtp(path, url) {
      this.beneficiaries.image_ktp_url = url
      this.$emit('getImageKtp', path)
    },
    photoUploadedKk(path, url) {
      this.beneficiaries.image_kk_url = url
      this.$emit('getImageKk', path)
    }
  }
}
</script>
<style lang="scss" scoped>
  .caution {
    font-size: 14px;
    padding: 5px 0;
    margin: 0px;
  }
  .warning {
    margin-bottom: 35px;
  }
  .button-action {
    margin: 0 5px;
  }
  .form-button {
    margin-top: 50px;
  }
  .image-beneficiaries {
    width: 100%;
  }
  .position {
    width: 50%;
    display: block;
    margin: auto;
  }
</style>

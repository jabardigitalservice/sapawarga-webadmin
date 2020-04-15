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
                  :initial-url="beneficiaries.image_path_url"
                  :list-information="[this.$t('label.maximum-dimension-image'), this.$t('label.maximum-size-image')]"
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
                :initial-url="beneficiaries.image_path_url"
                :list-information="[this.$t('label.maximum-dimension-image'), this.$t('label.maximum-size-image')]"
                style="margin-bottom: 25px"
                @onUpload="photoUploadedKk"
              />
            </div>
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item class="ml-min-40 form-button">
        <span>Apakah data sudah benar?</span>
        <el-button class="button-action" type="primary" plain>{{ $t('crud.change') }}</el-button>
        <el-button class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'

export default {
  components: { AttachmentPhotoUpload },
  props: {
    beneficiaries: {
      type: Object,
      default: null
    }
  },
  methods: {
    async next() {
      this.$emit('nextStep', true)
    },
    photoUploadedKtp(path, url) {
      this.beneficiaries.image_ktp_url = path
    },
    photoUploadedKk(path, url) {
      this.beneficiaries.image_kk_url = path
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

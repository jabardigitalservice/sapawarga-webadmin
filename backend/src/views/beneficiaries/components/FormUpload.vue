<template>
  <div class="components-container">
    <div class="warning">
      <el-row>
        <el-col :xs="24" :sm="24" :md="13" :lg="13">
          <p v-if="isCreate && beneficiaries.is_have_ktp === 0" class="caution">Untuk memastikan kesesuaian data calon penerima bantuan, dimohon untuk meng-upload foto surat pernyataan yang menyatakan bahwa benar warga tersebut berdomisili di Desa Anda.</p>
          <p v-else class="caution">Upload beberapa dokumen pendukung untuk kelengkapan proses validasi penerima bantuan.</p>
        </el-col>
      </el-row>
    </div>
    <el-form
      ref="beneficiaries"
      :model="beneficiaries"
      :status-icon="true"
      label-width="250px"
      label-position="top"
    >
      <el-row>
        <el-col>
          <div>
            <el-form-item class="position" :label="label" prop="nik">
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
        <!-- <el-col :xs="24" :sm="24" :md="12" :lg="12">
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
        </el-col> -->
      </el-row>
      <el-form-item class="ml-min-40 form-button position">
        <span v-if="!isCreate">Apakah data sudah benar?</span>
        <!-- <el-button v-if="!isCreate" class="button-action" type="primary" plain @click="next">{{ $t('crud.change') }}</el-button> -->
        <el-button class="button-action" type="primary" @click="dialogVisible = true"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
    <el-dialog
      title="Konfirmasi"
      :visible.sync="dialogVisible"
      center
      width="40%"
    >
      <p>Data yang sudah dimasukan tidak dapat diubah lagi.</p>
      <p>Apakah yakin untuk memproses data ini?</p>
      <p>Klik Cek Ulang apabila Anda ingin melakukan pengecekan.</p>
      <span slot="footer" class="dialog-footer">
        <el-button @click="next">{{ $t('crud.recheck') }}</el-button>
        <el-button v-if="!isCreate" type="danger" @click="updateData(statusRejected)">{{ $t('crud.reject') }}</el-button>
        <el-button type="success" @click="getConfirmation">{{ $t('label.beneficiaries-validate-select') }}</el-button>
      </span>

      <el-dialog
        width="30%"
        title="Pernyataan"
        :visible.sync="confirmation"
        append-to-body
        center
      >
        <p class="confirmation-text">
          Dengan ini saya menyatakan benar bahwa warga ini adalah warga
          <span v-if="beneficiaries.domicile_rw"> RW {{ beneficiaries.domicile_rw }}</span>
          <span> Kelurahan/Desa {{ beneficiaries.domicile_kel_name.name }},</span>
          <span> Kecamatan {{ beneficiaries.domicile_kec_name.name }},</span>
          <span> Kota/Kabupaten {{ beneficiaries.domicile_kabkota_name.name }}</span>
          dan warga ini adalah warga yang membutuhkan serta layak dibantu.
        </p>
        <el-checkbox v-model="checked">
          Ya, Saya setuju
        </el-checkbox>
        <div>
          <el-button class="confirmation-button" type="success" :disabled="!checked" @click="updateData(statusVerified)">{{ $t('crud.save-verified') }}</el-button>
        </div>
      </el-dialog>
    </el-dialog>
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
      confirmation: false,
      checked: false,
      statusVerified: 5,
      statusRejected: 2,
      label: 'Foto KTP/Copy KTP/KK'
    }
  },
  created() {
    if (this.beneficiaries.is_have_ktp === 0) this.label = 'Upload Surat Pernyataan'
  },
  methods: {
    getConfirmation() {
      this.dialogVisible = false
      this.confirmation = true
    },
    next() {
      this.dialogVisible = true
      this.$emit('nextStep', 1)
    },
    validateInput(input) {
      if (_.isEmpty(input)) {
        return 'Catatan harus diisi.'
      }

      return true
    },
    async updateData(value) {
      const id = await this.$route.params && this.$route.params.id
      if (value === this.statusVerified) {
        this.beneficiaries.status_verification = value
      } else {
        this.beneficiaries.status_verification = value
        const prompt = await this.$prompt('Berikan alasan penolakan', 'Tolak penerima bantuan untuk warga ini?', {
          confirmButtonText: this.$t('common.send'),
          cancelButtonText: this.$t('common.cancel'),
          inputPlaceholder: 'Tuliskan catatan disini',
          inputValidator: this.validateInput
        })
        this.beneficiaries.notes_rejected = prompt.value
      }
      try {
        if (this.isCreate) {
          this.beneficiaries.status = 10
          await create(this.beneficiaries)
        } else {
          await update(id, this.beneficiaries)
        }
        this.dialogVisible = false
        this.$message.info('Status berhasil diubah')
        this.$router.push('/beneficiaries/index')
      } catch (error) {
        const message = error.response.data.data[0].message
        const success = error.response.data.success
        if (!success) this.$message.error(message)
      }
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
    line-height: 25px;
  }
  .warning {
    margin-bottom: 35px;
  }
  .button-action {
    margin: 0 5px;
  }
  .form-button {
    padding-top: 50px;
  }
  .image-beneficiaries {
    width: 60%;
  }
  .position {
    width: 50%;
    display: block;
    margin: auto;
  }
  .confirmation-text {
    margin-top: -20px;
    line-height: 25px;
  }
  .confirmation-button {
    display: block;
    margin: auto;
    margin-top: 20px;
  }
</style>

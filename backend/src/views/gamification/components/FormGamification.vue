<template>
  <div name="release-management-form">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload
          type="gamification_photo"
          :initial-url="gamification.cover_path"
          :list-information="[this.$t('label.maximum-dimension-image'), this.$t('label.maximum-size-image')]"
          style="margin-bottom: 25px"
          @onUpload="photoUploaded"
        />
      </el-col>
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="gamification" :rules="rules" :status-icon="true" label-width="210px">

          <el-form-item :label="$t('label.gamification-title-mision')" :prop="validateTitle">
            <el-input
              v-model="gamification.title"
              type="text"
              name="title"
              placeholder="Judul Misi"
            />
          </el-form-item>

          <el-form-item :label="$t('label.gamification-title-fitur')">
            <el-select v-model="gamification.nama_fitur" :placeholder="$t('label.gamification-title-fitur')" name="fitur">
              <el-option :label="$t('route.news-manage')" value="news" />
              <el-option :label="$t('route.post-manage')" value="postrw" />
            </el-select>
          </el-form-item>

          <el-form-item class="waktu-publikasi" :label="$t('label.gamification-date-mision')" :prop="validateStartDate">
            <el-row :gutter="12" type="flex">
              <el-col :xs="12" :sm="8" :lg="12">
                <el-date-picker
                  v-model="gamification.start_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd HH:mm:ss"
                  value-format="yyyy-MM-dd HH:mm:ss"
                  :picker-options="dateStartDateOptions"
                  :placeholder="$t('popup.popup-start-date')"
                />
              </el-col>
              <el-col :xs="12" :sm="8" :lg="12">
                <el-date-picker
                  v-model="gamification.end_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd HH:mm:ss"
                  value-format="yyyy-MM-dd HH:mm:ss"
                  :picker-options="dateEndDateOptions"
                  :placeholder="$t('popup.popup-end-date')"
                />
              </el-col>
            </el-row>
          </el-form-item>

          <el-form-item :label="$t('label.gamification-name-reward')" :prop="validateNamaPenghargaan">
            <el-input
              v-model="gamification.nama_penghargaan"
              type="text"
              name="nama_penghargaan"
              placeholder="Nama Penghargaan"
            />
          </el-form-item>

          <el-form-item :label="$t('label.gamification-amount-hit')">
            <el-input-number
              v-model="gamification.jumlah_hit"
              :min="0"
              :max="100"
              name="jumlah_hit"
              placeholder="Jumlah Hit"
            />
          </el-form-item>

          <el-form-item :label="$t('label.gamification-description-mision')" :prop="validateDeskripsi">
            <el-input
              v-model="gamification.deskripsi"
              type="textarea"
              :autosize="{ minRows: 2, maxRows: 4}"
              name="deskripsi"
              placeholder="Deskripsi Misi"
            />
          </el-form-item>

          <el-form-item style="margin-top:50px">
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-gamification') }}</el-button>

            <router-link :to="'/gamification/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { containsWhitespace } from '@/utils/validate'
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'

const moment = require('moment')
moment().format()

export default {
  components: {
    AttachmentPhotoUpload
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTextWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Teks yang diisi tidak valid.'))
      }

      callback()
    }

    return {
      gamification: {
        title: null,
        nama_fitur: null,
        nama_penghargaan: null,
        jumlah_hit: 0,
        cover_path: null,
        deskripsi: null,
        start_date: moment().format('YYYY-MM-DD HH:mm:ss'),
        end_date: moment().add(1, 'days').format('YYYY-MM-DD HH:mm:ss')
      },
      loading: false,
      validateTitle: 'title',
      validateStartDate: 'start_date',
      validateNamaPenghargaan: 'nama_penghargaan',
      validateDeskripsi: 'deskripsi',
      rules: {
        title: [
          { required: true, message: this.$t('errors.gamification-title-must-be-filled'), trigger: 'blur' },
          { validator: validatorTextWhitespace, trigger: 'blur' }
        ],
        nama_penghargaan: [
          { required: true, message: this.$t('errors.gamification-name-must-be-filled'), trigger: 'blur' },
          { validator: validatorTextWhitespace, trigger: 'blur' }
        ],
        deskripsi: [
          { required: true, message: this.$t('errors.gamification-deskripsi-must-be-filled'), trigger: 'blur' },
          { validator: validatorTextWhitespace, trigger: 'blur' }
        ],
        errorTitle: [
          { required: true, message: this.$t('errors.gamification-title-already-used'), trigger: 'change' }
        ]
      },
      dateStartDateOptions: {
        disabledDate: this.disabledStartDate
      },
      dateEndDateOptions: {
        disabledDate: this.disabledEndDate
      }
    }
  },
  computed: {
  },
  mounted() {

  },
  methods: {
    disabledStartDate(time) {
      const dateTime = moment().format('YYYY-MM-DD 00:00:00')
      const parseDateTime = Date.parse(dateTime)
      return time.getTime() < parseDateTime
    },
    photoUploaded(path, url) {
      this.form.cover_path = path
    },
    disabledEndDate(time) {
      const startDateTime = moment(this.form.start_date).format('YYYY-MM-DD 00:00:00')
      const parseDateTime = Date.parse(startDateTime)
      return time.getTime() < parseDateTime
    },

    async submitForm() {
      const valid = await this.$refs.form.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true
        const data = {}
        Object.assign(data, this.gamification)
        if (this.isEdit) {
          // const id = this.$route.params && this.$route.params.id
          // await update(id, data)
          this.$message.success(this.$t('crud.update-success'))
          this.$router.push('/gamification/index')
        } else {
          // await create(data)
          this.$message.success(this.$t('crud.gamification-send-success'))
          this.$router.push('/gamification/index')
        }
      } catch (e) {
        const data = e.response.data.data
        for (const x in data) {
          if (String(x) === 'image_path') {
            this.$message.error(this.$t('errors.popup-image-null'))
          } else {
            this.$message.error(data[String(x)][0])
          }
        }
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

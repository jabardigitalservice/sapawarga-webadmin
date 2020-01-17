<template>
  <div name="release-management-form">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="24" :lg="24">
        <el-form ref="form" :model="gamification" :rules="rules" :status-icon="true" :label-width="device==='desktop'?'160px':'120px'">

          <el-form-item :label="$t('label.gamification-title-mision')" :prop="validateTitle">
            <el-input
              v-model="gamification.title"
              type="text"
              name="title"
              placeholder="Judul Misi"
            />
          </el-form-item>

          <el-form-item :label="$t('label.gamification-title-fitur')" prop="nama_fitur">
            <el-select v-model="gamification.nama_fitur" :placeholder="$t('label.gamification-title-fitur')" name="fitur">
              <el-option :label="$t('route.news-manage')" value="news" />
              <el-option :label="$t('route.post-manage')" value="postrw" />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('label.gamification-action-fitur')" prop="action_fitur">
            <el-select v-model="gamification.action_fitur" :placeholder="$t('label.gamification-action-fitur')" name="action_fitur">
              <el-option :label="$t('label.views-news')" value="views_news" />
              <el-option :label="$t('label.post-activities-rw')" value="post_rw" />
            </el-select>
          </el-form-item>

          <el-row :gutter="20">
            <el-col :xs="24" :sm="12" :lg="12">
              <el-form-item :label="$t('popup.popup-start-date')" :prop="validateStartDate">
                <el-date-picker
                  v-model="gamification.start_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd HH:mm:ss"
                  value-format="yyyy-MM-dd HH:mm:ss"
                  :picker-options="dateStartDateOptions"
                  :placeholder="$t('popup.popup-start-date')"
                />
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="12" :lg="12">
              <el-form-item :label="$t('popup.popup-end-date')" :prop="validateStartDate">
                <el-date-picker
                  v-model="gamification.end_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd HH:mm:ss"
                  value-format="yyyy-MM-dd HH:mm:ss"
                  :picker-options="dateEndDateOptions"
                  :placeholder="$t('popup.popup-end-date')"
                />
              </el-form-item>
            </el-col>
          </el-row>
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

          <el-row :gutter="20">
            <el-col :xs="24" :sm="12" :lg="12">
              <el-form-item :label="$t('label.gamification-name-reward')" :prop="validateNamaPenghargaan">
                <el-input
                  v-model="gamification.nama_penghargaan"
                  type="text"
                  name="nama_penghargaan"
                  placeholder="Nama Penghargaan"
                />
              </el-form-item>
            </el-col>

            <el-col :xs="24" :sm="12" :lg="12">
              <el-form-item label="Upload Badge" :prop="validateNamaPenghargaan">
                <AttachmentFileUpload
                  type="popup_photo"
                  :limit-file="1"
                  @onUpload="photoUploaded"
                />
              </el-form-item>
            </el-col>
          </el-row>

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
import { mapGetters } from 'vuex'
import { containsWhitespace, isContainHtmlTags } from '@/utils/validate'
import AttachmentFileUpload from '@/components/AttachmentFileUpload'

const moment = require('moment')
moment().format()

export default {
  components: {
    AttachmentFileUpload
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

    const validatorHTMLTitle = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('errors.gamification-informasi-title')))
      }

      callback()
    }

    const validatorHTMLDescription = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('errors.description-not-valid-characters')))
      }

      callback()
    }

    const validatorHTMLPenghargaan = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('errors.gamification-name-reward-not-valid-characters')))
      }

      callback()
    }

    return {
      gamification: {
        title: null,
        nama_fitur: null,
        action_fitur: null,
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
          {
            required: true,
            message: this.$t('errors.gamification-title-must-be-filled'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('errors.gamification-title-min-10'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('errors.gamification-title-max-100'),
            trigger: 'blur'
          },
          {
            validator: validatorHTMLTitle,
            trigger: 'blur'
          },
          {
            validator: validatorTextWhitespace,
            trigger: 'blur'
          }
        ],
        nama_penghargaan: [
          {
            required: true,
            message: this.$t('errors.gamification-name-reward-must-be-filled'),
            trigger: 'blur'
          },
          {
            validator: validatorTextWhitespace,
            trigger: 'blur'
          },
          {
            validator: validatorHTMLPenghargaan,
            trigger: 'blur'
          }
        ],
        start_date: [
          { required: true, message: 'Target harus diisi', trigger: 'blur' }
        ],
        end_date: [
          { required: true, message: 'Target harus diisi', trigger: 'blur' }
        ],
        deskripsi: [
          {
            required: true,
            message: this.$t('errors.gamification-deskripsi-must-be-filled'),
            trigger: 'blur'
          },
          {
            validator: validatorHTMLDescription,
            trigger: 'blur'
          }
        ],
        nama_fitur: [
          { required: true, message: 'Target harus diisi', trigger: 'change' }
        ],
        action_fitur: [
          { required: true, message: 'Target harus diisi', trigger: 'change' }
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
    ...mapGetters([
      'device'
    ])
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
      this.gamification.cover_path = path
    },
    disabledEndDate(time) {
      const startDateTime = moment(this.gamification.start_date).format('YYYY-MM-DD 00:00:00')
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

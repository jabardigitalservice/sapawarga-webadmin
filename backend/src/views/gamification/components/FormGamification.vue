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
              :placeholder="$t('label.gamification-title-mision')"
            />
          </el-form-item>

          <el-form-item :label="$t('label.gamification-title-fitur')" prop="object_type">
            <el-select v-model="gamification.object_type" :placeholder="$t('label.gamification-title-fitur')" name="fitur">
              <el-option :label="$t('route.news-manage')" value="news" />
              <el-option :label="$t('route.post-manage')" value="user_post" />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('label.gamification-action-fitur')" prop="object_event">
            <el-select v-model="gamification.object_event" :placeholder="$t('label.gamification-action-fitur')" name="action_fitur">
              <el-option :label="$t('label.views-news')" value="news_view_detail" />
              <el-option :label="$t('label.post-activities-rw')" value="user_post_create" />
            </el-select>
          </el-form-item>

          <el-row :gutter="20">
            <el-col :xs="24" :sm="12" :lg="12">
              <el-form-item :label="$t('label.start-date')" :prop="validateStartDate">
                <el-date-picker
                  v-model="gamification.start_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd "
                  value-format="yyyy-MM-dd"
                  :picker-options="dateStartDateOptions"
                  :placeholder="$t('label.start-date')"
                />
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="12" :lg="12">
              <el-form-item :label="$t('label.end-date')" :prop="validateStartDate">
                <el-date-picker
                  v-model="gamification.end_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd"
                  value-format="yyyy-MM-dd"
                  :picker-options="dateEndDateOptions"
                  :placeholder="$t('label.end-date')"
                />
              </el-form-item>
            </el-col>
          </el-row>
          <el-form-item :label="$t('label.gamification-amount-hit')">
            <el-input-number
              v-model="gamification.total_hit"
              :min="0"
              :max="100"
              name="total_hit"
              :placeholder="$t('label.gamification-amount-hit')"
            />
          </el-form-item>

          <el-form-item :label="$t('label.gamification-description-mision')" :prop="validateDeskripsi">
            <el-input
              v-model="gamification.description"
              type="textarea"
              :autosize="{ minRows: 2, maxRows: 4}"
              name="description"
              :placeholder="$t('label.gamification-description-mision')"
            />
          </el-form-item>

          <el-row :gutter="20">
            <el-col :xs="24" :sm="12" :lg="12">
              <el-form-item :label="$t('label.gamification-name-reward')" :prop="validateNamaPenghargaan">
                <el-input
                  v-model="gamification.title_badge"
                  type="text"
                  name="title_badge"
                  :placeholder="$t('label.gamification-name-reward')"
                />
              </el-form-item>
            </el-col>

            <el-col :xs="24" :sm="12" :lg="12">
              <el-form-item :label="$t('label.gamification-badge-logo')" :prop="validateImage">
                <AttachmentFileUpload
                  type="banner_photo"
                  :type-file="typeFile"
                  :limit-file="1"
                  :file-path="filepath"
                  :description="$t('label.image-upload-size')"
                  @onUpload="photoUploaded"
                  @onRemove="removeUploaded"
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
import { create, update, fetchRecord } from '@/api/gamification'
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
        callback(new Error(this.$t('errors.text-not-valid')))
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
        object_type: null,
        object_event: null,
        title_badge: null,
        total_hit: 0,
        image_badge_path: null,
        description: null,
        status: 10,
        start_date: moment().format('YYYY-MM-DD'),
        end_date: moment().add(1, 'days').format('YYYY-MM-DD')
      },
      loading: false,
      validateTitle: 'title',
      validateStartDate: 'start_date',
      validateNamaPenghargaan: 'title_badge',
      validateImage: 'image_badge_path',
      validateDeskripsi: 'deskripsi',
      filepath: null,
      typeFile: '.jpg, .jpeg, .png',
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
        title_badge: [
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
          { required: true, message: this.$t('errors.start-date-not-null'), trigger: 'blur' }
        ],
        end_date: [
          { required: true, message: this.$t('errors.end-date-not-null'), trigger: 'blur' }
        ],
        image_badge_path: [
          {
            required: true,
            message: this.$t('errors.logo-badge-not-null'),
            trigger: 'blur'
          }
        ],
        description: [
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
        object_type: [
          { required: true, message: this.$t('errors.gamification-fitur-must-be-filled'), trigger: 'change' }
        ],
        object_event: [
          { required: true, message: this.$t('errors.gamification-action-fitur-must-be-filled'), trigger: 'change' }
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
  async created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      await this.fetchData(id)
    }
  },
  methods: {
    photoUploaded(path, url) {
      this.gamification.image_badge_path = path
    },
    removeUploaded() {
      this.gamification.image_badge_path = null
    },
    disabledStartDate(time) {
      const dateTime = moment().format('YYYY-MM-DD 00:00:00')
      const parseDateTime = Date.parse(dateTime)
      return time.getTime() < parseDateTime
    },
    disabledEndDate(time) {
      const startDateTime = moment(this.gamification.start_date).format('YYYY-MM-DD 00:00:00')
      const parseDateTime = Date.parse(startDateTime)
      return time.getTime() < parseDateTime
    },
    async fetchData(id) {
      try {
        const response = await fetchRecord(id)
        this.gamification = await response.data
        this.filepath = response.data.image_badge_path_url
        this.gamification.image_badge_path = response.data.image_badge_path_url
      } catch (e) {
        const data = e.response.data.data
        for (const x in data) {
          this.$message.error(data[String(x)][0])
        }
      }
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
          const id = this.$route.params && this.$route.params.id
          await update(id, data)
          this.$message.success(this.$t('crud.update-success'))
          this.$router.push('/gamification/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.gamification-send-success'))
          this.$router.push('/gamification/index')
        }
      } catch (e) {
        const data = e.response.data.data
        for (const x in data) {
          if (String(x) === 'image_badge_path_url') {
            this.$message.error(this.$t('errors.image-not-null'))
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

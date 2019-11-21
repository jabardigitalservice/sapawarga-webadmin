<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload
          type="popup_photo"
          :initial-url="popup.image_path_url"
          :list-information="[this.$t('label.maximum-dimension-image'), this.$t('label.maximum-size-image')]"
          style="margin-bottom: 25px"
          @onUpload="photoUploaded"
        />
      </el-col>
      <el-col :xs="24" :sm="13" :lg="16">
        <el-form ref="popup" :model="popup" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item :label="$t('popup.popup-title')" :prop="validateTitle">
            <el-input v-model="popup.title" type="text" name="title" :placeholder="$t('popup.popup-title')" />
          </el-form-item>
          <el-form-item :label="$t('popup.popup-category')" prop="type">
            <el-radio-group v-model="popup.type" name="type">
              <el-radio-button label="external">{{ $t('popup.popup-external') }}</el-radio-button>
              <el-radio-button label="internal">{{ $t('popup.popup-internal') }}</el-radio-button>
            </el-radio-group>
          </el-form-item>

          <div v-if="popup.type === 'external'">
            <el-form-item :label="$t('popup.popup-link')" prop="link_url">
              <el-input v-model="popup.link_url" type="text" name="link_url" :placeholder="$t('popup.popup-url-pop-up')" />
            </el-form-item>
          </div>
          <div v-else>
            <el-form-item :label="$t('popup.popup-fitur')" prop="internal_object_type">
              <el-select v-model="popup.internal_object_type" :placeholder="$t('popup.popup-title')" name="fitur">
                <el-option :label="$t('popup.popup-survey')" value="survey" />
                <el-option :label="$t('popup.popup-polling')" value="polling" />
                <el-option :label="$t('popup.popup-news')" value="news" />
              </el-select>
              <span v-if="popup.internal_object_type !== null">
                <el-button type="success" @click="dialog(popup.internal_object_type)">{{ $t('popup.popup-selection') }}</el-button>
              </span>
            </el-form-item>

            <el-form-item v-if="popup.type === 'internal'" :label="titleFitur" prop="internal_object_name">
              <el-input v-model="popup.internal_object_name" disabled type="text" name="internal_object_name" />
            </el-form-item>
          </div>

          <el-form-item class="waktu-publikasi" :label="$t('popup.popup-time-publish')" :prop="validateStartDate">
            <el-row :gutter="10" type="flex">
              <el-col :span="10">
                <el-date-picker
                  v-model="popup.start_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd HH:mm:ss"
                  value-format="yyyy-MM-dd HH:mm:ss"
                  :picker-options="dateStartDateOptions"
                  :placeholder="$t('popup.popup-start-date')"
                />
              </el-col>
              <el-col :span="10">
                <el-date-picker
                  v-model="popup.end_date"
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
          <el-form-item label="Deskripsi" :prop="validateDescription">
            <el-input
              v-model="popup.description"
              type="textarea"
              :rows="2"
            />
          </el-form-item>
          <el-form-item style="margin-top:50px">
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-popup') }}</el-button>

            <router-link :to="'/popup-informasi/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
    <el-dialog :visible.sync="showDialog" width="70%" :title="titlePopup">
      <Fitur :category="dialogName" @childData="getData" @closeDialog="dialogClose" />
    </el-dialog>
  </div>
</template>

<script>
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'
import { validUrl, isContainHtmlTags } from '@/utils/validate'
import { create, fetchRecord, update } from '@/api/popupInformasi'
import { PopupCategory, PopupFeature } from '@/utils/constantVariabel'
import Fitur from '@/views/banner/components/dialog/fitur'
import { mapGetters } from 'vuex'
const moment = require('moment')
moment().format()

export default {
  components: {
    AttachmentPhotoUpload,
    Fitur
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorUrl = (rule, value, callback) => {
      if (validUrl(value) === false) {
        callback(new Error(this.$t('errors.url-not-valid')))
      }

      callback()
    }

    const validatorHTMLTitle = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('errors.popup-informasi-title')))
      }

      callback()
    }

    const validatorHTMLDescription = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('errors.popup-informasi-description')))
      }

      callback()
    }

    return {
      loading: false,
      popup: {
        title: null,
        image_path_url: null,
        image_path: null,
        status: 10,
        type: 'external',
        link_url: null,
        internal_object_type: null,
        internal_object_id: null,
        internal_object_name: null,
        start_date: moment().format('YYYY-MM-DD HH:mm:ss'),
        end_date: moment().add(1, 'days').format('YYYY-MM-DD HH:mm:ss'),
        description: null
      },
      dialogName: null,
      showDialog: false,
      titleFitur: null,
      titlePopup: null,
      validateTitle: 'title',
      validateStartDate: 'start_date',
      validateDescription: 'description',
      rules: {
        title: [
          {
            required: true,
            message: this.$t('errors.popup-title-not-null'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('errors.popup-title-min-10'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('errors.popup-title-max-100'),
            trigger: 'blur'
          },
          {
            validator: validatorHTMLTitle,
            trigger: 'blur'
          }
        ],
        type: [
          {
            required: true,
            message: this.$t('errors.popup-kategori-not-null'),
            trigger: 'blur'
          }
        ],
        link_url: [
          {
            required: true,
            message: this.$t('errors.popup-url-not-null'),
            trigger: 'blur'
          },
          {
            validator: validatorUrl,
            trigger: 'blur'
          }
        ],
        internal_object_type: [
          {
            required: true,
            message: this.$t('errors.popup-fitur-not-null'),
            trigger: 'change'
          }
        ],
        internal_object_name: [
          {
            required: true,
            message: this.$t('errors.popup-type-name-not-null'),
            trigger: 'change'
          }
        ],
        start_date: [
          {
            required: true,
            message: this.$t('errors.popup-start-date-not-null'),
            trigger: 'blur'
          }
        ],
        end_date: [
          {
            required: true,
            message: this.$t('errors.popup-end-date-not-null'),
            trigger: 'blur'
          }
        ],
        description: [
          {
            required: true,
            message: this.$t('errors.popup-description-not-null'),
            trigger: 'blur'
          },
          {
            validator: validatorHTMLDescription,
            trigger: 'blur'
          }
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
      'user_id'
    ])
  },

  watch: {
    'popup.type'(val) {
      if (this.isEdit) {
        const id = this.$route.params && this.$route.params.id
        if (this.popup.type === PopupCategory.INTERNAL) {
          fetchRecord(id).then(response => {
            if (response.data.internal_object_type !== undefined) {
              this.popup.internal_object_type = response.data.internal_object_type
              this.popup.internal_object_name = response.data.internal_object_name
              this.popup.internal_object_id = response.data.internal_object_id
            } else {
              this.popup.link_url = null
            }
          })
        } else if (this.popup.type === PopupCategory.EXTERNAL) {
          fetchRecord(id).then(response => {
            if (response.data.link_url !== undefined) {
              this.popup.link_url = response.data.link_url
            } else {
              this.popup.internal_object_type = null
              this.popup.internal_object_name = null
              this.popup.internal_object_id = null
            }
          })
        }
      }
      if (this.popup.type === PopupCategory.INTERNAL) {
        this.$refs.popup.model.link_url = ''
      } else if (this.popup.type === PopupCategory.EXTERNAL) {
        this.$refs.popup.model.internal_object_type = null
        this.$refs.popup.model.internal_object_name = null
      }
      this.$refs.popup.clearValidate()
    },

    'popup.internal_object_type'(newVal, oldVal) {
      if (oldVal !== newVal) {
        this.popup.internal_object_id = null
      }

      if (this.popup.internal_object_type === PopupFeature.SURVEY) {
        this.titleFitur = 'Judul Survei'
        this.titlePopup = 'Daftar Survei'
        this.popup.internal_object_name = ' '
      } else if (this.popup.internal_object_type === PopupFeature.POLLING) {
        this.titleFitur = 'Judul Polling'
        this.titlePopup = 'Daftar Polling'
        this.popup.internal_object_name = ' '
      } else {
        this.titleFitur = 'Judul Berita'
        this.titlePopup = 'Daftar Berita'
        this.popup.internal_object_name = ' '
      }
    }
  },

  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    }
  },
  methods: {
    disabledStartDate(time) {
      const dateTime = moment().format('YYYY-MM-DD 00:00:00')
      const parseDateTime = Date.parse(dateTime)
      return time.getTime() < parseDateTime
    },
    disabledEndDate(time) {
      const startDateTime = moment(this.popup.start_date).format('YYYY-MM-DD 00:00:00')
      const parseDateTime = Date.parse(startDateTime)
      return time.getTime() < parseDateTime
    },
    dialog(id) {
      this.dialogName = id
      this.showDialog = true
    },
    photoUploaded(path, url) {
      this.popup.image_path = path
    },
    getData(value) {
      this.popup.internal_object_name = value.name !== undefined ? value.name : value.title
      this.popup.internal_object_id = value.id
    },
    dialogClose(value) {
      this.showDialog = value
    },
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.popup = response.data

        if (this.popup.created_by !== this.user_id) {
          this.$message.error(this.$t('crud.error-edit-role'))
          this.$router.push('/popup-informasi/index')
        }
      }).catch(err => {
        console.log(err)
      })
    },
    async submitForm() {
      const valid = await this.$refs.popup.validate()
      if (this.popup.internal_object_name === ' ') {
        this.popup.internal_object_name = null
        if (!valid) {
          return
        }
        return
      }

      try {
        this.loading = true
        const data = {}
        Object.assign(data, this.popup)
        if (data.type === PopupCategory.INTERNAL) {
          data.link_url = null
        } else if (data.type === PopupCategory.EXTERNAL) {
          data.internal_object_type = null
          data.internal_object_id = null
          data.internal_object_name = null
        }
        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id
          await update(id, data)
          this.$message.success(this.$t('crud.update-success'))
          this.$router.push('/popup-informasi/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.pop-up-send-success'))
          this.$router.push('/popup-informasi/index')
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
<style>
  .pop-up-date {
    width: 193px !important;
  }
</style>

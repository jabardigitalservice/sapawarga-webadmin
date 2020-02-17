<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload
          type="news_photo"
          :initial-url="news.cover_path_url"
          :list-information="[this.$t('label.maximum-dimension-image'), this.$t('label.maximum-size-image')]"
          style="margin-bottom: 25px"
          @onUpload="photoUploaded"
        />
      </el-col>
      <el-col :xs="24" :sm="16" :lg="19">

        <el-form ref="news" :model="news" :rules="rules" :status-icon="true" :label-width="device==='desktop'?'160px':null" class="form-news">
          <el-form-item :label="$t('news.news-title')" prop="title">
            <el-input v-model="news.title" type="text" :placeholder="$t('news.news-title')" />
          </el-form-item>

          <el-form-item :label="$t('label.source')" prop="channel_id" :label-width="device==='desktop'?'160px':null">
            <el-select v-model="news.channel_id" :placeholder="$t('label.select-source')">
              <el-option
                v-for="item in options"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('label.target')" prop="kabkota_id">
            <el-select v-model="news.kabkota_id" :disabled="checkStaff" :placeholder="$t('label.select-target')">
              <el-option
                v-for="item in area"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('news.news-date')" prop="source_date">
            <el-date-picker
              v-model="news.source_date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              :placeholder="$t('news.news-select-date')"
            />
          </el-form-item>

          <el-form-item v-if="isEdit" :label="$t('label.status')" prop="status">
            <el-select v-model="news.status" :placeholder="$t('label.status-select')">
              <el-option
                v-for="item in statusOptions"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('news.news-url')" prop="source_url">
            <el-input v-model="news.source_url" type="text" :placeholder="$t('news.news-url-sample')" />
          </el-form-item>

          <el-form-item :label="$t('label.push-notification')">
            <el-radio-group v-model="news.is_push_notification" name="notification">
              <el-radio-button label="true">{{ $t('label.true') }}</el-radio-button>
              <el-radio-button label="false">{{ $t('label.false') }}</el-radio-button>
            </el-radio-group>
          </el-form-item>

          <el-form-item :label="$t('label.news-content')" prop="content">
            <div>
              <tinymce v-model="news.content" :height="300" />
            </div>
          </el-form-item>

          <el-form-item class="action-button">
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-news') }}</el-button>

            <router-link :to="'/news/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>

      </el-col>
    </el-row>
  </div>
</template>

<script>
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'
import { containsWhitespace, validUrl } from '@/utils/validate'
import { create, update, newsChannelList } from '@/api/news'
import { RolesUser } from '@/utils/constantVariable'
import checkPermission from '@/utils/permission'
import Tinymce from '@/components/Tinymce'
import { requestArea } from '@/api/staff'
import { mapGetters } from 'vuex'
import newsApi from '@/api/news'
import moment from 'moment'

export default {
  components: { Tinymce, AttachmentPhotoUpload },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('news.news-title-invalid')))
      }
      callback()
    }

    const validatorTitleWhitespaceContent = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('news.news-content-invalid')))
      }
      callback()
    }

    const validatorUrl = (rule, value, callback) => {
      if (validUrl(value) === false) {
        callback(new Error(this.$t('errors.url-not-valid')))
      }

      callback()
    }

    return {
      loading: false,
      RolesUser,
      news: {
        title: null,
        channel_id: null,
        source_date: moment().startOf('day'),
        source_url: null,
        content: null,
        cover_path: null,
        cover_path_url: null,
        status: null,
        kabkota_id: null,
        is_push_notification: true
      },
      checkStaff: false,
      area: null,
      listQueryChannel: {
        limit: false
      },
      options: null,
      statusOptions: [
        { value: 10, label: this.$t('label.active') },
        { value: 0, label: this.$t('label.inactive') }
      ],
      rules: {
        title: [
          {
            required: true,
            message: this.$t('news.news-title-required'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('news.news-title-min'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('news.news-title-max'),
            trigger: 'blur'
          },
          {
            validator: validatorTitleWhitespace,
            trigger: 'blur'
          }
        ],
        channel_id: [
          {
            required: true,
            message: this.$t('news.news-source-required'),
            trigger: 'change'
          }
        ],
        source_date: [
          {
            required: true,
            message: this.$t('news.news-date-required'),
            trigger: 'change'
          }
        ],
        source_url: [
          {
            required: true,
            message: this.$t('news.news-url-required'),
            trigger: 'blur'
          },
          {
            validator: validatorUrl,
            trigger: 'blur'
          }
        ],
        content: [
          {
            required: true,
            message: this.$t('news.news-content-required'),
            trigger: 'blur'
          },
          {
            validator: validatorTitleWhitespaceContent,
            trigger: 'blur'
          }
        ],
        status: [
          {
            required: true,
            message: this.$t('news.news-status-required'),
            trigger: 'blur'
          }
        ],
        kabkota_id: [
          {
            required: true,
            message: this.$t('news.news-target-required'),
            trigger: 'change'
          }
        ]
      }
    }
  },
  computed: {
    ...mapGetters([
      'user_id',
      'device'
    ])
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    }
    this.getNewsChannel()
    this.init()
  },
  methods: {
    init() {
      const authUser = this.$store.state.user

      this.getArea()

      if (checkPermission([this.RolesUser.STAFFKABKOTA])) {
        this.news.kabkota_id = authUser.kabkota_id
        this.checkStaff = true
      }
    },
    getArea() {
      requestArea().then(response => {
        this.area = response.data.items
        this.area.unshift({ id: 1, name: this.$t('label.area-jabar') })
      })
    },
    fetchData(id) {
      newsApi.fetchRecord(id).then(response => {
        this.news = response.data

        this.news.kabkota_id = this.news.kabkota_id !== null ? this.news.kabkota_id : 1

        if (this.news.created_by !== this.user_id) {
          this.$message.error(this.$t('crud.error-edit-role'))
          this.$router.push('/news/index')
        } else if (this.news.status === 10) {
          this.$message.error(this.$t('crud.polling-error-edit-published'))
          this.$router.push('/news/index')
        }
      }).catch(err => {
        console.log(err)
      })
    },

    photoUploaded(path, url) {
      this.news.cover_path = path
    },

    async submitForm() {
      const valid = await this.$refs.news.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.news)

        data.kabkota_id = data.kabkota_id !== 1 ? data.kabkota_id : null

        data.source_date = moment(data.source_date).format('YYYY-MM-DD')

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/news/index')
        } else {
          data.status = 0

          await create(data)

          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/news/index')
        }
      } catch (e) {
        const imageError = e.response.data.data[0].field
        if (imageError === 'cover_path') {
          this.$message.error(this.$t('errors.news-image-null'))
        }
      } finally {
        this.loading = false
      }
    },
    getNewsChannel() {
      newsChannelList(this.listQueryChannel).then(response => {
        this.options = response.data.items
      })
    }
  }
}
</script>

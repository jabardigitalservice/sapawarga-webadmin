<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload
          type="banner_photo"
          :initial-url="banner.image_path_url"
          :list-information="[this.$t('label.maximum-dimension-image'), this.$t('label.maximum-size-image')]"
          style="margin-bottom: 25px"
          @onUpload="photoUploaded"
        />
      </el-col>
      <el-col :xs="24" :sm="13" :lg="16">
        <el-form ref="banner" :model="banner" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item :label="$t('label.banner-title')" prop="title">
            <el-input v-model="banner.title" type="text" name="title" :placeholder="$t('label.banner-title')" />
          </el-form-item>
          <el-form-item :label="$t('label.category')" prop="type">
            <el-radio-group v-model="banner.type" name="type">
              <el-radio-button :label="$t('label.external')">{{ $t('label.banner-external') }}</el-radio-button>
              <el-radio-button :label="$t('label.internal')">{{ $t('label.banner-internal') }}</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item v-if="banner.type === $t('label.external')" :label="$t('label.url')" prop="link_url">
            <el-input v-model="banner.link_url" type="text" name="link_url" :placeholder="$t('label.banner-url')" />
          </el-form-item>
          <el-form-item v-else :label="$t('label.banner-feature')" prop="internal_category">
            <el-select v-model="banner.internal_category" :placeholder="$t('label.banner-feature-select')" name="fitur">
              <el-option :label="$t('label.banner-survey')" value="survey" />
              <el-option :label="$t('label.banner-polling')" value="polling" />
              <el-option :label="$t('label.banner-news')" value="news" />
              <el-option :label="$t('label.banner-newsImportant')" value="news-important" />
            </el-select>
            <span v-if="banner.internal_category !== null">
              <el-button type="success" @click="dialog(banner.internal_category)">{{ $t('label.banner-options') }}</el-button>
            </span>
          </el-form-item>
          <el-form-item v-if="banner.type === $t('label.internal')" :label="titleFitur" prop="internal_entity_name">
            <el-input v-model="banner.internal_entity_name" disabled type="text" name="internal_entity_name" />
          </el-form-item>
          <el-form-item :label="$t('label.status')" prop="status">
            <el-radio-group v-model="banner.status" :fill="statusColor" name="status">
              <el-radio-button :label="0">{{ $t('label.inactive') }}</el-radio-button>
              <el-radio-button :label="10">{{ $t('label.active') }}</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item style="margin-top:50px">
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-banner') }}</el-button>

            <router-link :to="'/banner/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
    <el-dialog :visible.sync="showDialog" width="70%" :title="titlePopup">
      <Feature :category="dialogName" @childData="getData" @closeDialog="dialogClose" />
    </el-dialog>
  </div>
</template>

<script>
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'
import { PopupCategory, PopupFeature } from '@/utils/constantVariable'
import { create, fetchRecord, update } from '@/api/banner'
import { validUrl } from '@/utils/validate'
import Feature from './dialog/feature'
import { mapGetters } from 'vuex'

export default {
  components: {
    AttachmentPhotoUpload,
    Feature
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

    return {
      loading: false,
      banner: {
        title: null,
        image_path_url: null,
        image_path: null,
        type: PopupCategory.EXTERNAL,
        link_url: null,
        internal_category: null,
        internal_entity_id: null,
        internal_entity_name: null,
        status: 0
      },
      dialogName: null,
      showDialog: false,
      statusColor: '#F56C6C',
      titleFitur: null,
      titlePopup: null,
      rules: {
        title: [
          {
            required: true,
            message: this.$t('message.banner-title-required'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('message.banner-title-min'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('message.banner-title-max'),
            trigger: 'blur'
          }
        ],
        type: [
          {
            required: true,
            message: this.$t('message.category'),
            trigger: 'blur'
          }
        ],
        link_url: [
          {
            required: true,
            message: this.$t('message.banner-url-required'),
            trigger: 'blur'
          }
          // {
          //   validator: validatorUrl,
          //   trigger: 'blur'
          // }
        ],
        status: [
          {
            required: true,
            message: this.$t('message.banner-status-required'),
            trigger: 'blur'
          }
        ],
        internal_category: [
          {
            required: true,
            message: this.$t('message.banner-feature-required'),
            trigger: 'blur'
          }
        ],
        internal_entity_name: [
          {
            required: true,
            message: this.$t('message.banner-feature-title-required'),
            trigger: 'blur'
          }
        ]
      }
    }
  },

  computed: {
    ...mapGetters([
      'user_id'
    ])
  },

  watch: {
    'banner.type'(val) {
      if (this.banner.type === PopupCategory.INTERNAL) {
        this.banner.link_url = null
      } else if (this.banner.type === PopupCategory.EXTERNAL) {
        this.banner.internal_category = null
        this.banner.internal_entity_name = null
        this.banner.internal_entity_id = null
      }
    },

    'banner.status'() {
      this.banner.status === 10 ? this.statusColor = '#67C23A' : this.statusColor = '#F56C6C'
    },

    'banner.internal_category'(newVal, oldVal) {
      if (oldVal === null) {
        this.banner.internal_entity_name
        this.banner.internal_entity_id
      } else if (oldVal !== newVal) {
        this.banner.internal_entity_name = null
        this.banner.internal_entity_id = null
      }

      if (this.banner.internal_category === PopupFeature.SURVEY) {
        this.titleFitur = this.$t('label.survey-title')
        this.titlePopup = this.$t('label.survey-list')
      } else if (this.banner.internal_category === PopupFeature.POLLING) {
        this.titleFitur = this.$t('label.polling-title')
        this.titlePopup = this.$t('label.polling-list')
      } else if (this.banner.internal_category === PopupFeature.NEWS) {
        this.titleFitur = this.$t('news.news-title')
        this.titlePopup = this.$t('news.news-list')
      } else {
        this.titleFitur = this.$t('label.newsImportant-title')
        this.titlePopup = this.$t('label.newsImportant-list')
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
    dialog(id) {
      this.dialogName = id
      this.showDialog = true
    },
    photoUploaded(path, url) {
      this.banner.image_path = path
    },
    getData(value) {
      this.banner.internal_entity_name = value.name !== undefined ? value.name : value.title
      this.banner.internal_entity_id = value.id
    },
    dialogClose(value) {
      this.showDialog = value
    },
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.banner = response.data

        if (this.banner.created_by !== this.user_id) {
          this.$message.error(this.$t('crud.error-edit-role'))
          this.$router.push('/banner/index')
        } else if (this.banner.status === 10) {
          this.$message.error(this.$t('crud.banner-error-edit-published'))
          this.$router.push('/banner/index')
        }
      }).catch(err => {
        console.log(err)
      })
    },
    async submitForm() {
      const valid = await this.$refs.banner.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true
        const data = {}
        Object.assign(data, this.banner)
        if (data.type === PopupCategory.INTERNAL) {
          data.link_url = null
        } else if (data.type === PopupCategory.EXTERNAL) {
          data.internal_category = null
          data.internal_entity_id = null
          data.internal_entity_name = null
        }
        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id
          await update(id, data)
          this.$message.success(this.$t('crud.update-success'))
          this.$router.push('/banner/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.send-success'))
          this.$router.push('/banner/index')
        }
      } catch (e) {
        const imageError = e.response.data.data[0].field
        console.log(imageError)
        if (imageError === 'image_path') {
          this.$message.error(this.$t('errors.banner-image-null'))
        }
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

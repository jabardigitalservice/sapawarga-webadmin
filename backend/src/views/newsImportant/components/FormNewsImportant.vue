<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload
          type="news_important"
          :initial-url="newsImportant.image_path_url"
          :list-information="[this.$t('label.maximum-dimension-image'), this.$t('label.maximum-size-image')]"
          style="margin-bottom: 25px"
          @onUpload="photoUploaded"
        />
      </el-col>
      <el-col :xs="24" :sm="16" :lg="19">
        <el-form id="newsImportant" ref="newsImportant" :model="newsImportant" :rules="rules" :status-icon="true" label-width="150px" label-position="right">
          <el-form-item :label="$t('label.title')" prop="title">
            <el-input v-model="newsImportant.title" type="text" name="title" :placeholder="$t('label.newsImportant-title')" />
          </el-form-item>
          <el-form-item :label="$t('label.category')" prop="category_id">
            <InputCategory v-model="newsImportant.category_id" category-type="news_important" :prop="$t('label.category')" />
          </el-form-item>
          <el-form-item :label="$t('label.newsImportant-description')" prop="content">
            <div>
              <tinymce v-model="newsImportant.content" :height="250" />
            </div>
          </el-form-item>
          <el-form-item :label="$t('label.url')" prop="source_url">
            <el-input v-model="newsImportant.source_url" type="text" name="link_url" :placeholder="$t('label.newsImportant-url')" />
          </el-form-item>

          <el-form-item :label="$t('label.attachment')">
            <div v-for="(data, index) in newsImportant.attachments" :key="index">
              <AttachmentMultiFile :file-edit="data" :index="index" @onUpload="attachmentFile" @getId="remove" />
            </div>
            <el-button v-if="display" type="text" @click="addAttachment">Tambah Lampiran</el-button>
          </el-form-item>

          <el-form-item>
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-create') }}</el-button>

            <router-link :to="'/news-important/index'">
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
import Tinymce from '@/components/Tinymce'
import InputCategory from '@/components/InputCategory'
import { validUrl, isContainHtmlTags } from '@/utils/validate'
import { create, update, fetchRecord } from '@/api/newsImportant'
import AttachmentMultiFile from '@/components/AttachmentMultiFile'
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'

export default {
  components: { AttachmentPhotoUpload, InputCategory, Tinymce, AttachmentMultiFile },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorHTMLTitle = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('message.newsImportant-title-valid')))
      }

      callback()
    }

    const validatorUrl = (rule, value, callback) => {
      if (validUrl(value) === false) {
        callback(new Error(this.$t('message.newsImportant-url-match')))
      }

      callback()
    }

    return {
      status: {
        INACTIVE: 0,
        ACTIVE: 10
      },
      loading: false,
      file: null,
      display: true,
      newsImportant: {
        title: null,
        category_id: null,
        content: null,
        source_url: null,
        image_path: null,
        image_path_url: null,
        attachments: []
      },
      rules: {
        title: [
          {
            required: true,
            message: this.$t('message.newsImportant-title-required'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('message.newsImportant-title-min'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('message.newsImportant-title-max'),
            trigger: 'blur'
          },
          {
            validator: validatorHTMLTitle,
            trigger: 'blur'
          }
        ],
        category_id: [
          {
            required: true,
            message: this.$t('message.category'),
            trigger: 'change'
          }
        ],
        source_url: [
          {
            required: true,
            message: this.$t('message.newsImportant-title-required'),
            trigger: 'blur'
          },
          {
            validator: validatorHTMLTitle,
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
            message: this.$t('message.newsImportant-title-required'),
            trigger: 'blur'
          },
          {
            max: 65000,
            message: this.$t('message.newsImportant-title-max'),
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
    'newsImportant.attachments'() {
      this.checkAttachmentLength()
    }
  },

  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    }
  },

  methods: {
    photoUploaded(path, url) {
      this.newsImportant.image_path = path
    },
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.newsImportant = response.data

        if (this.newsImportant.created_by !== this.user_id) {
          this.$message.error(this.$t('crud.error-edit-role'))
          this.$router.push('/news-important/index')
        } else if (this.newsImportant.status === this.status.ACTIVE) {
          this.$message.error(this.$t('crud.newsImportant-error-edit-published'))
          this.$router.push('/news-important/index')
        }
      }).catch(error => {
        console.log(error)
      })
    },
    async submitForm() {
      const valid = await this.$refs.newsImportant.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true
        const data = {}
        Object.assign(data, this.newsImportant)
        data.status = this.status.INACTIVE

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id
          await update(id, data)
          this.$message.success(this.$t('crud.update-success'))
          this.$router.push('/news-important/index')
        } else {
          await create(data)
          this.$message.success(this.$t('message.newsImportant-create-success'))
          this.$router.push('/news-important/index')
        }
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    attachmentFile(path, url) {
      this.newsImportant.attachments[this.newsImportant.attachments.length - 1] = {
        'file_path': path
      }
    },
    addAttachment() {
      this.newsImportant.attachments.push({
        'file_path': null
      })
      this.checkAttachmentLength()
    },
    checkAttachmentLength() {
      if (this.newsImportant.attachments) {
        if (this.newsImportant.attachments.length >= 5) {
          this.display = false
        } else {
          this.display = true
        }
      } else {
        this.newsImportant.attachments
      }
    },
    remove(index) {
      this.newsImportant.attachments.splice(index, 1)
    }
  }
}
</script>

<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload
          type="news_photo"
          :initial-url="news.cover_path_url"
          :list-information="[this.$t('label.maximum-dimension-image')]"
          style="margin-bottom: 25px"
          name="news_photo"
          @onUpload="photoUploaded"
        />
      </el-col>
      <el-col :xs="24" :sm="16" :lg="19">

        <el-form ref="news" :model="news" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item :label="$t('label.news-title')" prop="title">
            <el-input v-model="news.title" name="title" type="text" placeholder="Judul Berita" />
          </el-form-item>

          <el-form-item :label="$t('label.category')" prop="category_id">
            <el-select v-model="news.category_id" name="category" placeholder="Pilih Kategori">
              <el-option
                v-for="item in options"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('label.news-content')" prop="content">
            <div>
              <tinymce v-model="news.content" :height="300" name="content" />
            </div>
          </el-form-item>

          <el-form-item>
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-news') }}</el-button>

            <router-link :to="'/news-hoax/index'">
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
import { containsWhitespace, isContainHtmlTags } from '@/utils/validate'
import { fetchRecord, create, update } from '@/api/newsHoax'
import { fetchList } from '@/api/categories'
import Tinymce from '@/components/Tinymce'
import moment from 'moment'
import { mapGetters } from 'vuex'

export default {
  components: { Tinymce, AttachmentPhotoUpload },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorHTMLTitle = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('errors.news-title-not-valid-characters')))
      }

      callback()
    }

    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('errors.news-title-not-valid')))
      }
      callback()
    }

    const validatorTitleWhitespaceContent = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('errors.news-content-not-valid')))
      }
      callback()
    }

    return {
      loading: false,
      options: [],
      news: {
        title: null,
        category_id: null,
        category: null,
        source_date: moment().startOf('day'),
        content: null,
        seq: null,
        status: null
      },
      area: null,
      rules: {
        title: [
          {
            required: true,
            message: this.$t('errors.news-title-not-null'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('errors.news-title-must-be-at-least-10-characters'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('errors.news-title-must-be-at-least-100-characters'),
            trigger: 'blur'
          },
          {
            validator: validatorTitleWhitespace,
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
            message: this.$t('errors.news-category-not-null'),
            trigger: 'change'
          }
        ],
        content: [
          {
            required: true,
            message: this.$t('errors.news-content-not-null'),
            trigger: 'blur'
          },
          {
            validator: validatorTitleWhitespaceContent,
            trigger: 'blur'
          }
        ]
      },
      query: {
        type: 'newsHoax'
      }
    }
  },
  computed: {
    ...mapGetters([
      'user_id'
    ])
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    }
    this.getNewsChannel()
  },
  methods: {
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.news = response.data
        if (this.news.status === 10) {
          this.$message.error(this.$t('crud.error-edit-role'))
          this.$router.push('/news-hoax/index')
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
        data.source_date = moment(data.source_date).format('YYYY-MM-DD')

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id
          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/news-hoax/index')
        } else {
          data.status = 0
          await create(data)

          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/news-hoax/index')
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
      fetchList(this.query).then(response => {
        this.options = response.data.items
      })
    }
  }
}
</script>

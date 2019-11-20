<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="210px">

          <el-form-item :label="$t('route.news-channels-manage')" :prop="validateName">
            <el-input v-model="form.name" type="text" placeholder="Sumber Berita" @focus="changePropName" />
          </el-form-item>

          <el-form-item :label="$t('label.link-logo-news-channels-manage')" prop="icon_url">
            <el-input v-model="form.icon_url" type="text" placeholder="http://www" />
          </el-form-item>

          <el-form-item :label="$t('label.link')" :prop="validateWebsite">
            <el-input v-model="form.website" type="text" placeholder="http://www" @focus="changePropWebsite" />
          </el-form-item>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitProcess">{{ $t('crud.save-publish') }}</el-button>

            <router-link :to="'/news-channels/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, create } from '@/api/newsChannels'
import { containsWhitespace, validUrl } from '@/utils/validate'

const defaultForm = {
  name: null,
  website: null,
  icon_url: null,
  status: 10
}

export default {
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

    const validatorUrl = (rule, value, callback) => {
      if (validUrl(value) === false) {
        callback(new Error(this.$t('errors.url-not-null')))
      }

      callback()
    }

    return {
      form: Object.assign({}, defaultForm),
      loading: false,
      validateWebsite: 'website',
      validateName: 'name',
      rules: {
        name: [
          { required: true, message: this.$t('errors.news-channels-must-be-filled'), trigger: 'blur' },
          { min: 5, message: this.$t('errors.news-channels-must-be-at-least-5-characters'), trigger: 'blur' },
          { max: 25, message: this.$t('errors.news-channels-must-be-at-least-25-characters'), trigger: 'blur' },
          { validator: validatorTextWhitespace, trigger: 'blur' }
        ],
        errorName: [
          { required: true, message: this.$t('errors.news-channels-already-used'), trigger: 'change' }
        ],
        website: [
          { required: true, message: this.$t('errors.url-not-null'), trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ],
        errorWebsite: [
          { required: true, message: this.$t('errors.website-news-channels-already-used'), trigger: 'change' }
        ],
        icon_url: [
          { required: true, message: this.$t('errors.url-not-null'), trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ]
      }
    }
  },
  mounted() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    } else {
      this.form = Object.assign({}, defaultForm)
    }
  },
  methods: {
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.form = response.data
      }).catch(err => console.log(err))
    },

    async submitProcess() {
      const valid = await this.$refs.form.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.form)

        await create(data)

        this.$message.success(this.$t('crud.create-success'))
        this.$router.push('/news-channels/index')
      } catch (error) {
        const messageApi = error.response.data.data
        const messageList = []
        let messageJoin = null

        messageApi.forEach(element => {
          messageList.push(element.message)
          messageJoin = messageList.join(' Dan ')
        })
        this.$message.error(this.$t(messageJoin))

        if (messageApi[0].field === 'name' && messageApi[1].field === 'website') {
          this.form.name = null
          this.form.website = null
          this.validateName = 'errorName'
          this.validateWebsite = 'errorWebsite'
        } else if (messageApi[0].field === 'website') {
          this.form.website = null
          this.validateWebsite = 'errorWebsite'
        } else if (messageApi[0].field === 'name') {
          this.form.name = null
          this.validateName = 'errorName'
        }
      } finally {
        this.loading = false
      }
    },
    changePropName() {
      if (this.validateName === 'errorName') {
        this.validateName = 'name'
      } else {
        this.validateName = 'name'
      }
    },
    changePropWebsite() {
      if (this.validateWebsite === 'errorWebsite') {
        this.validateWebsite = 'website'
      } else {
        this.validateWebsite = 'website'
      }
    }

  }
}
</script>

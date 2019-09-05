<template>
  <div name="release-management-form">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="210px">

          <el-form-item label="Version" :prop="validateVersion">
            <el-input v-model="form.version" v-mask="'#.#.#'" type="text" name="version" placeholder="Version (0.0.0)" @focus="changePropVersion" />
          </el-form-item>

          <el-form-item label="Force Update" prop="force_update" name="force_update">
            <el-radio-group v-model="form.force_update">
              <el-radio :label="true">Ya</el-radio>
              <el-radio :label="false">Tidak</el-radio>
            </el-radio-group>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitProcess">
              <span v-if="isEdit === true">{{ $t('crud.save-update') }}</span>
              <span v-else>{{ $t('crud.save-create') }}</span>
            </el-button>
            <router-link :to="'/release-management/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, update, create } from '@/api/releaseManagement'
import { containsWhitespace } from '@/utils/validate'

const defaultForm = {
  version: null,
  force_update: null
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
        callback(new Error('Teks yang diisi tidak valid.'))
      }

      callback()
    }

    return {
      form: Object.assign({}, defaultForm),
      loading: false,
      validateVersion: 'version',
      rules: {
        version: [
          { required: true, message: 'Version harus diisi.', trigger: 'blur' },
          { validator: validatorTextWhitespace, trigger: 'blur' }
        ],
        errorVersion: [
          { required: true, message: 'Version sudah digunakan', trigger: 'change' }
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

        if (this.isEdit) {
          // TODO: edit
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))
          this.$router.push('/release-management/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/release-management/index')
        }
      } catch (error) {
        const messageApi = error.response.data.data
        const messageList = []
        let messageJoin = null

        messageApi.forEach(element => {
          messageList.push(element.message)
          messageJoin = messageList.join(' Dan ')
        })
        this.$message.error(this.$t(messageJoin))

        if (messageApi[0].field === 'version') {
          this.form.version = null
          this.validateVersion = 'errorVersion'
        }
      } finally {
        this.loading = false
      }
    },
    changePropVersion() {
      if (this.validateVersion === 'errorVersion') {
        this.validateVersion = 'version'
      } else {
        this.validateVersion = 'version'
      }
    }

  }
}
</script>

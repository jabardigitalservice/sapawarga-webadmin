<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="160px">

          <el-form-item label="Nama Kategori" :prop="validateName">
            <el-input v-model="form.name" type="text" placeholder="Nama Kategori" @focus="changePropName" />
          </el-form-item>

          <div v-if="isSaberHoax">
            <el-form-item label="Fitur">
              <el-input type="text" placeholder="Berita Saber Hoaks" disabled />
            </el-form-item>
          </div>
          <div v-else>
            <el-form-item label="Fitur" prop="type">
              <el-select v-model="form.type" placeholder="Pilih Fitur">
                <el-option
                  v-for="item in optionType"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                />
              </el-select>
            </el-form-item>
          </div>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitProcess">
              <span v-if="isEdit === true">{{ $t('crud.save-update') }}</span>
              <span v-else>{{ $t('crud.save-publish') }}</span>
            </el-button>
            <router-link :to="'/categories/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, create, update, fetchTypes } from '@/api/categories'
import { containsWhitespace } from '@/utils/validate'
import checkPermission from '@/utils/permission'
import permission from '@/directive/permission/index.js'

const defaultForm = {
  name: null,
  type: null,
  status: 10
}

export default {
  directives: { permission },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Nama kategori yang diisi tidak valid.'))
      }

      callback()
    }

    return {
      form: Object.assign({}, defaultForm),
      loading: false,
      isSaberHoax: false,
      validateName: 'name',
      rules: {
        name: [
          { required: true, message: 'Nama kategori harus diisi.', trigger: 'blur' },
          { min: 4, message: 'Nama kategori minimal 4 karakter', trigger: 'blur' },
          { max: 25, message: 'Nama kategori maksimal 25 karakter', trigger: 'blur' },
          { validator: validatorTitleWhitespace, trigger: 'blur' }
        ],
        type: [
          { required: true, message: 'Fitur harus diisi.', trigger: 'change' }
        ],
        errorName: [
          { required: true, message: 'Nama kategori sudah digunakan', trigger: 'change' }
        ]
      },
      listQuery: {
        type: null
      },
      tempRoute: {},
      optionType: []
    }
  },
  mounted() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    } else {
      this.form = Object.assign({}, defaultForm)
    }
    if (checkPermission(['staffSaberhoax'])) {
      this.isSaberHoax = true
    }
    if (!checkPermission(['staffSaberhoax'])) this.fetchDataTypes()
  },
  methods: {
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.form = response.data
      }).catch(err => console.log(err))
    },

    fetchDataTypes() {
      if (checkPermission(['staffSaberhoax'])) {
        this.listQuery['type'] = 'newsHoax'
      }
      fetchTypes(this.listQuery).then(response => {
        const { data } = response
        this.optionType = data.items.map(item => {
          return {
            id: item.id,
            name: item.name
          }
        })
      }).catch(err => console.error(err))
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
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/categories/index')
        } else {
          if (checkPermission(['staffSaberhoax'])) {
            data.type = 'newsHoax'
          }
          await create(data)
          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/categories/index')
        }
      } catch (error) {
        const messageApi = await error.response.data.data
        const messageList = []
        let messageJoin = null
        await Object.keys(messageApi).forEach(element => {
          messageList.push(messageApi[element])
          messageJoin = messageList.join(' Dan ')
        })
        this.$message.error(this.$t(messageJoin))
        if (Object.keys(messageApi)[0] === 'name') {
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
    }
  }
}
</script>

<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <el-form ref="video" :model="video" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item :label="$t('label.video-title')" prop="title">
            <el-input v-model="video.title" type="text" name="title" :placeholder="$t('label.video-title')" />
          </el-form-item>

          <el-form-item :label="$t('label.category')" prop="category_id">
            <InputCategory v-model="video.category_id" name="category_id" category-type="video" prop="category" style="width: 100%" />
          </el-form-item>

          <el-form-item :label="$t('label.target')" prop="kabkota_id">
            <el-select v-model="video.kabkota_id" :disabled="checkStaff" :placeholder="$t('label.select-target')">
              <el-option
                v-for="item in area"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('label.source')" prop="source">
            <el-select v-model="video.source" name="source" disabled :placeholder="$t('label.select-source')" />
          </el-form-item>

          <el-form-item :label="$t('label.video-set-priority')" prop="seq">
            <el-select v-model="video.seq" filterable :placeholder="$t('label.video-select-priority')">
              <el-option
                v-for="item in priorityOptions"
                :key="item.id"
                :value="item.value"
                :label="item.label"
              />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('label.push-notification')">
            <el-radio-group v-model="video.is_push_notification" name="notification">
              <el-radio-button label="true">{{ $t('label.true') }}</el-radio-button>
              <el-radio-button label="false">{{ $t('label.false') }}</el-radio-button>
            </el-radio-group>
          </el-form-item>

          <el-form-item :label="$t('label.video-url')" prop="video_url">
            <el-input v-model="video.video_url" type="text" name="video_url" :placeholder="$t('label.video-url-sample')" />
          </el-form-item>

          <el-form-item>
            <el-button v-if="isEdit" type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-update') }}</el-button>
            <el-button v-else type="primary" :loading="loading" @click="submitForm">{{ $t('crud.save-video') }}</el-button>

            <router-link :to="'/video/index'">
              <el-button type="info">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>

import { containsWhitespace, isValidYoutubeUrl } from '@/utils/validate'
import { create, update, fetchRecord } from '@/api/video'
import InputCategory from '@/components/InputCategory'
import { RolesUser } from '@/utils/constantVariable'
import checkPermission from '@/utils/permission'
import { requestArea } from '@/api/staff'
import { mapGetters } from 'vuex'

export default {
  components: { InputCategory },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('label.video-title-invalid')))
      }
      callback()
    }

    const validatorUrl = (rule, value, callback) => {
      if (isValidYoutubeUrl(value) === false) {
        callback(new Error(this.$t('valid.video-url-invalid')))
      }
      callback()
    }

    return {
      RolesUser,
      loading: false,
      video: {
        title: null,
        category_id: null,
        source: 'youtube',
        video_url: null,
        kabkota_id: null,
        seq: null,
        status: null,
        is_push_notification: true
      },
      checkStaff: false,
      area: null,
      priorityOptions: [
        { label: 1, value: 1 },
        { label: 2, value: 2 },
        { label: 3, value: 3 },
        { label: 4, value: 4 },
        { label: 5, value: 5 }
      ],
      rules: {
        title: [
          { required: true, message: this.$t('label.video-title-required'), trigger: 'blur' },
          { min: 10, message: this.$t('label.video-title-min'), trigger: 'blur' },
          { max: 100, message: this.$t('label.video-title-max'), trigger: 'blur' },
          { validator: validatorTitleWhitespace, trigger: 'blur' }
        ],
        category_id: [
          { required: true, message: this.$t('message.category'), trigger: 'change' }
        ],
        seq: [
          { required: true, message: this.$t('label.video-priority-required'), trigger: 'change' }
        ],
        source: [
          { required: true, message: this.$t('label.video-source-required'), trigger: 'change' }
        ],
        video_url: [
          { required: true, message: this.$t('label.video-url-required'), trigger: 'blur' },
          { validator: validatorUrl, trigger: 'blur' }
        ],
        kabkota_id: [
          { required: true, message: this.$t('label.video-source-required'), trigger: 'change' }
        ]
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
    this.init()
  },

  methods: {
    init() {
      const authUser = this.$store.state.user

      this.getArea()

      if (checkPermission([this.RolesUser.STAFFKABKOTA])) {
        this.video.kabkota_id = authUser.kabkota_id
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
      fetchRecord(id).then(response => {
        this.video = response.data
        if (this.video.kabkota_id === null) {
          this.video.kabkota_id = 1
        }
        if (this.video.created_by !== this.user_id) {
          this.$message.error(this.$t('crud.error-edit-role'))
          this.$router.push('/video/index')
        } else if (this.video.status === 10) {
          this.$message.error(this.$t('crud.video-error-edit-published'))
          this.$router.push('/video/index')
        }
      }).catch(err => {
        console.log(err)
      })
    },
    async submitForm() {
      const valid = await this.$refs.video.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.video)

        if (data.kabkota_id === 1) {
          data.kabkota_id = null
        }

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id
          await update(id, data)
          this.$message.success(this.$t('crud.update-success'))
          this.$router.push('/video/index')
        } else {
          data.status = 0
          await create(data)
          this.$message.success(this.$t('crud.create-success'))
          this.$router.push('/video/index')
        }
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    }

  }
}
</script>

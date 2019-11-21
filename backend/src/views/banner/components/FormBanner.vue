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
          <el-form-item label="Judul Banner" prop="title">
            <el-input v-model="banner.title" type="text" name="title" placeholder="Judul Banner" />
          </el-form-item>
          <el-form-item label="Kategori" prop="type">
            <el-radio-group v-model="banner.type" name="type">
              <el-radio-button label="external">Eksternal</el-radio-button>
              <el-radio-button label="internal">Internal</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item v-if="banner.type === 'external'" label="Tautan" prop="link_url">
            <el-input v-model="banner.link_url" type="text" name="link_url" placeholder="URL Banner" />
          </el-form-item>
          <el-form-item v-else label="Fitur" prop="internal_category">
            <el-select v-model="banner.internal_category" placeholder="Pilih Kategori" name="fitur">
              <el-option label="Survei" value="survey" />
              <el-option label="Polling" value="polling" />
              <el-option label="Berita" value="news" />
            </el-select>
            <span v-if="banner.internal_category !== null">
              <el-button type="success" @click="dialog(banner.internal_category)">Pilihan</el-button>
            </span>
          </el-form-item>
          <el-form-item v-if="banner.type === 'internal'" :label="titleFitur" prop="internal_entity_name">
            <el-input v-model="banner.internal_entity_name" disabled type="text" name="internal_entity_name" />
          </el-form-item>
          <el-form-item label="Status" prop="status">
            <el-radio-group v-model="banner.status" :fill="statusColor" name="status">
              <el-radio-button :label="0">Tidak Aktif</el-radio-button>
              <el-radio-button :label="10">Aktif</el-radio-button>
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
      <Fitur :category="dialogName" @childData="getData" @closeDialog="dialogClose" />
    </el-dialog>
  </div>
</template>

<script>
import AttachmentPhotoUpload from '@/components/AttachmentPhotoUpload'
import { validUrl } from '@/utils/validate'
import { create, fetchRecord, update } from '@/api/banner'
import Fitur from './dialog/fitur'
import { mapGetters } from 'vuex'

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
        callback(new Error('URL tidak valid'))
      }

      callback()
    }

    return {
      loading: false,
      banner: {
        title: null,
        image_path_url: null,
        image_path: null,
        type: 'external',
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
            message: 'Judul Banner harus diisi',
            trigger: 'blur'
          },
          {
            min: 10,
            message: 'Judul Banner minimal 10 Karakter',
            trigger: 'blur'
          },
          {
            max: 100,
            message: 'Judul Banner maximal 100 Karakter',
            trigger: 'blur'
          }
        ],
        type: [
          {
            required: true,
            message: 'Kategori Banner harus diisi',
            trigger: 'blur'
          }
        ],
        link_url: [
          {
            required: true,
            message: 'Tautan harus diisi',
            trigger: 'blur'
          },
          {
            validator: validatorUrl,
            trigger: 'blur'
          }
        ],
        status: [
          {
            required: true,
            message: 'Status harus diisi',
            trigger: 'blur'
          }
        ],
        internal_category: [
          {
            required: true,
            message: 'Fitur Banner harus diisi',
            trigger: 'blur'
          }
        ],
        internal_entity_name: [
          {
            required: true,
            message: 'Judul harus diisi',
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
      if (this.banner.type === 'internal') {
        this.banner.link_url = null
      } else if (this.banner.type === 'external') {
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

      if (this.banner.internal_category === 'survey') {
        this.titleFitur = 'Judul Survei'
        this.titlePopup = 'Daftar Survei'
      } else if (this.banner.internal_category === 'polling') {
        this.titleFitur = 'Judul Polling'
        this.titlePopup = 'Daftar Polling'
      } else {
        this.titleFitur = 'Judul Berita'
        this.titlePopup = 'Daftar Berita'
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
        if (data.type === 'internal') {
          data.link_url = null
        } else if (data.type === 'external') {
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

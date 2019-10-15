<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload type="popup_photo" :initial-url="popup.image_path_url" style="margin-bottom: 25px" @onUpload="photoUploaded" />
      </el-col>
      <el-col :xs="24" :sm="13" :lg="16">
        <el-form ref="popup" :model="popup" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item label="Judul Pop Up" prop="title">
            <el-input v-model="popup.title" type="text" name="title" placeholder="Judul Pop Up" />
          </el-form-item>
          <el-form-item label="Kategori" prop="type">
            <el-radio-group v-model="popup.type" name="type">
              <el-radio-button label="external">Eksternal</el-radio-button>
              <el-radio-button label="internal">Internal</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item v-if="popup.type === 'external'" label="Tautan" prop="link_url">
            <el-input v-model="popup.link_url" type="text" name="link_url" placeholder="URL Pop Up" />
          </el-form-item>
          <el-form-item v-else label="Fitur" prop="internal_category">
            <el-select v-model="popup.internal_category" placeholder="Pilih Kategori" name="fitur">
              <el-option label="Survei" value="survey" />
              <el-option label="Polling" value="polling" />
              <el-option label="Berita" value="news" />
            </el-select>
            <span v-if="popup.internal_category !== null">
              <el-button type="success" @click="dialog(popup.internal_category)">Pilihan</el-button>
            </span>
          </el-form-item>
          <el-form-item v-if="popup.type === 'internal'" :label="titleFitur" prop="internal_entity_name">
            <el-input v-model="popup.internal_entity_name" disabled type="text" name="internal_entity_name" />
          </el-form-item>
          <el-form-item label="Tipe Publikasi" prop="type">
            <el-radio-group v-model="popup.type_publish" name="type">
              <el-radio-button label="today">Hari Ini</el-radio-button>
              <el-radio-button label="schedule">Terjadwal</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item prop="start_date">
          <el-row :gutter="10" type="flex">
            <el-col :span="10">
              <span class="demonstration">Tanggal Mulai</span>
              <el-date-picker
                v-model="popup.start_date"
                class="pop-up-date"
                type="datetime"
                placeholder="Pick a start date">
              </el-date-picker>
            </el-col>
            <el-col :span="10">
              <span class="demonstration">Tanggal Berakhir</span>
              <el-date-picker
                v-model="popup.end_date"
                class="pop-up-date"
                type="datetime"
                placeholder="Pick a end date">
              </el-date-picker>
            </el-col>
          </el-row>
          </el-form-item>
          <el-form-item label="Status" prop="status">
            <el-radio-group v-model="popup.status" :fill="statusColor" name="status">
              <el-radio-button :label="0">Tidak Aktif</el-radio-button>
              <el-radio-button :label="10">Aktif</el-radio-button>
            </el-radio-group>
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
import { validUrl } from '@/utils/validate'
import { create, fetchRecord, update } from '@/api/popupInformasi'
import Fitur from '@/views/banner/components/dialog/fitur'
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
      popup: {
        title: null,
        image_path_url: null,
        image_path: null,
        type: 'external',
        link_url: null,
        internal_category: null,
        internal_entity_id: null,
        internal_entity_name: null,
        start_date: null,
        end_date: null,
        type_publish: 'today',
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
            message: 'Judul Pop Up harus diisi',
            trigger: 'blur'
          },
          {
            min: 10,
            message: 'Judul Pop Up minimal 10 Karakter',
            trigger: 'blur'
          },
          {
            max: 100,
            message: 'Judul Pop Up maximal 100 Karakter',
            trigger: 'blur'
          }
        ],
        type: [
          {
            required: true,
            message: 'Kategori Pop Up harus diisi',
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
            message: 'Fitur Pop Up harus diisi',
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
    'popup.type'(val) {
      if (this.popup.type === 'internal') {
        this.popup.link_url = null
      } else if (this.popup.type === 'external') {
        this.popup.internal_category = null
        this.popup.internal_entity_name = null
        this.popup.internal_entity_id = null
      }
    },

    'popup.status'() {
      this.popup.status === 10 ? this.statusColor = '#67C23A' : this.statusColor = '#F56C6C'
    },

    'popup.internal_category'(newVal, oldVal) {
      if (oldVal !== newVal) {
        // this.popup.internal_entity_name = null
        this.popup.internal_entity_id = null
      }

      if (this.popup.internal_category === 'survey') {
        this.titleFitur = 'Judul Survei'
        this.titlePopup = 'Daftar Survei'
      } else if (this.popup.internal_category === 'polling') {
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
      this.popup.image_path = path
    },
    getData(value) {
      this.popup.internal_entity_name = value.name !== undefined ? value.name : value.title
      this.popup.internal_entity_id = value.id
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
        } else if (this.popup.status === 10) {
          this.$message.error(this.$t('crud.popup-error-edit-published'))
          this.$router.push('/popup-informasi/index')
        }
      }).catch(err => {
        console.log(err)
      })
    },
    async submitForm() {
      const valid = await this.$refs.popup.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true
        const data = {}
        Object.assign(data, this.popup)
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
          this.$router.push('/popup-informasi/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.send-success'))
          this.$router.push('/popup-informasi/index')
        }
      } catch (e) {
        const imageError = e.response.data.data[0].field
        console.log(imageError)
        if (imageError === 'image_path') {
          this.$message.error(this.$t('errors.popup-image-null'))
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
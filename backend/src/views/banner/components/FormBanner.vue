<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :xs="24" :sm="8" :lg="5">
        <AttachmentPhotoUpload type="news_photo" :initial-url="banner.cover_path_url" style="margin-bottom: 25px" @onUpload="photoUploaded" />
      </el-col>
      <el-col :xs="24" :sm="13" :lg="16">
        <el-form ref="banner" :model="banner" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item label="Judul Banner" prop="title">
            <el-input v-model="banner.title" type="text" name="title" placeholder="Judul Banner" />
          </el-form-item>
          <el-form-item label="Kategori" prop="category">
            <el-radio-group v-model="banner.type">
              <el-radio-button label="eksternal">Eksternal</el-radio-button>
              <el-radio-button label="internal">Internal</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item v-if="banner.type === 'eksternal'" label="Tautan" prop="type">
            <el-input v-model="banner.internal_category" type="text" name="title" placeholder="URL Banner" />
          </el-form-item>
          <el-form-item v-else label="Fitur" prop="fitur">
            <el-select v-model="banner.internal_entity_id" placeholder="Pilih Kategori">
              <el-option label="Survei" value="survei" />
              <el-option label="Polling" value="polling" />
              <el-option label="Berita" value="berita" />
            </el-select>
            <span v-if="banner.internal_entity_id !== null">
              <el-button type="success" @click="dialog(banner.internal_entity_id)">Pilihan</el-button>
            </span>
          </el-form-item>
          <el-form-item v-if="banner.category_name !== null" :label="titleFitur">
            <el-input v-model="banner.category_name" disabled type="text" name="title" placeholder="Judul Banner" />
          </el-form-item>
          <el-form-item label="Status" prop="status">
            <el-radio-group v-model="banner.status" :fill="statusColor">
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
import Fitur from './dialog/fitur'

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
    return {
      loading: false,
      banner: {
        title: null,
        internal_category: null,
        internal_entity_id: null,
        cover_path: null,
        cover_path_url: null,
        category_id: null,
        category_name: null,
        status: 0,
        type: 'eksternal'
      },
      dialogName: null,
      showDialog: false,
      dialogPolling: false,
      dialogSurvey: false,
      statusColor: '#F56C6C',
      titleFitur: null,
      titlePopup: null,
      rules: {
        title: [
          {
            required: true,
            message: 'Judul Banner harus diisi',
            trigger: 'blur'
          }
        ],
        type: [
          {
            required: true,
            message: 'Tipe Banner harus diisi',
            trigger: 'blur'
          }
        ],
        category: [
          {
            required: true,
            message: 'Kategori Banner harus diisi',
            trigger: 'blur'
          }
        ],
        status: [
          {
            required: true,
            message: 'Status harus diisi',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  watch: {
    'banner.status'() {
      this.banner.status === 10 ? this.statusColor = '#67C23A' : this.statusColor = '#F56C6C'
    },
    'banner.internal_entity_id'() {
      if (this.banner.internal_entity_id === 'survei') {
        this.titleFitur = 'Judul Survei'
        this.titlePopup = 'Daftar Survei'
      } else if (this.banner.internal_entity_id === 'polling') {
        this.titleFitur = 'Judul Polling'
        this.titlePopup = 'Daftar Polling'
      } else {
        this.titleFitur = 'Judul Berita'
        this.titlePopup = 'Daftar Berita'
      }
    }
  },
  methods: {
    dialog(id) {
      this.dialogName = id
      this.showDialog = true
    },
    photoUploaded(path, url) {
      this.banner.cover_path = path
    },
    getData(value) {
      this.banner.category_name = value.name !== undefined ? value.name : value.title
      this.banner.category_id = value.id
    },
    dialogClose(value) {
      this.showDialog = value
      this.dialogPolling = value
      this.dialogSurvey = value
    },
    async submitForm() {

    }
  }
}
</script>

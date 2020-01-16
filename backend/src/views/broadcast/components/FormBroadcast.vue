<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :sm="24" :md="10" :lg="10" :xl="12">
        <p class="warn-content">{{ $t('label.target') }}</p>
        <div class="broadcast-target">
          <el-form
            ref="broadcast"
            :model="broadcast"
            :label-width="device === 'desktop' ? '150px' : null"
            label-position="left"
            :rules="rules"
            :status-icon="true"
          >
            <el-form-item :label="$t('label.area')" prop="wilayah" class="block">
              <InputSelectArea
                class="inline-block"
                :kabkota-id="broadcast.kabkota_id"
                :kec-id="broadcast.kec_id"
                :kel-id="broadcast.kel_id"
                :style="{width: width}"
                @changeKabkota="broadcast.kabkota_id = $event"
                @changeKecamatan="broadcast.kec_id = $event"
                @changeKelurahan="broadcast.kel_id = $event"
              />
            </el-form-item>
            <el-form-item class="rw" prop="rw">
              <el-input v-model="broadcast.rw" placeholder="Semua RW" type="text" :disabled="broadcast.kel_id === null" />
            </el-form-item>
          </el-form>
        </div>
      </el-col>
      <el-col :sm="24" :md="14" :lg="14" :xl="12">
        <p class="warn-content">{{ $t('label.description') }}</p>
        <div class="broadcast-message">
          <el-form
            id="broadcast"
            ref="broadcast"
            :model="broadcast"
            :rules="rules"
            :label-width="device === 'desktop' ? '150px' : null"
            label-position="left"
            :status-icon="true"
            class="form-editor"
          >
            <el-form-item id="title" :label="$t('label.title-broadcast')" prop="title">
              <el-input v-model="broadcast.title" type="text" name="title" placeholder="Judul Pesan (minimum 10 karakter, maksimum 100 karakter)" />
            </el-form-item>
            <el-form-item :label="$t('label.category')" prop="category_id" class="inlineBlock">
              <InputCategory v-model="broadcast.category_id" category-type="broadcast" prop="category" style="width: 100%" />
            </el-form-item>
            <el-form-item :label="$t('label.scheduled')" prop="is_scheduled" class="inline-block">
              <el-radio-group v-model="broadcast.is_scheduled" name="jadwal" class="inline-block">
                <el-radio-button :label="false">{{ $t('label.broadcast-now') }}</el-radio-button>
                <el-radio-button :label="true">{{ $t('label.broadcast-scheduled') }}</el-radio-button>
              </el-radio-group>
            </el-form-item>
            <el-form-item v-if="broadcast.is_scheduled === true" :label="$t('label.scheduled_datetime')" :prop="scheduled_datetime_validation" class="block">
              <el-date-picker
                v-model="broadcast.scheduled_datetime"
                type="datetime"
                format="dd-MM-yyyy HH:mm"
                :editable="true"
                placeholder="Pilih Tanggal dan Waktu"
                style="width:100%"
                @focus="changePropDatetime"
              />
            </el-form-item>

            <el-form-item :label="$t('label.broadcast-link')" prop="is_scheduled" class="inline-block">
              <el-radio-group v-model="broadcast.is_link" name="link" class="inline-block">
                <el-radio-button :label="false">{{ $t('label.broadcast-false') }}</el-radio-button>
                <el-radio-button :label="true">{{ $t('label.broadcast-true') }}</el-radio-button>
              </el-radio-group>
            </el-form-item>

            <el-form-item v-if="broadcast.is_link" :label="$t('label.broadcast-source')" prop="is_scheduled" class="inline-block">
              <el-radio-group v-model="broadcast.source" name="link" class="inline-block">
                <el-radio-button :label="false">{{ $t('label.broadcast-external') }}</el-radio-button>
                <el-radio-button :label="true">{{ $t('label.broadcast-internal') }}</el-radio-button>
              </el-radio-group>
            </el-form-item>

            <el-form-item v-if="broadcast.is_link && !broadcast.source" label="Tautan" prop="link_url">
              <el-input v-model="broadcast.link_url" type="text" name="link_url" placeholder="URL Broadcast" />
            </el-form-item>

            <el-form-item v-else-if="broadcast.is_link && broadcast.source" label="Fitur" prop="internal_category">
              <el-select v-model="broadcast.internal_category" placeholder="Pilih Fitur" name="fitur">
                <el-option label="Survei" value="survey" />
                <el-option label="Polling" value="polling" />
                <el-option label="Berita" value="news" />
              </el-select>
              <span v-if="broadcast.internal_category !== null">
                <el-button type="success" @click="dialog(broadcast.internal_category)">Pilihan</el-button>
              </span>
            </el-form-item>

            <el-form-item v-if="broadcast.is_link && broadcast.source" :label="titleFitur" prop="internal_entity_name">
              <el-input v-model="broadcast.internal_entity_name" disabled type="text" name="internal_entity_name" />
            </el-form-item>

            <el-form-item :label="$t('label.description')" prop="description">
              <tinymce v-model="broadcast.description" :height="300" />
            </el-form-item>
            <el-form-item class="ml-min-40">
              <el-button class="mb-10" type="info" :disabled="broadcast.status === status.PUBLISHED" :loading="loading" @click="submitForm(status.DRAFT)">{{ $t('crud.draft') }}</el-button>
              <el-button v-show="!isEdit" type="primary" :loading="loading" @click="actionApprove(status.PUBLISHED)"> {{ $t('crud.send') }}</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-col>
    </el-row>
    <el-dialog :visible.sync="showDialog" width="70%" :title="titlePopup">
      <Fitur :category="dialogName" @childData="getData" @closeDialog="dialogClose" />
    </el-dialog>
  </div>
</template>
<script>
import InputCategory from '@/components/InputCategory'
import InputSelectArea from '@/components/InputSelectArea'
import { create, fetchRecord, update } from '@/api/broadcast'
import { containsWhitespace, isContainHtmlTags, validUrl } from '@/utils/validate'
import { mapGetters } from 'vuex'
import Fitur from '@/views/banner/components/dialog/fitur'
import Tinymce from '@/components/Tinymce'
import moment from 'moment'

export default {
  components: {
    Tinymce,
    Fitur,
    InputCategory,
    InputSelectArea
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

    const whitespaceTitle = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('message.broadcast-title-valid')))
      }
      callback()
    }

    const whitespaceDescription = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('message.broadcast-description-valid')))
      }
      callback()
    }

    const validatorHTMLTitle = (rule, value, callback) => {
      if (isContainHtmlTags(value) === true) {
        callback(new Error(this.$t('errors.broadcast-title')))
      }

      callback()
    }

    return {
      loading: false,
      status: {
        DRAFT: 0,
        PUBLISHED: 10
      },
      width: '300%',
      broadcast: {
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        rw: null,
        title: null,
        category_id: null,
        description: null,
        is_scheduled: false,
        scheduled_datetime: null,
        // need confirmation
        is_link: false,
        source: false,
        link_url: null,
        internal_category: null,
        internal_entity_id: null,
        internal_entity_name: null
      },
      titleFitur: null,
      titlePopup: null,
      showDialog: false,
      dialogName: null,
      scheduled_datetime_validation: 'scheduled_datetime',
      rules: {
        title: [
          {
            required: true,
            message: this.$t('message.broadcast-title-required'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('message.broadcast-title-min'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('message.broadcast-title-max'),
            trigger: 'blur'
          },
          {
            validator: validatorHTMLTitle,
            trigger: 'blur'
          },
          {
            validator: whitespaceTitle,
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
        description: [
          {
            required: true,
            message: this.$t('message.broadcast-description-required'),
            trigger: 'blur'
          },
          {
            max: 65000,
            message: this.$t('message.broadcast-description-max'),
            trigger: 'blur'
          },
          {
            validator: whitespaceDescription,
            trigger: 'blur'
          }
        ],
        rw: [
          {
            pattern: /^[0-9]+$/,
            message: this.$t('message.broadcast-rw-pattern'),
            trigger: 'blur'
          },
          {
            max: 3,
            message: this.$t('message.broadcast-rw-max'),
            trigger: 'blur'
          },
          {
            min: 3,
            message: this.$t('message.broadcast-rw-min'),
            trigger: 'blur'
          }
        ],
        wilayah: [
          {
            required: false,
            message: this.$t('message.broadcast-area-required'),
            trigger: 'change'
          }
        ],
        is_scheduled: [
          {
            required: true,
            message: this.$t('message.broadcast-scheduled'),
            trigger: 'blur'
          }
        ],
        scheduled_datetime: [
          {
            required: true,
            message: this.$t('message.broadcast-scheduled_datetime'),
            trigger: 'blur'
          }
        ],
        scheduled_datetime_error: [
          {
            required: true,
            message: this.$t('message.broadcast-scheduled_datetime-expire'),
            trigger: 'change'
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
        ]
      }
    }
  },
  computed: {
    ...mapGetters([
      'device'
    ])
  },
  watch: {
    'broadcast.kel_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.broadcast.rw = null
      }
      this.resetRw()
    },
    'broadcast.kec_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.broadcast.kel_id = null
        this.broadcast.rw = null
      }
      this.resetRw()
    },
    'broadcast.kabkota_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.broadcast.kec_id = null
        this.broadcast.kel_id = null
        this.broadcast.rw = null
      }
      this.resetRw()
    },

    'broadcast.is_scheduled'() {
      if (this.broadcast.is_scheduled === false) {
        this.broadcast.scheduled_datetime = null
      }
    },

    'broadcast.internal_category'(newVal, oldVal) {
      if (oldVal === null) {
        this.broadcast.internal_entity_name
        this.broadcast.internal_entity_id
      } else if (oldVal !== newVal) {
        this.broadcast.internal_entity_name = null
        this.broadcast.internal_entity_id = null
      }

      if (this.broadcast.internal_category === 'survey') {
        this.titleFitur = this.$t('label.survey-title')
        this.titlePopup = this.$t('label.survey-list')
      } else if (this.broadcast.internal_category === 'polling') {
        this.titleFitur = this.$t('label.polling-title')
        this.titlePopup = this.$t('label.polling-list')
      } else {
        this.titleFitur = this.$t('news.news-title')
        this.titlePopup = this.$t('news.news-list')
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
    dialogClose(value) {
      this.showDialog = value
    },
    getData(value) {
      this.broadcast.internal_entity_name = value.name !== undefined ? value.name : value.title
      this.broadcast.internal_entity_id = value.id
    },
    resetRw() {
      if (this.broadcast.kel_id === null || this.broadcast.kec_id === null || this.broadcast.kabkota_id === null) {
        this.broadcast.kel_id = null
        this.broadcast.rw = null
      }
    },
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.broadcast = response.data
        this.broadcast.scheduled_datetime = response.data.scheduled_datetime ? moment.unix(response.data.scheduled_datetime) : null
        if (this.broadcast.status !== this.status.DRAFT) {
          this.$message.error(this.$t('crud.broadcast-error-edit-published'))
          this.$router.push('/broadcast/index')
        }
      }).catch(err => {
        console.log(err)
      })
    },
    async submitForm(status) {
      if (this.broadcast.kabkota_id === null) {
        this.broadcast.kec_id = null
        this.broadcast.kel_id = null
        this.broadcast.rw = null
      } else if (this.broadcast.kec_id === null) {
        this.broadcast.kel_id = null
        this.broadcast.rw = null
      } else if (this.broadcast.kel_id === null) {
        this.broadcast.rw = null
      }

      const valid = await this.$refs.broadcast.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true
        const data = {}

        Object.assign(data, this.broadcast)

        data.status = status

        if (data.is_scheduled === true) {
          data.scheduled_datetime = moment(this.broadcast.scheduled_datetime).unix()
        } else {
          data.scheduled_datetime = null
        }

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.info(this.$t('crud.draft-success'))

          this.$router.push('/broadcast/index')
        } else {
          await create(data)
          if (status === this.status.PUBLISHED) {
            this.$message.success(this.$t('crud.send-success'))
            this.$router.push('/broadcast/index')
          } else if (status === this.status.DRAFT) {
            this.$message.info(this.$t('crud.draft-success'))
            this.$router.push('/broadcast/index')
          }
        }
      } catch (err) {
        const errorDate = err.response.data.data.scheduled_datetime
        const errorTitle = err.response.data.data.title
        const errorDescription = err.response.data.data.description

        if (errorDate) {
          this.broadcast.scheduled_datetime = null
          this.scheduled_datetime_validation = 'scheduled_datetime_error'
        } else if (errorTitle && errorDescription) {
          this.$message.error(this.$t('errors.broadcast-title-description'))
        } else if (errorTitle) {
          this.$message.error(this.$t('errors.broadcast-title'))
        } else if (errorDescription) {
          this.$message.error(this.$t('errors.broadcast-description'))
        } else {
          console.log(err)
        }
      } finally {
        this.loading = false
      }
    },
    async actionApprove(status) {
      const valid = await this.$refs.broadcast.validate()

      if (!valid) {
        return
      }

      await this.$confirm(this.$t('message.confirmation-send-message') + `${this.broadcast.title}` + '?', this.$t('message.title'), {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'success'
      })

      try {
        this.submitForm(status)
      } catch (e) {
        console.log(e)
      }
    },
    changePropDatetime() {
      this.scheduled_datetime_validation = 'scheduled_datetime'
    }
  }

}
</script>
<style lang="scss" scoped>
.broadcast-target, .broadcast-message {
  margin: 10px;
}

.mb-10 {
  margin-bottom: 10px;
}
</style>

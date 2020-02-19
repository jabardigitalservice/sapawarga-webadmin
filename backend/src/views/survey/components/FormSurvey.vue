<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="12">
        <el-alert
          v-if="form.status === 10"
          type="error"
          :description="$t('label.survey-description-alert')"
          show-icon
          style="margin-bottom: 15px"
        />
        <!-- start feature target -->
        <p class="warn-content">{{ $t('label.target') }}</p>
        <div>
          <el-form
            ref="form"
            :model="form"
            :label-width="device === 'desktop' ? '150px' : null"
            label-position="left"
            :rules="rules"
            :status-icon="true"
          >
            <el-form-item :label="$t('label.area')" prop="wilayah" class="block">
              <InputSelectArea
                class="inline-block"
                :kabkota-id="form.kabkota_id"
                :kec-id="form.kec_id"
                :kel-id="form.kel_id"
                :style="{width: width}"
                @changeKabkota="form.kabkota_id = $event"
                @changeKecamatan="form.kec_id = $event"
                @changeKelurahan="form.kel_id = $event"
              />
            </el-form-item>
            <el-form-item class="rw" prop="rw">
              <el-input v-model="form.rw" placeholder="Semua RW" type="text" :disabled="form.kel_id === null" />
            </el-form-item>
          </el-form>
        </div>
      </el-col>

      <!-- end feature target -->
      <el-col :sm="24" :md="14" :lg="14" :xl="12">
        <p class="warn-content">{{ $t('label.survey-data') }}</p>
        <el-form ref="form" :model="form" :rules="rules" :status-icon="true" :label-width="device === 'desktop' ? '150px' : null" label-position="left">

          <el-form-item :label="$t('label.survey-title')" prop="title">
            <el-input v-model="form.title" type="text" :placeholder="$t('label.survey-title')" />
          </el-form-item>

          <el-form-item :label="$t('label.category')" prop="category_id">
            <InputCategory v-model="form.category_id" category-type="survey" prop="category" style="width: 100%" />
          </el-form-item>

          <el-form-item :label="$t('label.survey-start-date')">
            <el-date-picker
              v-model="form.start_date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              :placeholder="$t('label.survey-select-date')"
              class="datetime-survey"
            />
          </el-form-item>

          <el-form-item :label="$t('label.survey-end-date')">
            <el-date-picker
              v-model="form.end_date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              :placeholder="$t('label.survey-select-date')"
              class="datetime-survey"
            />
          </el-form-item>

          <el-form-item :label="$t('label.survey-link')" prop="external_url">
            <el-input v-model="form.external_url" type="text" :placeholder="$t('label.survey-link-sample')" />
          </el-form-item>

          <el-form-item :label="$t('label.survey-link-result')" prop="response_url">
            <el-input v-model="form.response_url" type="text" :placeholder="$t('label.survey-link-sample')" />
          </el-form-item>

          <el-form-item class="ml-min-40">
            <el-button v-if="form.status === null || form.status === 0" class="button-mobile" :loading="loading" @click="submitDraft">{{ $t('crud.draft') }}</el-button>
            <el-button v-if="form.status === null || form.status === 0" :disabled="btnDisableDate" type="primary" :loading="loading" @click="submitProcess">{{ $t('crud.save-publish') }}</el-button>

            <router-link :to="'/survey/index'">
              <el-button type="info" class="button-mobile">{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import moment from 'moment'
import InputSelectArea from '@/components/InputSelectArea'
import { fetchRecord, create, update } from '@/api/survey'
import { containsWhitespace, validUrl } from '@/utils/validate'
import { mapGetters } from 'vuex'

import InputCategory from '@/components/InputCategory'

const defaultForm = {
  title: null,
  category_id: null,
  start_date: moment().format('YYYY-MM-DD'),
  end_date: moment().add(1, 'days').format('YYYY-MM-DD'),
  external_url: null,
  response_url: null,
  status: null,
  kabkota_id: null,
  kec_id: null,
  kel_id: null,
  rw: null
}

export default {
  components: {
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
    const validatorTitleWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Judul survei yang diisi tidak valid'))
      }

      callback()
    }

    const validatorUrl = (rule, value, callback) => {
      if (value !== null && !validUrl(value)) {
        callback(new Error('URL tidak valid'))
      }

      callback()
    }

    return {
      form: Object.assign({}, defaultForm),
      loading: false,
      width: '300%',
      btnDisableDate: false,
      rules: {
        title: [
          {
            required: true,
            message: this.$t('message.survey-title-required'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('message.survey-title-min'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('message.survey-title-max'),
            trigger: 'blur'
          },
          {
            validator: validatorTitleWhitespace,
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
        external_url: [
          {
            required: true,
            message: this.$t('message.survey-link-required'),
            trigger: 'blur'
          },
          {
            validator: validatorUrl,
            trigger: 'blur'
          }
        ],
        response_url: [
          {
            validator: validatorUrl,
            trigger: 'blur'
          }
        ],
        wilayah: [
          {
            required: false,
            message: this.$t('message.survey-area-required'),
            trigger: 'change'
          }
        ],
        rw: [
          {
            pattern: /^[0-9]+$/,
            message: this.$t('message.survey-rw-pattern'),
            trigger: 'blur'
          },
          {
            max: 3,
            message: this.$t('message.survey-rw-min'),
            trigger: 'blur'
          },
          {
            min: 3,
            message: this.$t('message.survey-rw-min'),
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
    'form.start_date'(e) {
      const currentDate = moment()
      const dateStart = moment(this.form.start_date).startOf('day')

      const checkStartDate = currentDate - dateStart

      if (checkStartDate < 0) {
        this.btnDisableDate = true
      } else {
        this.btnDisableDate = false
      }
    }
  },
  created() {
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
        const now = moment().format('YYYY-MM-DD')
        const tommorow = moment().add(1, 'days').format('YYYY-MM-DD')

        if (moment(response.data.start_date).isAfter(now)) {
          this.form.start_date = response.data.start_date
        } else {
          this.form.start_date = now
        }
        if (moment(response.data.end_date).isAfter(tommorow)) {
          this.form.end_date = response.data.end_date
        } else {
          this.form.end_date = tommorow
        }
      }).catch(err => {
        console.log(err)
      })
    },

    async submitDraft() {
      await this.submitForm(true)
    },

    async submitProcess() {
      await this.submitForm(false)
    },

    async submitForm(draft) {
      const valid = await this.$refs.form.validate()

      if (!valid) {
        return
      }

      const now = moment().startOf('day')
      const distance = (moment(this.form.start_date)).isBefore(now)

      if (distance === true) {
        this.$message.error(this.$t('errors.survey-start-date'))
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.form)

        if (draft) {
          data.status = 0
        } else {
          data.status = 10
        }

        data.start_date = moment(this.form.start_date).format('YYYY-MM-DD')
        data.end_date = moment(data.end_date).format('YYYY-MM-DD')

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/survey/index')
        } else {
          await create(data)
          this.$message.success(this.$t('crud.create-success'))

          this.$router.push('/survey/index')
        }
      } catch (err) {
        const errorDate = err.response.data.data
        if (errorDate) {
          this.$message.error(this.$t('errors.survey-compare-date'))
        }
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
<style lang="scss" scoped>
 .datetime-survey {
   width:100%;
 }
</style>

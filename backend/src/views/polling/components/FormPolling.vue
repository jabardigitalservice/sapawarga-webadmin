<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :sm="24" :md="10" :lg="10" :xl="12">
        <p class="warn-content">Target</p>
        <div class="polling-target">
          <el-form ref="polling" :model="polling" :label-width="device === 'desktop' ? '150px' : null" label-position="left" :rules="rules" :status-icon="true" :disabled="isEdit === true && checkStatus !== 0">
            <el-form-item :label="$t('label.area')" prop="wilayah" class="block">
              <InputSelectArea
                class="inline-block"
                :kabkota-id="polling.kabkota_id"
                :kec-id="polling.kec_id"
                :kel-id="polling.kel_id"
                :style="{width: width}"
                @changeKabkota="polling.kabkota_id = $event"
                @changeKecamatan="polling.kec_id = $event"
                @changeKelurahan="polling.kel_id = $event"
              />
            </el-form-item>
            <el-form-item class="rw" prop="rw">
              <el-input v-model="polling.rw" :placeholder="$t('label.area-rw')" type="text" name="rw" :disabled="polling.kel_id === null" />
            </el-form-item>
          </el-form>
        </div>
      </el-col>
      <el-col :sm="24" :md="14" :lg="14" :xl="12">
        <p class="warn-content">{{ $t('label.polling-data') }}</p>
        <div class="polling-message">
          <el-form ref="polling" :model="polling" :rules="rules" :label-width="device === 'desktop' ? '150px' : null" label-position="left" :status-icon="true" :disabled="isEdit === true && checkStatus !== 0">

            <el-form-item :label="$t('label.polling-name')" prop="name">
              <el-input v-model="polling.name" type="text" name="title-polling" :placeholder="$t('label.polling-name')" />
            </el-form-item>

            <el-form-item :label="$t('label.category')" prop="category_id">
              <InputCategory v-model="polling.category_id" name="category_id" category-type="polling" prop="category" style="width: 100%" />
            </el-form-item>

            <el-form-item :label="$t('label.polling-description')" prop="description">
              <el-input v-model="polling.description" type="textarea" name="description-polling" :rows="4" :placeholder="$t('label.polling-description')" />
            </el-form-item>

            <el-form-item :label="$t('label.polling-excerpt')" prop="excerpt">
              <el-input v-model="polling.excerpt" type="textarea" name="excerpt-polling" :rows="4" :placeholder="$t('label.polling-excerpt')" />
            </el-form-item>

            <el-form-item :label="$t('label.push-notification')">
              <el-radio-group v-model="polling.is_push_notification" name="notification">
                <el-radio-button label="true">{{ $t('label.true') }}</el-radio-button>
                <el-radio-button label="false">{{ $t('label.false') }}</el-radio-button>
              </el-radio-group>
            </el-form-item>

            <el-form-item :label="$t('label.polling-start-date')" prop="" class="w-100">
              <el-date-picker v-model="start_date" type="date" name="start_date" :editable="false" :clearable="false" format="dd-MM-yyyy" :placeholder="$t('label.polling-select-date')" />
            </el-form-item>
            <el-form-item :label="$t('label.polling-end-date')" prop="" class="w-100">
              <el-date-picker v-model="end_date" type="date" name="end_date" :editable="false" :clearable="false" format="dd-MM-yyyy" :placeholder="$t('label.polling-select-date')" />
            </el-form-item>

            <el-form-item :label="$t('label.polling-question')" prop="question">
              <el-input v-model="polling.question" type="text" name="question" :placeholder="$t('label.polling-question')" />
            </el-form-item>

            <el-form-item v-if="!isEdit" :label="$t('label.polling-question-type')" prop="question_type">
              <el-radio-group v-model="question_type" name="answer">
                <el-radio label="yesNo" @change="selectAnswer('yes')">{{ $t('label.polling-yes-no') }}</el-radio>
                <el-radio label="multiple" @change="selectAnswer('multiple')">{{ $t('label.polling-multiple') }}</el-radio>
                <el-radio label="custom" @change="selectAnswer('custom')">{{ $t('label.polling-customize') }}</el-radio>
              </el-radio-group>
            </el-form-item>

            <div v-if="question_type === 'custom'">
              <el-form-item
                v-for="(answer) in polling.answers"
                :key="answer.id"
                :rules="{
                  required: true, message: this.$t('label.polling-answer-required'), trigger: 'blur'
                }"
              >
                <el-row>
                  <el-col :sm="18" :md="18" :lg="20" :xl="20">
                    <el-input v-model="answer.body" type="text" name="answer-option" :placeholder="$t('label.polling-answer')" />
                  </el-col>
                  <el-col :sm="4" :md="4" :lg="4" :xl="4">
                    <el-button type="danger" class="answer" size="mini" icon="el-icon-delete" style="margin-top:3px" @click.prevent="removeAnswer(answer)" />
                  </el-col>
                </el-row>
              </el-form-item>
              <el-button type="success" class="add-answer" size="mini" icon="el-icon-circle-plus" @click="addAnswer">{{ $t('label.polling-answer-add') }}</el-button>
            </div>

            <el-form-item class="polling-button ml-min-40">
              <el-button v-show="checkStatus === 0 || checkStatus === null" class="draft-button" type="info" :loading="loading" @click="submitForm(status.draft)">{{ $t('crud.draft') }}</el-button>
              <el-button v-show="!isEdit" :disabled="btnDisableDate" type="primary" :loading="loading" @click="actionApprove(status.active)"> {{ $t('crud.send-polling') }}</el-button>
            </el-form-item>
          </el-form>

        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import { create, fetchRecord, update } from '@/api/polling'
import InputSelectArea from '@/components/InputSelectArea'
import InputCategory from '@/components/InputCategory'
import { containsWhitespace } from '@/utils/validate'
import { mapGetters } from 'vuex'

const moment = require('moment')
moment().format()

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
    const question_type = (rule, value, callback) => {
      if (this.question_type === null) {
        callback(new Error(this.$t('label.polling-question-type-required')))
      }
      callback()
    }

    const whitespaceName = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('label.polling-name-invalid')))
      }
      callback()
    }

    const whitespaceDescription = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('label.polling-description-invalid')))
      }
      callback()
    }

    const whitespaceExcerpt = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('label.polling-excerpt-invalid')))
      }
      callback()
    }

    const whitespaceQuestion = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('label.polling-answer-invalid')))
      }
      callback()
    }

    return {
      loading: false,
      status: {
        draft: 0,
        active: 10
      },
      checkStatus: null,
      width: '300%',
      btnDisableDate: false,
      start_date: moment().format('YYYY-MM-DD'),
      end_date: moment().add(1, 'days').format('YYYY-MM-DD'),
      question_type: null,
      polling: {
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        rw: null,
        name: null,
        question: null,
        category_id: null,
        description: null,
        excerpt: null,
        is_push_notification: true,
        answers: [{
          id: 1,
          body: null
        }]
      },
      rules: {
        wilayah: [
          {
            required: false,
            message: 'wilayah harus diisi',
            trigger: 'change'
          }
        ],
        name: [
          {
            required: true,
            message: this.$t('label.polling-name-required'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('label.polling-name-min'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('label.polling-name-max'),
            trigger: 'blur'
          },
          {
            validator: whitespaceName,
            trigger: 'blur'
          }
        ],
        question: [
          {
            required: true,
            message: this.$t('label.polling-question-required'),
            trigger: 'blur'
          },
          {
            min: 10,
            message: this.$t('label.polling-question-min'),
            trigger: 'blur'
          },
          {
            max: 100,
            message: this.$t('label.polling-question-max'),
            trigger: 'blur'
          },
          {
            validator: whitespaceQuestion,
            trigger: 'blur'
          }
        ],
        category_id: [
          { required: true, message: this.$t('message.category'), trigger: 'change' }
        ],
        description: [
          {
            required: true,
            message: this.$t('label.polling-description-required'),
            trigger: 'blur'
          },
          {
            validator: whitespaceDescription,
            trigger: 'blur'
          }
        ],
        excerpt: [
          {
            required: true,
            message: this.$t('label.polling-excerpt-required'),
            trigger: 'blur'
          },
          {
            validator: whitespaceExcerpt,
            trigger: 'blur'
          }
        ],
        question_type: [
          {
            validator: question_type,
            trigger: 'blur'
          }
        ],
        rw: [
          {
            pattern: /^[0-9]+$/,
            message: this.$t('label.polling-rw-number'),
            trigger: 'blur'
          },
          {
            max: 3,
            message: this.$t('label.polling-rw-count'),
            trigger: 'blur'
          },
          {
            min: 3,
            message: this.$t('label.polling-rw-count'),
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
    'polling.kel_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.polling.rw = null
      }
      this.resetRw()
    },
    'polling.kec_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.polling.kel_id = null
        this.polling.rw = null
      }
      this.resetRw()
    },
    'polling.kabkota_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.polling.kec_id = null
        this.polling.kel_id = null
        this.polling.rw = null
      }
      this.resetRw()
    },
    start_date(e) {
      const currentDate = moment()
      const dateStart = moment(this.start_date).startOf('day')

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
    }
  },
  methods: {
    resetRw() {
      if (this.polling.kel_id === null || this.polling.kec_id === null || this.polling.kabkota_id === null) {
        this.polling.kel_id = null
        this.polling.rw = null
      }
    },
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.polling = response.data
        this.checkStatus = response.data.status

        if (moment(response.data.start_date).isAfter(this.start_date)) {
          this.start_date = response.data.start_date
        }
        if (moment(response.data.end_date).isAfter(this.end_date)) {
          this.end_date = response.data.end_date
        }

        if (this.checkStatus === 10) {
          this.$message.error(this.$t('crud.polling-error-edit-published'))
          this.$router.push('/polling/index')
        }
      }).catch(err => {
        console.log(err)
      })
    },
    async submitForm(status) {
      const valid = await this.$refs.polling.validate()

      if (!valid) {
        return
      }

      if (this.polling.kabkota_id === null) {
        this.polling.kec_id = null
        this.polling.kel_id = null
        this.polling.rw = null
      } else if (this.polling.kec_id === null) {
        this.polling.kel_id = null
        this.polling.rw = null
      } else if (this.polling.kel_id === null) {
        this.polling.rw = null
      }

      if (this.polling.answers.length === 0) {
        this.$message.error(this.$t('errors.polling-answer-null'))
        return
      } else {
        for (let i = 0; i < this.polling.answers.length; i++) {
          if (this.polling.answers[i].body === '') {
            this.$message.error(this.$t('errors.polling-answer-null'))
            return
          } else if (this.polling.answers.length < 2) {
            this.$message.error(this.$t('errors.polling-answer-less-then-2'))
            return
          }
        }
      }

      const now = moment().startOf('day')
      const distance = (moment(this.start_date)).isBefore(now)

      if (distance === true) {
        this.$message.error(this.$t('errors.polling-start-date'))
        return
      }

      try {
        this.loading = true

        const data = {}

        Object.assign(data, this.polling)

        data.status = status
        data.start_date = moment(this.start_date).format('YYYY-MM-DD')
        data.end_date = moment(this.end_date).format('YYYY-MM-DD')

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.info(this.$t('crud.draft-polling-success'))

          this.$router.push('/polling/index')
        } else {
          await create(data)

          if (status === 10) {
            this.$message.success(this.$t('crud.send-polling-success'))
            this.$router.push('/polling/index')
          } else if (status === 0) {
            this.$message.info(this.$t('crud.draft-polling-success'))
            this.$router.push('/polling/index')
          }
        }
      } catch (err) {
        const errorDate = err.response.data.data.start_date
        if (errorDate) {
          this.$message.error(this.$t('errors.polling-compare-date'))
        }
      } finally {
        this.loading = false
      }
    },
    addAnswer() {
      this.polling.answers.push({
        id: this.polling.answers.length + 1,
        body: ''
      })
    },
    removeAnswer(item) {
      const index = this.polling.answers.indexOf(item)
      if (index !== -1) {
        this.polling.answers.splice(index, 1)
      }
    },
    selectAnswer(label) {
      if (label === 'yes') {
        this.polling.answers = [{
          id: 1,
          body: this.$t('label.true')
        },
        {
          id: 2,
          body: this.$t('label.false')
        }]
      } else if (label === 'multiple') {
        this.polling.answers = [{
          id: 1,
          body: this.$t('label.good')
        },
        {
          id: 2,
          body: this.$t('label.enough')
        },
        {
          id: 3,
          body: this.$t('label.less')
        }]
      } else {
        this.polling.answers = [{
          id: 1,
          body: ''
        }]
      }
    },
    async actionApprove(status) {
      const valid = await this.$refs.polling.validate()

      if (!valid) {
        return
      }

      for (let i = 0; i < this.polling.answers.length; i++) {
        if (this.polling.answers[i].body === '') {
          this.$message.error(this.$t('errors.polling-answer-null'))
          return
        } else {
          if (this.polling.answers.length < 2) {
            this.$message.error(this.$t('errors.polling-answer-less-then-2'))
            return
          }
        }
      }

      await this.$confirm(this.$t('label.polling-confirm') ` : ${this.polling.name} ?`, this.$t('message.title'), {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'success'
      })

      try {
        this.submitForm(status)
      } catch (e) {
        console.log(e)
      }
    }
  }

}
</script>
<style lang="scss" scoped>
.polling-target, .polling-message {
  margin: 10px;
}
el-radio {
  display: inline-flex;
}

.polling-button {
  margin-top: 70px;
}

.add-answer {
  float: right;
}

.answer {
  float: left;
  margin-left: 15px;
}

.draft-button {
  margin-bottom: 7px;
}

.el-date-editor.el-input {
  width: 100%;
}

@media only screen and (max-width: 991px) {
 .add-answer {
   float: right;
    margin-right: 23px;
    margin-top: -10px;
 }

 .answer {
    float: left;
    margin-left: unset;
    margin-top: 10px !important;
 }
}
</style>

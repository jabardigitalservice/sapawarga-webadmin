<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :sm="24" :md="10" :lg="10" :xl="12">
        <p class="warn-content">Target</p>
        <div class="polling-target">
          <el-form
            ref="polling"
            :model="polling"
            label-width="150px"
            label-position="left"
            :rules="rules"
            :status-icon="true"
            :disabled="isEdit === true && checkStatus !== 0"
          >
            <el-form-item label="Wilayah" prop="wilayah">
              <InputSelectArea
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
              <el-input v-model="polling.rw" placeholder="Semua RW" type="text" :disabled="polling.kel_id === null" />
            </el-form-item>
          </el-form>
        </div>
      </el-col>
      <el-col :sm="24" :md="14" :lg="14" :xl="12">
        <p class="warn-content">Data Polling</p>
        <div class="polling-message">
          <el-form
            ref="polling"
            :model="polling"
            :rules="rules"
            label-width="150px"
            label-position="left"
            :status-icon="true"
            :disabled="isEdit === true && checkStatus !== 0"
          >
            <el-form-item label="Nama Polling" prop="name">
              <el-input v-model="polling.name" type="text" placeholder="Nama Polling" />
            </el-form-item>
            <el-form-item label="Kategori" prop="category_id">
              <InputCategory v-model="polling.category_id" category-type="polling" prop="category" />
            </el-form-item>
            <el-form-item label="Deskripsi" prop="description">
              <el-input
                v-model="polling.description"
                type="textarea"
                :rows="4"
                placeholder="Deskripsi"
              />
            </el-form-item>
            <el-form-item label="Pengantar" prop="excerpt">
              <el-input
                v-model="polling.excerpt"
                type="textarea"
                :rows="4"
                placeholder="Pengantar"
              />
            </el-form-item>
            <el-form-item label="Dimulai dari" prop="">
              <el-date-picker
                v-model="start_date"
                type="date"
                :editable="false"
                :clearable="false"
                format="dd-MM-yyyy"
                placeholder="Pilih tanggal"
              />
            </el-form-item>
            <el-form-item label="Sampai" prop="">
              <el-date-picker
                v-model="end_date"
                type="date"
                :editable="false"
                :clearable="false"
                format="dd-MM-yyyy"
                placeholder="Pilih tanggal"
              />
            </el-form-item>

            <el-form-item label="Pertanyaan" prop="question">
              <el-input v-model="polling.question" type="text" placeholder="Pertanyaan" />
            </el-form-item>

            <el-form-item v-if="!isEdit" label="Tipe Pertanyaan" prop="question_type">
              <el-radio-group v-model="question_type">
                <el-radio label="yesNo" @change="selectAnswer('yes')">Ya / Tidak</el-radio>
                <el-radio label="multiple" @change="selectAnswer('multiple')">Multiple</el-radio>
                <el-radio label="custome" @change="selectAnswer('custome')">Custom</el-radio>
              </el-radio-group>
            </el-form-item>

            <div v-if="question_type === 'custome'">
              <el-form-item
                v-for="(answer) in polling.answers"
                :key="answer.id"
                :rules="{
                  required: true, message: 'Jawaban harus diisi', trigger: 'blur'
                }"
              >
                <el-row>
                  <el-col :sm="18" :md="18" :lg="20" :xl="20">
                    <el-input v-model="answer.body" type="text" placeholder="Jawaban" />
                  </el-col>
                  <el-col :sm="4" :md="4" :lg="4" :xl="4">
                    <el-button type="danger" class="answer" size="mini" icon="el-icon-delete" style="margin-top:3px" @click.prevent="removeAnswer(answer)" />
                  </el-col>
                </el-row>
              </el-form-item>
              <el-button type="success" class="add-answer" size="mini" icon="el-icon-circle-plus" @click="addAnswer">Jawaban Lain</el-button>
            </div>

            <el-form-item class="polling-button">
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
import InputCategory from '@/components/InputCategory'
import InputSelectArea from '@/components/InputSelectArea'
import { create, fetchRecord, update } from '@/api/polling'
import { containsWhitespace } from '@/utils/validate'

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
        callback(new Error('Tipe pertanyaan harus diisi'))
      }
      callback()
    }

    const whitespaceName = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Nama polling yang diisi tidak valid'))
      }
      callback()
    }

    const whitespaceDescription = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Deskripsi yang diisi tidak valid'))
      }
      callback()
    }

    const whitespaceExcerpt = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Pengantar yang diisi tidak valid'))
      }
      callback()
    }

    const whitespaceQuestion = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Pertanyaan yang diisi tidak valid'))
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
            message: 'Nama polling harus diisi',
            trigger: 'blur'
          },
          {
            min: 10,
            message: 'Nama polling minimal 10 karakter',
            trigger: 'blur'
          },
          {
            max: 100,
            message: 'Nama polling maksimal 100 karakter',
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
            message: 'Pertanyaan harus diisi',
            trigger: 'blur'
          },
          {
            min: 10,
            message: 'Pertanyaan minimal 10 karakter',
            trigger: 'blur'
          },
          {
            max: 100,
            message: 'Pertanyaan maksimal 100 karakter',
            trigger: 'blur'
          },
          {
            validator: whitespaceQuestion,
            trigger: 'blur'
          }
        ],
        category_id: [
          { required: true, message: 'Kategori harus diisi.', trigger: 'change' }
        ],
        description: [
          {
            required: true,
            message: 'Deskripsi harus diisi',
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
            message: 'Pengantar harus diisi',
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
            message: 'RW harus menggunakan angka',
            trigger: 'blur'
          },
          {
            max: 3,
            message: 'RW harus 3 angka, contoh 001',
            trigger: 'blur'
          },
          {
            min: 3,
            message: 'RW harus 3 angka, contoh 001',
            trigger: 'blur'
          }
        ]
      }
    }
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

      if (this.polling.answers.length < 2) {
        this.$message.error(this.$t('errors.polling-answer-less-then-2'))
        return
      } else {
        for (let i = 0; i < this.polling.answers.length; i++) {
          if (this.polling.answers[i].body === '') {
            this.$message.error(this.$t('errors.polling-answer-null'))
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
          body: 'Ya'
        },
        {
          id: 2,
          body: 'Tidak'
        }]
      } else if (label === 'multiple') {
        this.polling.answers = [{
          id: 1,
          body: 'Baik'
        },
        {
          id: 2,
          body: 'Cukup'
        },
        {
          id: 3,
          body: 'Kurang'
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

      if (this.polling.answers.length < 2) {
        this.$message.error(this.$t('errors.polling-answer-less-then-2'))
        return
      } else {
        for (let i = 0; i < this.polling.answers.length; i++) {
          if (this.polling.answers[i].body === '') {
            this.$message.error(this.$t('errors.polling-answer-null'))
            return
          }
        }
      }

      await this.$confirm(`Apakah anda yakin akan mengirimkan polling : ${this.polling.name} ?`, 'Konfirmasi', {
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
  margin: 20px;
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
</style>

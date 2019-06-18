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
          >
            <el-form-item label="Nama Survey" prop="name">
              <el-input v-model="polling.name" type="text" placeholder="Nama Survey" />
            </el-form-item>
            <el-form-item label="Kategori" prop="category_id">
              <InputCategory v-model="polling.category_id" category-type="polling" prop="category" />
            </el-form-item>
            <el-form-item label="Deskripsi" prop="description">
              <el-input
                v-model="polling.description"
                type="textarea"
                :rows="4"
                placeholder="Tulis pesan, maksimal 280 karakter"
              />
            </el-form-item>
            <el-form-item label="Pengantar" prop="excerpt">
              <el-input
                v-model="polling.excerpt"
                type="textarea"
                :rows="4"
                placeholder="Tulis pesan, maksimal 280 karakter"
              />
            </el-form-item>
            <el-form-item label="Dimulai dari" prop="date">
              <el-date-picker
                v-model="polling.start_date"
                type="date"
                placeholder="Pilih tanggal">
              </el-date-picker>
            </el-form-item>
            <el-form-item label="Sampai" prop="">
              <el-date-picker
                v-model="polling.end_date"
                type="date"
                placeholder="Pilih tanggal">
              </el-date-picker>
            </el-form-item>

            <el-form-item label="Pertanyaan" prop="question">
              <el-input v-model="polling.title" type="text" placeholder="Nama Survey" />
            </el-form-item>

            <el-form-item label="Tipe Pertanyaan" prop="">
              <el-radio-group v-model="polling.question_type">
                <el-radio label="yesNo">Ya / Tidak</el-radio>
                <el-radio label="multiple">Multiple</el-radio>
                <el-radio label="custome">Custome</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item>
              <el-button type="info" :loading="loading" @click="submitForm(status.draft)">{{ $t('crud.draft') }}</el-button>
              <el-button v-show="!isEdit" type="primary" :loading="loading" @click="submitForm(status.active)"> {{ $t('crud.send-polling') }}</el-button>
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
    return {
      loading: false,
      width: '300%',
      polling: {
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        rw: null,
        title: null,
        category_id: null,
        description: null,
        excerpt: null,
        start_date: null,
        end_date: null,
        question_type: null
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
            max: 60,
            message: 'Nama polling maksimal 60 karakter',
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
            max: 60,
            message: 'Pertanyaan maksimal 60 karakter',
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
            max: 280,
            message: 'Deskripsi maksimal 280 karakter',
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
            max: 280,
            message: 'Pengantar maksimal 280 karakter',
            trigger: 'blur'
          }
        ],
        date: [
          {
            required: true,
            message: 'Tanggal harus diisi',
            trigger: 'change'
          },
        ]
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
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.polling = response.data
      }).catch(err => {
        console.log(err)
      })
    },
    async submitForm(status) {

      const valid = await this.$refs.polling.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true
        const data = {}

        Object.assign(data, this.polling)

        data.status = status


        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.info(this.$t('crud.draft-polling-success'))

          this.$router.push('/polling/index')
        } else {
          await create(data)
          console.log(data)
          if (status === 10) {
            this.$message.success(this.$t('crud.send-polling-success'))
            this.$router.push('/polling/index')
          } else if (status === 0) {
            this.$message.info(this.$t('crud.draft-polling-success'))
            this.$router.push('/polling/index')
          }
        }
      } catch (err) {
        console.log(err)
      } finally {
        this.loading = false
      }
    },
    addAnswer() {
      this.polling.answers.push({
        id: this.polling.answers.length + 1,
        body: ''
      });
    },
    removeAnswer(item) {
      let index = this.polling.answers.indexOf(item);
      if (index !== -1) {
        this.polling.answers.splice(index, 1);
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
  margin-top: 50px;
}

.add-answer {
  float: right;
}

.answer {
  float: right;
}
</style>

<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :sm="24" :md="10" :lg="10" :xl="12">
        <p class="warn-content">Target</p>
        <div class="broadcast-target">
          <el-form
            ref="broadcast"
            :model="broadcast"
            label-width="150px"
            label-position="left"
            :rules="rules"
            :status-icon="true"
          >
            <el-form-item label="Wilayah" prop="wilayah">
              <InputSelectArea
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
        <p class="warn-content">Isi Pesan</p>
        <div class="broadcast-message">
          <el-form
            ref="broadcast"
            :model="broadcast"
            :rules="rules"
            label-width="150px"
            label-position="left"
            :status-icon="true"
          >
            <el-form-item label="Judul Pesan" prop="title">
              <el-input v-model="broadcast.title" type="text" placeholder="Judul minimal 10 karakter dan maksimal 60 karakter" />
            </el-form-item>
            <el-form-item label="Kategori" prop="category_id">
              <InputCategory v-model="broadcast.category_id" category-type="broadcast" prop="category" />
            </el-form-item>
            <el-form-item label="Isi Pesan" prop="description">
              <el-input
                v-model="broadcast.description"
                type="textarea"
                :rows="8"
                placeholder="Tulis pesan, maksimal 280 karakter"
              />
            </el-form-item>
            <el-form-item>
              <el-button type="info" :disabled="broadcast.status === 10" :loading="loading" @click="submitForm(status.draft)">{{ $t('crud.draft') }}</el-button>
              <el-button v-show="!isEdit" type="primary" :loading="loading" @click="actionApprove(status.active)"> {{ $t('crud.send') }}</el-button>
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
import { create, fetchRecord, update } from '@/api/broadcast'
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
    const whitespaceTitle = (rule, value, callback) => {
      if (value.includes('  ') || value.startsWith(' ') || value.endsWith(' ')) {
        callback(new Error('Judul broadcast yang diisi tidak valid'))
      }
      callback()
    }

    const whitespaceDescription = (rule, value, callback) => {
      if (value.includes('  ') || value.startsWith(' ') || value.endsWith(' ')) {
        callback(new Error('Deskripsi yang diisi tidak valid'))
      }
      callback()
    }

    return {
      loading: false,
      status: {
        draft: 0,
        active: 10
      },
      width: '300%',
      broadcast: {
        kabkota_id: null,
        kec_id: null,
        kel_id: null,
        rw: null,
        title: null,
        category_id: null,
        description: null
      },
      rules: {
        title: [
          {
            required: true,
            message: 'Judul pesan harus diisi',
            trigger: 'blur'
          },
          {
            min: 10,
            message: 'Judul pesan minimal 10 karakter',
            trigger: 'blur'
          },
          {
            max: 60,
            message: 'Judul pesan maksimal 60 karakter',
            trigger: 'blur'
          },
          {
            validator: whitespaceTitle,
            trigger: 'blur'
          }

        ],
        category_id: [
          { required: true, message: 'Kategori harus diisi.', trigger: 'change' }
        ],
        description: [
          {
            required: true,
            message: 'Pesan harus diisi',
            trigger: 'blur'
          },
          {
            max: 280,
            message: 'Pesan maksimal 280 karakter',
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
        ],
        wilayah: [
          {
            required: false,
            message: 'wilayah harus diisi',
            trigger: 'change'
          }
        ]
      }
    }
  },
  watch: {
    'broadcast.kel_id'() {
      this.resetRw()
    },
    'broadcast.kec_id'() {
      this.resetRw()
    },
    'broadcast.kabkota_id'() {
      this.resetRw()
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
      if (this.broadcast.kel_id === null || this.broadcast.kec_id === null || this.broadcast.kabkota_id === null) {
        this.broadcast.kel_id = null
        this.broadcast.rw = null
      }
    },
    fetchData(id) {
      fetchRecord(id).then(response => {
        this.broadcast = response.data
        if (this.broadcast.status === 10) {
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

      try {
        this.loading = true
        const data = {}

        Object.assign(data, this.broadcast)

        data.status = status

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.info(this.$t('crud.draft-success'))

          this.$router.push('/broadcast/index')
        } else {
          await create(data)
          if (status === 10) {
            this.$message.success(this.$t('crud.send-success'))
            this.$router.push('/broadcast/index')
          } else if (status === 0) {
            this.$message.info(this.$t('crud.draft-success'))
            this.$router.push('/broadcast/index')
          }
        }
      } catch (err) {
        console.log(err)
      } finally {
        this.loading = false
      }
    },
    async actionApprove(status) {

      const valid = await this.$refs.broadcast.validate()

      if (!valid) {
        return
      }

      await this.$confirm(`Apakah anda yakin akan mengirimkan Pesan : ${this.broadcast.title} [Tujuan] ?`, 'Konfirmasi', {
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
.broadcast-target, .broadcast-message {
  margin: 20px;
}
.rw {
  margin-top: -7px;
}

</style>

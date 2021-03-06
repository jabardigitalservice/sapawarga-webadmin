<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :sm="24" :md="10" :lg="10" :xl="12">
        <p class="warn-content">Target</p>
        <div class="notification-target">
          <el-form
            ref="notification"
            :model="notification"
            label-width="150px"
            label-position="left"
            :rules="rules"
            :status-icon="true"
          >
            <el-form-item label="Wilayah" prop="wilayah">
              <InputSelectArea
                :kabkota-id="notification.kabkota_id"
                :kec-id="notification.kec_id"
                :kel-id="notification.kel_id"
                :style="{width: width}"
                @changeKabkota="notification.kabkota_id = $event"
                @changeKecamatan="notification.kec_id = $event"
                @changeKelurahan="notification.kel_id = $event"
              />
            </el-form-item>
            <el-form-item class="rw" prop="rw">
              <el-input
                v-model="notification.rw"
                placeholder="Semua RW"
                type="text"
                :disabled="notification.kel_id === null"
              />
            </el-form-item>
          </el-form>
        </div>
      </el-col>
      <el-col :sm="24" :md="14" :lg="14" :xl="12">
        <p class="warn-content">Isi Pesan</p>
        <div class="notification-message">
          <el-form
            ref="notification"
            :model="notification"
            :rules="rules"
            label-width="150px"
            label-position="left"
            :status-icon="true"
          >
            <el-form-item label="Judul Notifikasi" prop="title">
              <el-input
                v-model="notification.title"
                type="text"
                placeholder="Judul Notifikasi (minimum 10 karakter, maksimum 100 karakter)"
              />
            </el-form-item>
            <el-form-item label="Kategori" prop="category_id">
              <InputCategory
                v-model="notification.category_id"
                category-type="notification"
                prop="category"
              />
            </el-form-item>
            <el-form-item label="Isi Pesan" prop="description">
              <el-input
                v-model="notification.description"
                type="textarea"
                :rows="8"
                placeholder="Tulis pesan notifikasi (maksimum 1000 karakter)"
              />
            </el-form-item>
            <el-form-item>
              <el-button
                type="info"
                :disabled="notification.status === 10"
                :loading="loading"
                @click="submitForm(status.draft)"
              >{{ $t('crud.draft') }}</el-button>
              <el-button
                v-show="!isEdit"
                type="primary"
                :loading="loading"
                @click="actionApprove(status.active)"
              >{{ $t('crud.send') }}</el-button>
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
import { create, fetchRecord, update } from '@/api/notification'
import { containsWhitespace } from '@/utils/validate'
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
    const whitespaceName = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Judul notifikasi yang diisi tidak valid'))
      }
      callback()
    }

    const whitespaceDesc = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
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
      notification: {
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
            message: 'Judul notifikasi harus diisi',
            trigger: 'blur'
          },
          {
            min: 10,
            message: 'Judul notifikasi minimal 10 karakter',
            trigger: 'blur'
          },
          {
            max: 100,
            message: 'Judul notifikasi maksimal 100 karakter',
            trigger: 'blur'
          },
          {
            validator: whitespaceName,
            trigger: 'blur'
          }
        ],
        category_id: [
          {
            required: true,
            message: 'Kategori harus diisi.',
            trigger: 'change'
          }
        ],
        description: [
          {
            required: true,
            message: 'Isi pesan notifikasi harus diisi',
            trigger: 'blur'
          },
          {
            max: 1000,
            message: 'Isi pesan notifikasi maksimal 1000 karakter',
            trigger: 'blur'
          },
          {
            validator: whitespaceDesc,
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
    'notification.kabkota_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.notification.kec_id = null
        this.notification.kel_id = null
        this.notification.rw = null
      }
      this.resetRw()
    },
    'notification.kec_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.notification.kel_id = null
        this.notification.rw = null
      }
      this.resetRw()
    },
    'notification.kel_id'(oldVal, newVal) {
      if (newVal !== null) {
        this.notification.rw = null
      }
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
      if (this.notification.kel_id === null || this.notification.kec_id === null || this.notification.kabkota_id === null) {
        this.notification.kel_id = null
        this.notification.rw = null
      }
    },
    fetchData(id) {
      fetchRecord(id)
        .then(response => {
          this.notification = response.data
          if (this.notification.status === 10) {
            this.$message.error(
              this.$t('crud.notification-error-edit-published')
            )
            this.$router.push('/notification/index')
          }
        })
        .catch(err => {
          console.log(err)
        })
    },
    async submitForm(status) {
      if (this.notification.kabkota_id === null) {
        this.notification.kec_id = null
        this.notification.kel_id = null
        this.notification.rw = null
      } else if (this.notification.kec_id === null) {
        this.notification.kel_id = null
        this.notification.rw = null
      } else if (this.notification.kel_id === null) {
        this.notification.rw = null
      }

      const valid = await this.$refs.notification.validate()

      if (!valid) {
        return
      }

      try {
        this.loading = true
        const data = {}

        Object.assign(data, this.notification)

        data.status = status

        if (this.isEdit) {
          const id = this.$route.params && this.$route.params.id

          await update(id, data)

          this.$message.info(this.$t('crud.draft-success'))

          this.$router.push('/notification/index')
        } else {
          await create(data)
          if (status === 10) {
            this.$message.success(this.$t('crud.send-notification-success'))
            this.$router.push('/notification/index')
          } else if (status === 0) {
            this.$message.info(this.$t('crud.draft-notification-success'))
            this.$router.push('/notification/index')
          }
        }
      } catch (err) {
        console.log(err)
      } finally {
        this.loading = false
      }
    },
    async actionApprove(status) {
      const valid = await this.$refs.notification.validate()

      if (!valid) {
        return
      }

      await this.$confirm(`Apakah anda yakin akan mengirimkan notifikasi : ${this.notification.title} ?`, 'Konfirmasi', {
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
.notification-target,
.notification-message {
  margin: 20px;
}
.rw {
  margin-top: -7px;
}
</style>

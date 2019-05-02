<template>
  <div class="app-container">
    <!-- <p class="warn-content">Tambah Pengguna</p> -->
    <p class="warn-content">Profile Pengguna</p>
    <el-row :gutter="10">
      <!-- Left colomn -->
      <el-col :sm="24" :lg="8" :xl="6" class="grid-content">
        <el-form ref="user" :model="user" :rules="rules">
          <el-form-item label="Photo" prop="photo">
            <div v-if="imageData.length > 0" class="image-preview">
              <img class="preview" :src="imageData">
            </div>
            <input type="file" class="input-image" accept="image/*" @change="onFileSelected">
          </el-form-item>
        </el-form>
      </el-col>

      <!-- Center colomn -->
      <el-col :sm="24" :lg="15" :xl="14" class="grid-content">
        <el-form
          ref="user"
          :model="user"
          status-icon
          label-width="150px"
          label-position="left"
          class="demo-ruleForm"
          :rules="rules"
        >
          <!-- form -->
          <el-form-item label="Username" prop="username">
            <el-input v-model="user.username" type="text" />
          </el-form-item>
          <el-form-item label="Nama Lengkap" prop="name">
            <el-input v-model="user.name" type="text" />
          </el-form-item>

          <el-form-item label="Email" prop="email">
            <el-input v-model="user.email" type="email" />
          </el-form-item>

          <el-form-item label="Password" prop="password">
            <el-input v-model="user.password" type="password" />
          </el-form-item>

          <el-form-item label="Ulangi Password" prop="confirmation">
            <el-input v-model="user.confirmation" type="password" />
          </el-form-item>

          <el-form-item label="Telepon" prop="phone">
            <el-input v-model="user.phone" type="text" placeholder="contoh: 081254332233" />
          </el-form-item>

          <el-row>
            <el-col :span="12">
              <el-form-item label="Peran" prop="role">
                <el-select v-model="user.role" placeholder="Pilih Peran">
                  <el-option
                    v-for="item in filterRole"
                    :key="item.value"
                    :value="item.value"
                    :label="item.label"
                  >{{ item.label }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12" :style="{paddingLeft: formRightSide}">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && checkPermission(['admin', 'staffProv']))"
                label="Kab/Kota"
                prop="kabkota"
              >
                <el-select
                  v-model="user.kabkota"
                  placeholder="Pilih Kab/Kota"
                  @change="getKecamatan"
                >
                  <el-option
                    v-for="item in area"
                    :key="item.id"
                    :value="item"
                    :label="user.kabkota.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && checkPermission(['admin', 'staffProv', 'staffKabkota']))"
                label="Kecamatan"
                prop="kecamatan"
              >
                <el-select
                  v-model="user.kecamatan"
                  placeholder="Pilih Kecamatan"
                  :disabled="user.kabkota == '' && checkPermission(['admin', 'staffProv'])"
                  @change="getKelurahan"
                >
                  <el-option
                    v-for="item in kecamatan"
                    :key="item.id"
                    :value="item"
                    :label="user.kecamatan.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12" :style="{paddingLeft: formRightSide}">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec') && ! checkPermission(['staffKel']))"
                label="Kelurahan"
                prop="kelurahan"
              >
                <el-select v-model="user.kelurahan" placeholder="Pilih Kelurahan" :disabled="user.kecamatan == '' && checkPermission(['admin', 'staffProv', 'staffKabkota'])">
                  <el-option
                    v-for="item in kelurahan"
                    :key="item.id"
                    :value="item"
                    :label="user.kelurahan.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12" />
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec') && !(user.role == 'staffKel'))"
                label="RW"
                prop="rw"
              >
                <el-input v-model="user.rw" type="text" placeholder="Contoh: 001" :disabled="user.kelurahan == '' && checkPermission(['admin', 'staffProv', 'staffKabkota', 'staffKec'])" />
              </el-form-item>
            </el-col>
            <el-col :span="12" class="form-right-side">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec') && !(user.role == 'staffKel'))"
                label="RT"
                prop="rt"
              >
                <el-input v-model="user.rt" type="text" placeholder="Contoh: 002" :disabled="user.rw == '' && checkPermission(['admin', 'staffProv', 'staffKabkota', 'staffKec'])" />
              </el-form-item>
            </el-col>
          </el-row>
          <p class="warn-content">Lokasi pengguna</p>
          <el-row>
            <el-col>
              <el-form-item label="Alamat" prop="address">
                <el-input v-model="user.address" type="text" />
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item label="Latitude" prop="latitude">
                <el-input v-model="user.latitude" type="text" placeholder="Contoh: -6.943097" />
              </el-form-item>
            </el-col>
            <el-col :span="12" class="form-right-side">
              <el-form-item label="Longitude" prop="longitude">
                <el-input v-model="user.longitude" type="text" placeholder="Contoh: 107.633545" />
              </el-form-item>
            </el-col>
          </el-row>
          <p class="warn-content">Media Sosial</p>

          <el-form-item label="Twitter" prop="twitter">
            <el-input v-model="user.twitter" type="text" placeholder="Contoh: jabardigitalservice" />
          </el-form-item>
          <el-form-item label="Facebook" prop="facebook">
            <el-input
              v-model="user.facebook"
              type="text"
              placeholder="Contoh: https://www.facebook.com/jabardigitalservice/"
            />
          </el-form-item>
          <el-form-item label="Instagram" prop="instagram">
            <el-input
              v-model="user.instagram"
              type="text"
              placeholder="Contoh: jabardigitalservice"
            />
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('user')">Tambah Pengguna</el-button>
            <el-button @click="resetForm('user')">Batal</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import checkPermission from '@/utils/permission'
import { requestArea, requestKecamatan, requestKelurahan, createUser, uploadImage } from '@/api/staff'
import { Message } from 'element-ui'
export default {
  data() {
    const checkPhone = (rule, value, callback) => {
      const phoneStringFormat = value.toString()
      const checkStringPhone = phoneStringFormat.startsWith('0')
      if (!checkStringPhone) {
        callback(new Error('Nomor telepon harus dimulai dari 0'))
      } else {
        callback()
      }
    }
    const validatePass = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('Password tolong diisi'))
      } else {
        if (this.user.confirmation !== '') {
          this.$refs.user.validateField('confirmation')
        }
        callback()
      }
    }

    const checkPassword = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('Tolong ulangi password'))
      } else if (value !== this.user.password) {
        callback(new Error('Password tidak sesuai'))
      } else {
        callback()
      }
    }

    return {
      user: {
        username: '',
        name: '',
        email: '',
        password: '',
        confirmation: '',
        phone: '',
        address: '',
        kabkota: [],
        kecamatan: [],
        kelurahan: [],
        rw: '',
        rt: '',
        role: [],
        twitter: '',
        facebook: '',
        instagram: '',
        photo: '',
        latitude: '',
        longitude: ''
      },
      opsiPeran: [
        {
          label: 'Admin Provinsi',
          value: 'staffProv'
        },
        {
          label: 'Admin Kab/kota',
          value: 'staffKabkota'
        },
        {
          label: 'Admin Kecamatan',
          value: 'staffKec'
        },
        {
          label: 'Admin kelurahan',
          value: 'staffKel'
        },
        {
          label: 'RW',
          value: 'staffRW'
        },
        { label: 'Pengguna', value: 'user' }
      ],
      id_kabkota: '',
      id_kec: '',
      id_kel: '',
      area: '',
      kecamatan: '',
      kelurahan: '',
      image: '',
      imageData: '',
      preview: '',
      formRightSide: '10px',
      // validation
      rules: {
        username: [
          {
            required: true,
            message: 'Username harus diisi',
            trigger: 'blur'
          },
          {
            min: 4,
            message: 'Username minimal 4 karakter',
            trigger: 'blur'
          },
          {
            max: 255,
            message: 'Username maksimal 14 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[a-z0-9_.]+$/,
            message:
              'Username hanya boleh menggunakan huruf kecil, angka, underscore dan titik',
            trigger: 'blur'
          }
        ],
        name: [
          {
            required: true,
            message: 'Nama harus diisi',
            trigger: 'blur'
          },
          {
            max: 255,
            message: 'Nama pengguna maksimal 255 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[a-zA-Z.'\s]+$/,
            message: 'Nama hanya boleh menggunakan huruf, aposthrope dan titik',
            trigger: 'blur'
          }
        ],
        email: [
          {
            required: true,
            message: 'Email harus diisi',
            trigger: 'blur'
          },
          {
            max: 255,
            message: 'Alamat email terlalu panjang, maksimal 255 karakter',
            trigger: 'blur'
          },
          {
            type: 'email',
            message: 'Format email yang Anda masukan salah',
            trigger: 'blur'
          }
        ],
        password: [
          {
            max: 255,
            message: 'Password maksimal 255 karakter',
            trigger: 'blur'
          },
          {
            min: 5,
            message: 'Password minimal 5 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[a-zA-Z0-9\w\S]+$/,
            message:
              'Karakter password hanya boleh menggunakan huruf, angka dan spesial karakter',
            trigger: 'blur'
          },
          {
            required: true,
            validator: validatePass,
            trigger: 'blur'
          }
        ],
        confirmation: [
          {
            max: 255,
            message: 'Password maksimal 255 karakter',
            trigger: 'blur'
          },
          {
            min: 5,
            message: 'Password minimal 5 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[a-zA-Z0-9\w\S]+$/,
            message:
              'Karakter password hanya boleh menggunakan huruf, angka dan spesial karakter',
            trigger: 'blur'
          },
          {
            required: true,
            validator: checkPassword,
            trigger: 'blur'
          }
        ],
        phone: [
          {
            required: true,
            message: 'Nomor telepon harus diisi',
            trigger: 'blur'
          },
          {
            min: 3,
            message: 'Nomor telepon minimal 3 karakter',
            trigger: 'blur'
          },
          {
            max: 13,
            message: 'Nomor telepon maksimal 13 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: 'Nomor telepon hanya boleh menggunakan angka',
            trigger: 'blur'
          },
          {
            validator: checkPhone,
            trigger: 'blur'
          }
        ],
        address: [
          {
            required: true,
            message: 'Alamat harus diisi',
            trigger: 'blur'
          },
          {
            max: 255,
            message: 'Alamat maksimal 255 karakter',
            trigger: 'blur'
          }
        ],
        latitude: [
          {
            required: true,
            message: 'Latitude harus diisi, jika tidak ada latitude isi dengan -',
            trigger: 'blur'
          },
          {
            pattern: /^[0-9.+-]+$/,
            message: 'Latitude hanya boleh menggunakan angka, - atau +',
            trigger: 'blur'
          }
        ],
        longitude: [

          {
            required: true,
            message: 'Longitude harus diisi, jika tidak ada longitude isi dengan -',
            trigger: 'blur'
          },
          {
            pattern: /^[0-9.+-]+$/,
            message: 'Longitude hanya boleh menggunakan angka, - atau +',
            trigger: 'blur'
          }
        ],
        kabkota: [
          {
            required: true,
            message: 'Kota harus diisi',
            trigger: 'blur'
          }
        ],
        kecamatan: [
          {
            required: true,
            message: 'Kecamatan harus diisi',
            trigger: 'blur'
          }
        ],
        kelurahan: [
          {
            required: true,
            message: 'Kelurahan harus diisi',
            trigger: 'blur'
          }
        ],
        rw: [
          {
            required: true,
            message: 'RW harus diisi',
            trigger: 'blur'
          },
          {
            max: 3,
            message: 'RW harus 3 angka',
            trigger: 'blur'
          },
          {
            min: 3,
            message: 'RW harus 3 angka',
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: 'RW harus menggunakan angka',
            trigger: 'blur'
          }
        ],
        rt: [
          {
            required: true,
            message: 'RT harus diisi',
            trigger: 'blur'
          },
          {
            max: 3,
            message: 'RT harus 3 angka',
            trigger: 'blur'
          },
          {
            min: 3,
            message: 'RT harus 3 angka',
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: 'RT harus menggunakan angka',
            trigger: 'blur'
          }
        ],
        role: [
          {
            required: true,
            message: 'Peran harus diisi',
            trigger: 'blur'
          }
        ],
        twitter: [
          {
            required: false
          },
          {
            pattern: /^[a-z0-9._]+$/,
            message: 'Twitter hanya boleh menggunakan huruf, angka, titik dan underscore',
            trigger: 'blur'
          }
        ],
        facebook: [
          {
            required: false
          },
          {
            type: 'url',
            message: 'Tolong masukan url lengkap, contoh: https://www.facebook.com/namapengguna',
            trigger: 'blur'
          }
        ],
        instagram: [
          {
            required: false
          },
          {
            pattern: /^[a-z0-9._]+$/,
            message: 'Instagram hanya boleh menggunakan huruf, angka, titik dan underscore',
            trigger: 'blur'
          }
        ]
      }
    }
  },

  computed: {
    parentId() {
      const authUser = this.$store.state.user
      if (checkPermission(['staffKabkota'])) {
        return parseInt(authUser.kabkota_id)
      }
      if (checkPermission(['staffKec'])) {
        return parseInt(authUser.kec_id)
      }
      return null
    },
    parentArea() {
      const authUser = this.$store.state.user
      if (checkPermission(['staffKabkota'])) {
        const staffKabkota = authUser.kabkota_id
        this.parentKabkotaSet(staffKabkota)
      }
      return null
    },
    parentKecamatan() {
      const authUser = this.$store.state.user
      if (checkPermission(['staffKec'])) {
        const staffKecamatan = {
          kabkota: authUser.kabkota_id,
          kecamatan: authUser.kec_id
        }
        this.parentKecamatanSet(staffKecamatan)
      }
      return null
    },
    parentKelurahan() {
      const authUser = this.$store.state.user
      if (checkPermission(['staffKel'])) {
        const staffKelurahan = {
          kabkota: authUser.kabkota_id,
          kecamatan: authUser.kec_id,
          kelurahan: authUser.kel_id
        }
        this.parentKelurahanSet(staffKelurahan)
      }
      return null
    },
    filterRole() {
      const ruleOptions = this.opsiPeran
      if (checkPermission(['admin'])) {
        return ruleOptions
      } if (checkPermission(['staffProv'])) {
        return ruleOptions.slice(2, ruleOptions.length)
      } if (checkPermission(['staffKabkota'])) {
        return ruleOptions.slice(3, ruleOptions.length)
      } if (checkPermission(['staffKec'])) {
        return ruleOptions.slice(4, ruleOptions.length)
      } if (checkPermission(['staffKel'])) {
        return ruleOptions.slice(5, ruleOptions.length)
      }
      return ruleOptions
    }
  },
  created() {
    this.getArea()
    this.parentId
    this.parentArea
    this.parentKecamatan
    this.parentKelurahan
    if (checkPermission(['staffKabkota'])) {
      this.getKecamatan()
    }
    if (checkPermission(['staffKec'])) {
      this.getKelurahan()
      this.formRightSide = '0'
    }
  },

  methods: {
    checkPermission,
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          createUser({
            username: this.user.username,
            name: this.user.name,
            email: this.user.email,
            password: this.user.confirmation,
            phone: this.user.phone,
            address: this.user.address,
            role_id: this.user.role,
            kabkota_id: this.user.kabkota.id || this.id_kabkota,
            kec_id: this.user.kecamatan.id || this.id_kec,
            kel_id: this.user.kelurahan.id || this.id_kel,
            rw: this.user.rw,
            facebook: this.user.facebook,
            twitter: this.user.twitter,
            instagram: this.user.instagram,
            photo_url: this.user.photo,
            lat: this.user.latitude === '-' ? null : this.user.latitude,
            lon: this.user.longitude === '-' ? null : this.user.longitude

          }).then(() => {
            Message({
              message: 'Pengguna berhasil ditambahkan',
              type: 'success',
              duration: 1 * 1000
            })
            setTimeout(() => {
              this.$router.push('/user/user-all')
            }, 1000)
            this.$refs[formName].resetFields()
            this.imageData = 0
          })
            .catch(error => {
              this.$refs[formName].resetFields()
              const usernameError = error.response.data.data.username
              const emailError = error.response.data.data.email
              if (!emailError) {
                Message({
                  message: usernameError[0],
                  type: 'error',
                  duration: 5 * 1000
                })
              } else if (!usernameError) {
                Message({
                  message: emailError[0],
                  type: 'error',
                  duration: 5 * 1000
                })
              } else {
                Message({
                  message: 'Nama pengguna dan alamat email sudah digunakan',
                  type: 'error',
                  duration: 5 * 1000
                })
              }
            })
        } else {
          return false
        }
      })
    },
    resetForm(formName) {
      this.$refs[formName].resetFields()
      this.$router.go(-1)
    },
    parentKabkotaSet(dataKabkota) {
      this.id_kabkota = dataKabkota
    },
    parentKecamatanSet(dataKecamatan) {
      this.id_kabkota = dataKecamatan.kabkota
      this.id_kec = dataKecamatan.kecamatan
    },
    parentKelurahanSet(dataKelurahan) {
      this.id_kabkota = dataKelurahan.kabkota
      this.id_kec = dataKelurahan.kecamatan
      this.id_kel = dataKelurahan.kelurahan
    },
    getArea() {
      requestArea().then(response => {
        this.area = response.data.items
      })
    },
    getKecamatan() {
      if (!(this.user.kabkota.id == null)) {
        this.id_kabkota = this.user.kabkota.id
      } else {
        this.id_kabkota = this.parentId
      }
      requestKecamatan(this.id_kabkota).then(response => {
        this.kecamatan = response.data.items
      })
    },
    getKelurahan() {
      if (!(this.user.kecamatan.id == null)) {
        this.id_kec = this.user.kecamatan.id
      } else {
        this.id_kec = this.parentId
      }
      requestKelurahan(this.id_kec).then(response => {
        this.kelurahan = response.data.items
      })
    },
    // Generate password
    randomPassword(length) {
      var chars =
        'abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890'
      var pass = ''
      for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length)
        pass += chars.charAt(i)
      }
      return pass
    },
    generate() {
      this.user.password = this.randomPassword(8)
    },
    // Upload image
    onFileSelected(event) {
      this.image = event.target.files[0]
      const input = event.target
      if (input.files && input.files[0]) {
        // create a new FileReader to read this image and convert to base64 format
        var reader = new FileReader()
        // Define a callback function to run, when FileReader finishes its job
        reader.onload = (e) => {
          // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
          // Read image as base64 and set to imageData
          this.imageData = e.target.result
        }
        // Start the reader job - read file as a data url (base64 format)
        this.preview = reader.readAsDataURL(input.files[0])
        this.onUpload()
      }
    },
    onUpload() {
      const formData = new FormData()
      formData.append('image', this.image, this.image.name)
      uploadImage(formData).then(response => {
        const link_photo = response.data.photo_url
        const link_photo_name = link_photo.substring(45, link_photo.length)
        this.user.photo = link_photo_name
      }).catch(error => {
        const image_error = error.response.data.status
        if (image_error === 500) {
          Message({
            message: 'Ukuran foto tidak boleh lebih dari 2 MB. Mohon unggah kembali foto Anda',
            type: 'error',
            duration: 5 * 1000
          })
        }
        this.imageData = 0
        this.image = null
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.input-image {
  margin-left:50px;
}
img.preview {
    width: 200px;
    background-color: white;
    border: 1px solid #DDD;
    padding: 5px;
}
.upload-demo {
  margin: 10px auto;
}
.grid-content:first-child {
  margin-bottom: 20px;
}

p {
  color: #42b983;
  font-weight: 600;
}
.app-container {
  padding: 5px 20px;
}

#password {
  .el-row {
    margin-right: 10px;
    &:last-child {
      margin-bottom: 0;
    }
  }
}

.form-right-side {
  padding-left: 10px;
}

.el-row {
  margin-left: 0px;
  &:last-child {
    margin-bottom: 0;
  }
}
.el-col {
  border-radius: 4px;
}
.bg-purple {
  background: #d3dce6;
}
.bg-purple-light {
  background: #e5e9f2;
}
.grid-content {
  border-radius: 4px;
  min-height: 36px;
}
.row-bg {
  padding: 10px 0;
  background-color: #f9fafc;
}
.el-upload .avatar-uploader {
  // border: 5px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
